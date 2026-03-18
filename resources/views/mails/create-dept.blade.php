<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Department Activity Notification</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;

        }

        .email-card {
            max-width: 650px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .header {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            padding: 40px 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .header-icon {
            font-size: 64px;
            margin-bottom: 20px;
            position: relative;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .header h1 {
            color: white;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 18px;
            position: relative;
        }

        .content {
            padding: 40px;
            background: #ffffff;
        }

        .job-section {
            background: linear-gradient(135deg, #f8f9fc 0%, #eaecf4 100%);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid rgba(78, 115, 223, 0.1);
        }

        .job-title {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px dashed #4e73df;
        }

        .job-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: white;
            box-shadow: 0 10px 20px rgba(78, 115, 223, 0.3);
        }

        .job-name {
            flex: 1;
        }

        .job-name h2 {
            color: #2c3e50;
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .job-name span {
            color: #4e73df;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
            margin-bottom: 30px;
        }

        .info-item {
            background: white;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .info-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(78, 115, 223, 0.15);
        }

        .info-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #7f8c8d;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        .info-label i {
            font-size: 16px;
        }

        .priority-badge {
            display: inline-block;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .priority-high {
            background: linear-gradient(135deg, #fca5a5 0%, #ef4444 100%);
            color: white;
        }

        .priority-medium {
            background: linear-gradient(135deg, #fcd34d 0%, #f59e0b 100%);
            color: white;
        }

        .priority-low {
            background: linear-gradient(135deg, #6ee7b7 0%, #10b981 100%);
            color: white;
        }

        .schedule-container {
            background: white;
            border-radius: 16px;
            padding: 25px;
            margin-top: 20px;
            border: 1px solid #e9ecef;
        }

        .schedule-header {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #4e73df;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 7px;
            top: 10px;
            bottom: 10px;
            width: 2px;
            background: linear-gradient(to bottom, #4e73df, #224abe);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-dot {
            position: absolute;
            left: -30px;
            top: 5px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #4e73df;
            border: 3px solid white;
            box-shadow: 0 0 0 2px #4e73df;
        }

        .timeline-date {
            font-size: 18px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .timeline-time {
            color: #4e73df;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .timeline-label {
            color: #7f8c8d;
            font-size: 14px;
        }

        .duration-badge {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
            padding: 15px 25px;
            border-radius: 50px;
            display: inline-block;
            font-weight: 700;
            font-size: 16px;
            margin-top: 20px;
            box-shadow: 0 10px 20px rgba(78, 115, 223, 0.3);
        }

        .footer {
            background: #f8f9fc;
            padding: 30px 40px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }

        .btn {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 20px;
            box-shadow: 0 10px 25px rgba(78, 115, 223, 0.4);
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(78, 115, 223, 0.5);
        }

        .footer-note {
            color: #95a5a6;
            font-size: 14px;
            line-height: 1.8;
        }

        .company-info {
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e9ecef;
            font-size: 13px;
            color: #95a5a6;
        }

        @media only screen and (max-width: 600px) {
            .content {
                padding: 10px;
            }

            .job-section {
                padding: 10px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .job-title {
                flex-direction: column;
                text-align: center;
            }

            .header h1 {
                font-size: 26px;
            }
        }

        .uppercase {
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <!-- Content utama -->
    <div class="content">
        <div class="job-section">
            <!-- Job Title dengan Icon -->
            <div class="job-title">
                <div class="job-icon">⚡</div>
                <div class="job-name">
                    <h2 class="uppercase">{{ $data->name }}</h2>
                    <span>Department Activity</span>
                </div>
            </div>

            <!-- Grid informasi -->
            <div class="info-grid">
                <!-- Priority Card -->
                <div class="info-item">
                    <div class="info-label">
                        <span>⚡</span> Priority Level
                    </div>
                    @php
                        $priorityClass = '';
                        if (strtolower($data->priority) == 'high' || strtolower($data->priority) == 'tinggi') {
                            $priorityClass = 'priority-high';
                        } elseif (strtolower($data->priority) == 'medium' || strtolower($data->priority) == 'sedang') {
                            $priorityClass = 'priority-medium';
                        } elseif (strtolower($data->priority) == 'low' || strtolower($data->priority) == 'rendah') {
                            $priorityClass = 'priority-low';
                        }
                    @endphp
                    <div>
                        <span class="priority-badge {{ $priorityClass }}">
                            {{ $data->priority }}
                        </span>
                    </div>
                </div>


                <!-- Schedule Section dengan Timeline -->
                <div class="schedule-container">
                    <div class="schedule-header">
                        <span>📅</span> Schedule Timeline
                    </div>

                    @php
                        $start = \Carbon\Carbon::parse($data->schedule_start);
                        $end = \Carbon\Carbon::parse($data->schedule_end);
                        $hours = $start->diffInHours($end);
                        $days = $start->diffInDays($end);
                        $isOngoing = $start->isPast() && $end->isFuture();
                        $isUpcoming = $start->isFuture();
                        $isCompleted = $end->isPast();
                    @endphp

                    <div class="timeline">
                        <!-- Start Time -->
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-label">START</div>
                            <div class="timeline-date">{{ $start->format('l, d F Y') }}</div>
                            <div class="timeline-time">{{ $start->format('H:i') }} WIB</div>
                        </div>

                        <!-- End Time -->
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-label">END</div>
                            <div class="timeline-date">{{ $end->format('l, d F Y') }}</div>
                            <div class="timeline-time">{{ $end->format('H:i') }} WIB</div>
                        </div>
                    </div>

                    <!-- Duration Badge -->
                    <div style="text-align: center; margin-top: 25px;">
                        <span class="duration-badge">
                            ⏱️ Duration:
                            @if ($days > 0)
                                {{ $days }} day{{ $days > 1 ? 's' : '' }}
                                ({{ $hours }} hours)
                            @else
                                {{ $hours }} hour{{ $hours > 1 ? 's' : '' }}
                            @endif
                        </span>
                    </div>

                    <div class="schedule-header">
                        <span>📝</span> Description
                    </div>
                    <div class="timeline">
                        <!-- Start Time -->
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-label">Description</div>
                            <div class="timeline-date">{{ $data->description }}</div>
                        </div>
                    </div>

                </div>


                <!-- Additional Info -->

            </div>

            <!-- Footer dengan CTA -->
            <div class="footer">
                <div class="footer-note">
                    <strong>Need help?</strong> Contact your supervisor<br>
                </div>
                <div class="company-info">
                    © {{ date('Y') }} PT.TIFICO FIBER INDONESIA,Tbk . All rights reserved.<br>
                    IT Department
                </div>
            </div>
        </div>
</body>

</html>
