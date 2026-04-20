<?php

namespace App\Console\Commands;

use App\Models\Tasks;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateParentTaskStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:update-parent-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update parent task status based on child task statuses';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Get all parent tasks (tasks that have children)
            $parentTasks = Tasks::whereHas('children')
                ->with('children')
                ->get();

            $updatedCount = 0;

            foreach ($parentTasks as $parentTask) {
                $children = $parentTask->children;

                // Preserve parent tasks that were manually completed from parent flow
                if (strtoupper((string) $parentTask->status) === 'COMPLETED') {
                    continue;
                }

                // Skip if no children
                if ($children->isEmpty()) {
                    continue;
                }

                // Get all child statuses
                $childStatuses = $children->pluck('status')->toArray();

                // Determine new parent status based on child statuses
                $newStatus = $this->determineParentStatus($childStatuses);

                // Update parent task status if it changed
                if ($parentTask->status !== $newStatus) {
                    $parentTask->update(['status' => $newStatus]);
                    $updatedCount++;
                }
            }

            $this->info("Parent task status update completed. Updated: {$updatedCount} tasks.");
        } catch (\Exception $e) {
            $this->error('Error updating parent task status: ' . $e->getMessage());
            Log::error('Error updating parent task status: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Determine parent task status based on children statuses
     *
     * Logic:
     * 1. If any child has 'ON DUTY' status -> parent status = 'ON PROGRESS'
     * 2. If all children have 'NEW' status -> parent status = 'NEW'
     * 3. Otherwise -> parent status = 'ON HOLD'
     *
     * @param array $childStatuses
     * @return string
     */
    private function determineParentStatus(array $childStatuses): string
    {
        // Normalize statuses to uppercase
        $childStatuses = array_map('strtoupper', $childStatuses);

        // Logic 1: If any child has 'ON DUTY' status, parent becomes 'ON PROGRESS'
        if (in_array('ON DUTY', $childStatuses)) {
            return 'ON PROGRESS';
        }

        // Logic 2: If all children are NEW, parent stays NEW
        if (count(array_unique($childStatuses)) === 1 && $childStatuses[0] === 'NEW') {
            return 'NEW';
        }

        // Logic 3: Default to ON HOLD
        return 'ON HOLD';
    }
}
