# 📊 Dashboard IT — Tifico

Aplikasi web **Dashboard IT** untuk monitoring dan manajemen aktivitas harian tim IT, pengelolaan task departemen & personal, serta pelacakan riwayat aktivitas operator secara real-time.

---

## 📋 Daftar Isi

-   [Tech Stack](#-tech-stack)
-   [Fitur Utama](#-fitur-utama)
-   [Arsitektur & Struktur Folder](#-arsitektur--struktur-folder)
-   [Database Schema](#-database-schema)
-   [Role & Hak Akses](#-role--hak-akses)
-   [Routing](#-routing)
-   [Instalasi & Setup](#-instalasi--setup)
-   [Konfigurasi Environment](#-konfigurasi-environment)
-   [Menjalankan Aplikasi](#-menjalankan-aplikasi)
-   [Seeder Default](#-seeder-default)

---

## 🛠 Tech Stack

| Layer      | Teknologi                        |
| ---------- | -------------------------------- |
| Backend    | PHP 8.1+, Laravel 10             |
| Auth       | Laravel Breeze                   |
| Frontend   | Blade, Tailwind CSS 3, Alpine.js |
| Build Tool | Vite 5                           |
| Database   | MySQL (via XAMPP)                |
| Mail       | SMTP (konfigurasi via `.env`)    |
| API Token  | Laravel Sanctum                  |
| Font       | Libre Bodoni (serif)             |

---

## ✨ Fitur Utama

### 1. Dashboard Management (Role: MANAGEMENT & ADMIN)

-   Monitoring **Stand By** — daftar operator yang sedang standby di IT Office.
-   Monitoring **Outside** — operator yang sedang mengerjakan task atau aktivitas di luar IT Office.
-   Monitoring **Task Progress** — progress task level departemen beserta sub-task, menampilkan weighted progress dan label `completed/total`.

### 2. Dashboard Operator (Role: OPERATOR)

-   Melihat daftar **Activity** yang tersedia (selain STAND BY).
-   **Take Activity** — mengambil aktivitas, otomatis menutup sesi sebelumnya dan membuat sesi baru.
-   **Take Task** — mengambil task personal, otomatis update status ke `ON DUTY`, set `actual_start`, dan membuat activity history.
-   **Idle Page** — halaman tunggu saat operator sedang menjalankan aktivitas/task aktif.
-   **Update Task** — mengupdate progress, status, dan deskripsi task, lalu otomatis kembali ke STAND BY.
-   **Active Session Middleware** — mencegah operator mengambil aktivitas/task baru jika masih ada sesi aktif.

### 3. Manajemen Task

-   **Task Department** — task level departemen yang bisa memiliki sub-task (relasi parent-child).
-   **Task Personal** — task level personal yang di-assign ke operator tertentu.
-   CRUD lengkap (Create, Read, Update, Delete).
-   Status task: `NEW`, `ON DUTY`, `ON HOLD`, `ON PROGRESS`, `COMPLETED`, `CANCELLED`.
-   Tracking: `schedule_start`, `schedule_end`, `actual_start`, `actual_end`.
-   Flag `in_timeline` — otomatis `false` jika `actual_end > schedule_end`.
-   Weighted progress berdasarkan `task_load` pada sub-task.
-   **Mark Complete** — shortcut untuk menyelesaikan task.

### 4. Manajemen Aktivitas (Master Data)

-   CRUD daftar aktivitas (nama, lokasi, deskripsi).
-   Pencarian aktivitas.
-   Aktivitas **STAND BY** dibuat otomatis via seeder sebagai default.

### 5. Activity History

-   Riwayat lengkap semua aktivitas & task yang dijalankan operator.
-   Detail per record: user, referensi (Activity/Task), lokasi, start_time, end_time, durasi.
-   **Filter** berdasarkan rentang tanggal atau preset (1 hari, 7 hari, 1 bulan, 1 tahun).
-   List task per user.
-   Edit & Delete history (khusus role ADMIN).

### 6. Manajemen User

-   CRUD user dengan upload foto profil.
-   Role: `ADMIN`, `MANAGEMENT`, `OPERATOR`.
-   **Soft Delete** — user yang dihapus masuk ke halaman Inactive.
-   **Restore** — mengembalikan user yang sudah di-nonaktifkan.
-   Edit profil pribadi.

### 7. Master Data

-   **Category** — kategori task (nama, tipe).
-   **Location** — lokasi kerja (departemen, lokasi).
-   **End User** — pengguna akhir / peminta (nama, departemen).
-   **End User Department** — departemen end user.

Catatan implementasi saat ini:

-   Model & controller **Priority** dan **Status** tersedia di kode.
-   Route CRUD untuk **Priority** dan **Status** belum dipublikasikan di `routes/web.php`, sehingga belum bisa diakses dari menu utama.
-   Kolom `tasks.priority` saat ini disimpan sebagai nilai string langsung, bukan foreign key ke tabel `priority`.

### 8. Email Notification

-   Notifikasi email via SMTP saat task dibuat.
-   Mailable task umum: `NotifCreate.php`.
-   Mailable task departemen: `NotifCreateActivityDept.php`.

---

## 📁 Arsitektur & Struktur Folder

```
dashboard-it/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardManagementController.php  # Dashboard management
│   │   │   ├── DashboardOperatorController.php     # Dashboard operator
│   │   │   ├── TaskController.php                  # CRUD task department
│   │   │   ├── TaskPersonalController.php          # CRUD task personal
│   │   │   ├── ActivityController.php              # CRUD aktivitas
│   │   │   ├── ActivityHistoryController.php       # Riwayat aktivitas
│   │   │   ├── UserController.php                  # Manajemen user
│   │   │   ├── CategoryController.php              # Master kategori
│   │   │   ├── LocationController.php              # Master lokasi
│   │   │   ├── EndUserController.php               # Master end user
│   │   │   ├── EndUserDepartmentController.php     # Master dept end user
│   │   │   ├── ProfileController.php               # Profil (Breeze default)
│   │   │   └── ProfileNewController.php            # Edit profil custom
│   │   ├── Middleware/
│   │   │   ├── ActiveSession.php      # Cek sesi aktif operator
│   │   │   └── RoleMiddleware.php     # Otorisasi berdasarkan role
│   │   └── Requests/                  # Form Request Validation
│   ├── Mail/
│   │   ├── NotifCreate.php            # Mailable notifikasi task umum
│   │   └── NotifCreateActivityDept.php # Mailable notifikasi task departemen
│   ├── Models/
│   │   ├── User.php                   # User (SoftDeletes)
│   │   ├── Tasks.php                  # Task (parent-child, SoftDeletes)
│   │   ├── Activity.php               # Aktivitas (SoftDeletes)
│   │   ├── ActivityHistory.php        # Riwayat aktivitas (SoftDeletes)
│   │   ├── Category.php               # Kategori (SoftDeletes)
│   │   ├── Location.php               # Lokasi (SoftDeletes)
│   │   ├── EndUser.php                # End user (SoftDeletes)
│   │   ├── Priority.php               # Prioritas (SoftDeletes)
│   │   └── Status.php                 # Status (SoftDeletes)
│   └── View/Components/              # Blade components
├── resources/views/
│   ├── layouts/                       # Layout utama
│   ├── components/                    # UI components
│   ├── auth/                          # Halaman login/register (Breeze)
│   └── pages/
│       ├── dashboard_management/      # View dashboard management
│       ├── dashboard_operator/        # View dashboard operator + idle
│       ├── task/                      # View CRUD task department
│       ├── task_personal/             # View CRUD task personal
│       ├── activity/                  # View CRUD aktivitas
│       ├── activity_history/          # View riwayat aktivitas
│       ├── user/                      # View manajemen user
│       ├── category/                  # View master kategori
│       ├── location/                  # View master lokasi
│       ├── enduser/                   # View master end user
│       ├── enduser_department/        # View master dept end user
│       ├── priority/                  # View master prioritas
│       ├── status/                    # View master status
│       └── profile/                   # View edit profil
├── routes/
│   ├── web.php                        # Routing utama
│   ├── auth.php                       # Routing autentikasi (Breeze)
│   └── api.php                        # API routes (Sanctum)
├── database/
│   ├── migrations/                    # Skema database
│   └── seeders/
│       └── DatabaseSeeder.php         # Seed admin + STAND BY activity
└── config/                            # Konfigurasi Laravel
```

---

## 🗃 Database Schema

### Tabel Utama

| Tabel                | Deskripsi                                                                                                                       |
| -------------------- | ------------------------------------------------------------------------------------------------------------------------------- |
| `users`              | Data user (name, email, password, phone, role, photo) — Soft Delete                                                             |
| `tasks`              | Data task (name, priority [string], category, assign_to, task_level, status, progress, schedule, actual, dll.) — Soft Delete    |
| `activities`         | Master aktivitas (name, location, description) — Soft Delete                                                                    |
| `activity_histories` | Log riwayat aktivitas (user_id, reference_id, reference_type, location, status, start_time, end_time, deleted_at) — Soft Delete |
| `category_lists`     | Master kategori (name, type) — Soft Delete                                                                                      |
| `location_lists`     | Master lokasi (department, location) — Soft Delete                                                                              |
| `endusers`           | Master end user (name, department) — Soft Delete                                                                                |
| `priority`           | Master prioritas (name) — Soft Delete (controller tersedia, route CRUD belum aktif)                                             |
| `status`             | Master status (name) — Soft Delete (controller tersedia, route CRUD belum aktif)                                                |

### Relasi Antar Tabel

```
User ──┬── hasMany ──> Tasks (assign_to)
       └── hasMany ──> ActivityHistory (user_id)

Tasks ──┬── belongsTo ──> Category (category_id)
        ├── belongsTo ──> Location (location_id)
        ├── belongsTo ──> EndUser (enduser_id)
        ├── belongsTo ──> User (assign_to)
        ├── belongsTo ──> Tasks [parent] (relation_task)
        └── hasMany ────> Tasks [children] (relation_task)

ActivityHistory ──┬── belongsTo ──> User (user_id)
                  ├── belongsTo ──> Tasks (reference_id, when type = 'TASK')
                  └── belongsTo ──> Activity (reference_id, when type = 'ACTIVITY')

Category ──── hasMany ──> Tasks (category_id)
Location ──── hasMany ──> Tasks (location_id)
EndUser  ──── hasMany ──> Tasks (enduser_id)
```

---

## 🔐 Role & Hak Akses

| Fitur                          | ADMIN | MANAGEMENT | OPERATOR |
| ------------------------------ | :---: | :--------: | :------: |
| Dashboard Management           |  ✅   |     ✅     |    ❌    |
| Dashboard Operator             |  ✅   |     ❌     |    ✅    |
| Manajemen Task Department      |  ✅   |     ✅     |    ❌    |
| Task Personal (CRUD)           |  ✅   |     ✅     |    ✅    |
| Take Activity / Task           |  ✅   |     ❌     |    ✅    |
| Activity History (View)        |  ✅   |     ✅     |    ❌    |
| Activity History (Edit/Delete) |  ✅   |     ❌     |    ❌    |
| Manajemen User                 |  ✅   |     ✅     |    ❌    |
| Restore User Inactive          |  ✅   |     ✅     |    ❌    |
| Master Data (CRUD)             |  ✅   |     ✅     |    ✅    |
| Edit Profil                    |  ✅   |     ✅     |    ✅    |

### Middleware

| Middleware         | Keterangan                                                                 |
| ------------------ | -------------------------------------------------------------------------- |
| `auth`             | Autentikasi pengguna                                                       |
| `verified`         | Email terverifikasi                                                        |
| `role:ROLE1,ROLE2` | Otorisasi berdasarkan role user (`RoleMiddleware`)                         |
| `active.session`   | Cek sesi aktif operator, redirect ke idle jika masih ada (`ActiveSession`) |

---

## 🔀 Routing

### Public

| Method | URI | Keterangan                  |
| ------ | --- | --------------------------- |
| GET    | `/` | Redirect ke login/dashboard |

### Authenticated Redirect

| Method | URI          | Keterangan                                                                                          |
| ------ | ------------ | --------------------------------------------------------------------------------------------------- |
| GET    | `/dashboard` | Redirect otomatis berdasarkan role: OPERATOR -> dashboard operator, lainnya -> dashboard management |

### Authenticated — Semua Role

| Method   | URI                                 | Controller                                     | Keterangan             |
| -------- | ----------------------------------- | ---------------------------------------------- | ---------------------- |
| Resource | `/category`                         | `CategoryController`                           | CRUD kategori          |
| Resource | `/activity`                         | `ActivityController`                           | CRUD aktivitas         |
| Resource | `/location`                         | `LocationController`                           | CRUD lokasi            |
| Resource | `/enduser`                          | `EndUserController`                            | CRUD end user          |
| Resource | `/enduser-department`               | `EndUserDepartmentController`                  | CRUD dept end user     |
| Resource | `/task/personal`                    | `TaskPersonalController`                       | CRUD task personal     |
| GET      | `/task-{id}`                        | `TaskController@getTask`                       | Get task JSON          |
| GET      | `/dashboard/operator`               | `DashboardOperatorController@index`            | Dashboard operator     |
| POST     | `/dashboard_operator/take/{id}`     | `DashboardOperatorController@takeActivity`     | Ambil aktivitas        |
| PUT      | `/dashboard_operator/complete/{id}` | `DashboardOperatorController@completeActivity` | Selesaikan sesi        |
| GET      | `/activity/active/{id}`             | `DashboardOperatorController@idle`             | Halaman idle aktivitas |
| GET      | `/active_task/{id}`                 | `DashboardOperatorController@takeTask`         | Ambil task             |
| GET      | `/task/active/{id}`                 | `DashboardOperatorController@idleTask`         | Halaman idle task      |
| PUT      | `/task/update/{id}`                 | `DashboardOperatorController@updateTask`       | Update task aktif      |
| GET      | `/profile/edit/{id}`                | `ProfileNewController@edit`                    | Edit profil            |
| PUT      | `/profile/update`                   | `ProfileNewController@update`                  | Update profil          |
| GET      | `/export-activity`                  | `ActivityController@export`                    | Export activity list   |

### Management & Admin Only

| Method   | URI                                  | Controller                             | Keterangan              |
| -------- | ------------------------------------ | -------------------------------------- | ----------------------- |
| GET      | `/dashboard/management`              | `DashboardManagementController@index`  | Dashboard management    |
| Resource | `/task/department`                   | `TaskController`                       | CRUD task department    |
| PUT      | `/task/{id}/complete`                | `TaskController@complete`              | Mark task selesai       |
| Resource | `/user`                              | `UserController`                       | CRUD user               |
| GET      | `/user-inactive`                     | `UserController@inactive`              | Daftar user nonaktif    |
| PUT      | `/user/{id}/restore`                 | `UserController@restore`               | Restore user            |
| GET      | `/activity_history`                  | `ActivityHistoryController@index`      | Riwayat aktivitas       |
| GET      | `/activity_history/{id}`             | `ActivityHistoryController@show`       | Detail history          |
| GET      | `/activity_history/list/{id}`        | `ActivityHistoryController@list`       | Task list per user      |
| GET      | `/activity_history/list/{id}/filter` | `ActivityHistoryController@listFilter` | Filter history per user |
| GET      | `/export-task-department`            | `TaskController@export`                | Export task department  |

### Admin Only

| Method | URI                           | Controller                          | Keterangan     |
| ------ | ----------------------------- | ----------------------------------- | -------------- |
| GET    | `/activity_history/{id}/edit` | `ActivityHistoryController@edit`    | Edit history   |
| PUT    | `/activity_history/{id}`      | `ActivityHistoryController@update`  | Update history |
| DELETE | `/activity_history/{id}`      | `ActivityHistoryController@destroy` | Hapus history  |

### Authenticated Profile (Breeze Default)

| Method | URI        | Controller                  | Keterangan            |
| ------ | ---------- | --------------------------- | --------------------- |
| GET    | `/profile` | `ProfileController@edit`    | Edit profil (default) |
| PATCH  | `/profile` | `ProfileController@update`  | Update profil         |
| DELETE | `/profile` | `ProfileController@destroy` | Hapus akun            |

---

## 🚀 Instalasi & Setup

### Prasyarat

-   **PHP** >= 8.1
-   **Composer** >= 2.x
-   **Node.js** >= 18.x & **npm**
-   **MySQL** >= 5.7 / MariaDB >= 10.3
-   **XAMPP** (opsional, atau web server lain)

### Langkah Instalasi

```bash
# 1. Clone repository
git clone <repository-url> dashboard-it
cd dashboard-it

# 2. Install dependencies PHP
composer install

# 3. Install dependencies Node.js
npm install

# 4. Salin file environment
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Buat database MySQL baru (contoh: dashboard_it)

# 7. Konfigurasi .env (lihat bagian Konfigurasi Environment)

# 8. Jalankan migrasi database
php artisan migrate

# 9. Jalankan seeder (membuat admin, activity default, dan category default)
php artisan db:seed

# 10. Buat symbolic link untuk storage
php artisan storage:link

# 11. Build assets frontend
npm run build
```

---

## ⚙ Konfigurasi Environment

Edit file `.env` sesuai environment lokal:

```env
APP_NAME="Dashboard IT"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost/dashboard-it/public

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dashboard_it
DB_USERNAME=root
DB_PASSWORD=

# Mail (SMTP)
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your-email@example.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="Dashboard IT"
```

---

## ▶ Menjalankan Aplikasi

### Development

```bash
# Terminal 1 — Vite dev server (hot reload)
npm run dev

# Terminal 2 — Laravel dev server (opsional jika tidak pakai XAMPP)
php artisan serve
```

### Production

```bash
npm run build
```

Akses aplikasi:

-   **XAMPP**: `http://localhost/dashboard-it/public`
-   **Artisan Serve**: `http://localhost:8000`

---

## 🌱 Seeder Default

Seeder membuat data awal berikut:

| Data           | Detail                                                                                                                                   |
| -------------- | ---------------------------------------------------------------------------------------------------------------------------------------- |
| **User Admin** | Name: `admin`, Email: `admin@tifico.co.id`, Password: `1`, Role: `ADMIN`                                                                 |
| **Activity**   | `STAND BY`, `MUSHALLA`, `TOILET`, `MASJID`, `PANTRY`, `KANTIN`, `OUT OF OFFICE`                                                          |
| **Category**   | `ADMINISTRATION`, `HARDWARE INSTALLATION`, `SOFTWARE DEVELOPMENT`, `SUPERVISORY`, `MEETING`, `ROUTINE WORK`, `TROUBLESHOOTING`, `OTHERS` |

Catatan implementasi saat ini:

-   Seeder default belum membuat user role **MANAGEMENT** dan **OPERATOR**.
-   Seeder default belum mengisi tabel **priority** dan **status**.

```bash
php artisan db:seed
```

---

## � Dokumentasi Fungsi & APIs

### 1. Task Management Controllers

#### A. TaskController (Task Departemen)

**Lokasi:** `app/Http/Controllers/TaskController.php`

| Method       | HTTP      | URI                          | Deskripsi                                           | Middleware              |
| ------------ | --------- | ---------------------------- | --------------------------------------------------- | ----------------------- |
| `index()`    | GET       | `/task/department`           | Tampilkan daftar task departemen dengan pagination  | `role:ADMIN,MANAGEMENT` |
| `create()`   | GET       | `/task/department/create`    | Tampilkan form create task departemen               | `role:ADMIN,MANAGEMENT` |
| `store()`    | POST      | `/task/department`           | Simpan task departemen baru ke database             | `role:ADMIN,MANAGEMENT` |
| `show()`     | GET       | `/task/department/{id}`      | Tampilkan detail task departemen                    | `role:ADMIN,MANAGEMENT` |
| `edit()`     | GET       | `/task/department/{id}/edit` | Tampilkan form edit task departemen                 | `role:ADMIN,MANAGEMENT` |
| `update()`   | PUT/PATCH | `/task/department/{id}`      | Update task departemen                              | `role:ADMIN,MANAGEMENT` |
| `destroy()`  | DELETE    | `/task/department/{id}`      | Soft delete task departemen                         | `role:ADMIN,MANAGEMENT` |
| `complete()` | PUT       | `/task/{id}/complete`        | Mark task as completed (100%)                       | `role:ADMIN,MANAGEMENT` |
| `getTask()`  | GET       | `/task-{id}`                 | Get task data as JSON (untuk AJAX)                  | `auth`                  |
| `export()`   | GET       | `/export-task-department`    | Export task ke Excel dengan optional filter tanggal | `role:ADMIN,MANAGEMENT` |

**Flow Store Task Departemen:**

```
Manager → POST /task/department
  ↓
TaskController@store()
  ├─ Validate dengan StoreTaskRequest
  ├─ Buat/cari EndUser (jika belum ada)
  ├─ Buat/cari Location
  ├─ Create Tasks record dengan:
  │  ├─ name, priority, category_id, location_id
  │  ├─ enduser_id, assign_to, task_level = 'DEPARTMENT'
  │  ├─ status = 'NEW', progress = 0, in_timeline = true
  │  └─ schedule_start, schedule_end
  ├─ Jika parent task ada: attach children via relation_task
  ├─ Send email notification ke assignee (jika configured)
  └─ Redirect dengan success message
```

#### B. TaskPersonalController (Task Personal)

**Lokasi:** `app/Http/Controllers/TaskPersonalController.php`

| Method      | HTTP      | URI                        | Deskripsi                                 | Middleware |
| ----------- | --------- | -------------------------- | ----------------------------------------- | ---------- |
| `index()`   | GET       | `/task/personal`           | Tampilkan daftar task personal (my tasks) | `auth`     |
| `create()`  | GET       | `/task/personal/create`    | Form create task personal                 | `auth`     |
| `store()`   | POST      | `/task/personal`           | Simpan task personal baru                 | `auth`     |
| `show()`    | GET       | `/task/personal/{id}`      | Detail task personal                      | `auth`     |
| `edit()`    | GET       | `/task/personal/{id}/edit` | Form edit task personal                   | `auth`     |
| `update()`  | PUT/PATCH | `/task/personal/{id}`      | Update task personal                      | `auth`     |
| `destroy()` | DELETE    | `/task/personal/{id}`      | Delete task personal                      | `auth`     |

**Flow Take Task (Ambil Task Personal):**

```
Operator → GET /active_task/{id}
  ↓
DashboardOperatorController@takeTask()
  ├─ Check: apakah user punya active session?
  │    └─ Ya → Redirect ke /activity/active/{id} (idle)
  ├─ End previous session (set end_time, hitung durasi)
  ├─ Create ActivityHistory baru:
  │  ├─ user_id = Auth::id()
  │  ├─ reference_type = 'TASK'
  │  ├─ reference_id = {task_id}
  │  ├─ start_time = now()
  │  └─ location = request location
  ├─ Update task:
  │  ├─ status = 'ON DUTY'
  │  ├─ progress = 10%
  │  ├─ actual_start = now()
  │  └─ Attach to pivot table (taken = 1)
  ├─ Jika task punya parent: update parent status → 'ON PROGRESS'
  ├─ Redirect ke /task/active/{id}
  └─ Display idle task screen dengan timer
```

---

### 2. Dashboard Controllers

#### A. DashboardOperatorController

**Lokasi:** `app/Http/Controllers/DashboardOperatorController.php`

| Method               | HTTP | URI                                 | Deskripsi                | Purpose                                    |
| -------------------- | ---- | ----------------------------------- | ------------------------ | ------------------------------------------ |
| `index()`            | GET  | `/dashboard/operator`               | Main operator dashboard  | Display active jobs queue & personal tasks |
| `takeActivity()`     | POST | `/dashboard_operator/take/{id}`     | Take/start activity      | Start work session on activity             |
| `completeActivity()` | PUT  | `/dashboard_operator/complete/{id}` | Complete activity        | End activity session                       |
| `takeTask()`         | GET  | `/active_task/{id}`                 | Take/start personal task | Start work session on personal task        |
| `updateTask()`       | PUT  | `/task/update/{id}`                 | Update active task       | Update task progress & status              |
| `idle()`             | GET  | `/activity/active/{id}`             | Idle activity screen     | Display ongoing activity session           |
| `idleTask()`         | GET  | `/task/active/{id}`                 | Idle task screen         | Display ongoing task session               |

**Data Returned (index):**

```php
[
  'standbys' => Collection of standby activities,
  'activities' => Collection of available activities (not STAND BY),
  'activeActivity' => Current active activity session (if any),
  'personalTasks' => Personal tasks yang belum di-assign/not started,
  'activeTask' => Current active personal task (if any),
  'completedTasks' => Completed tasks history (today)
]
```

#### B. DashboardManagementController

**Lokasi:** `app/Http/Controllers/DashboardManagementController.php`

| Method    | HTTP | URI                     | Deskripsi     | Purpose                          |
| --------- | ---- | ----------------------- | ------------- | -------------------------------- |
| `index()` | GET  | `/dashboard/management` | KPI dashboard | Monitor team performance & tasks |

**Logic Flow:**

```
GET /dashboard/management
  ↓
DashboardManagementController@index()
  ├─ Get all users (OPERATOR role)
  │   └─ For each user:
  │      ├─ Check latest ActivityHistory
  │      ├─ Determine status: AT OFFICE, ON FIELD, UNKNOWN
  │      ├─ Get assigned tasks
  │      └─ Calculate task progress (weighted)
  ├─ Get all department tasks
  │   ├─ Calculate parent task progress = SUM(child_load × progress) / SUM(child_load)
  │   └─ Flag in_timeline status
  ├─ Get absence data (cutoff 4:30 PM untuk hari ini)
  ├─ Prepare KPI metrics:
  │   ├─ Total operators online/offline
  │   ├─ Task progress overview
  │   ├─ Absence summary
  │   └─ Task completion rate
  └─ Return data ke view
```

**Data Returned:**

```php
[
  'users' => [
    'id' => user_id,
    'name' => user name,
    'status' => 'AT_OFFICE' | 'ON_FIELD' | 'UNKNOWN',
    'lastLocation' => location string,
    'tasks' => [assigned tasks array],
    'taskProgress' => percentage
  ],
  'tasks' => [
    'departmentTasks' => all department tasks with progress,
    'totalProgress' => weighted average,
    'inTimeline' => count of in-timeline tasks,
    'completed' => count of completed tasks
  ],
  'absences' => [absences from today]
]
```

---

### 3. Master Data Controllers

#### A. UserController

**Lokasi:** `app/Http/Controllers/UserController.php`

| Method       | HTTP      | URI                  | Deskripsi                          | Middleware              |
| ------------ | --------- | -------------------- | ---------------------------------- | ----------------------- |
| `index()`    | GET       | `/user`              | List semua user (active only)      | `role:ADMIN,MANAGEMENT` |
| `create()`   | GET       | `/user/create`       | Form create user                   | `role:ADMIN,MANAGEMENT` |
| `store()`    | POST      | `/user`              | Simpan user baru                   | `role:ADMIN,MANAGEMENT` |
| `show()`     | GET       | `/user/{id}`         | Detail user                        | `role:ADMIN,MANAGEMENT` |
| `edit()`     | GET       | `/user/{id}/edit`    | Form edit user                     | `role:ADMIN,MANAGEMENT` |
| `update()`   | PUT/PATCH | `/user/{id}`         | Update user + photo upload         | `role:ADMIN,MANAGEMENT` |
| `destroy()`  | DELETE    | `/user/{id}`         | Soft delete user                   | `role:ADMIN,MANAGEMENT` |
| `inactive()` | GET       | `/user-inactive`     | List soft-deleted (inactive) users | `role:ADMIN,MANAGEMENT` |
| `restore()`  | PUT       | `/user/{id}/restore` | Restore soft-deleted user          | `role:ADMIN,MANAGEMENT` |

**Store User Flow:**

```
Admin → POST /user
  ↓
UserController@store()
  ├─ Validate input (name, email, password, role, phone)
  ├─ Hash password
  ├─ Handle photo upload → storage/app/public/users/
  ├─ Create User record dengan:
  │  ├─ name, email, hashed password
  │  ├─ phone, role (ADMIN|MANAGEMENT|OPERATOR)
  │  ├─ photo path (jika ada)
  │  └─ email_verified_at = null
  ├─ Send welcome email (optional)
  └─ Redirect dengan success
```

#### B. ActivityController

**Lokasi:** `app/Http/Controllers/ActivityController.php`

| Method      | HTTP      | URI                   | Deskripsi                     | Middleware              |
| ----------- | --------- | --------------------- | ----------------------------- | ----------------------- |
| `index()`   | GET       | `/activity`           | List master activities        | `auth`                  |
| `create()`  | GET       | `/activity/create`    | Form create activity          | `role:ADMIN,MANAGEMENT` |
| `store()`   | POST      | `/activity`           | Simpan activity baru          | `role:ADMIN,MANAGEMENT` |
| `show()`    | GET       | `/activity/{id}`      | Detail activity               | `auth`                  |
| `edit()`    | GET       | `/activity/{id}/edit` | Form edit activity            | `role:ADMIN,MANAGEMENT` |
| `update()`  | PUT/PATCH | `/activity/{id}`      | Update activity               | `role:ADMIN,MANAGEMENT` |
| `destroy()` | DELETE    | `/activity/{id}`      | Delete activity (soft)        | `role:ADMIN,MANAGEMENT` |
| `export()`  | GET       | `/export-activity`    | Export activity list to Excel | `auth`                  |

#### C. Other Master Data Controllers

| Controller                      | URI                   | Methods                                           | Purpose                                         |
| ------------------------------- | --------------------- | ------------------------------------------------- | ----------------------------------------------- |
| **CategoryController**          | `/category`           | index, create, store, show, edit, update, destroy | Manage task categories                          |
| **LocationController**          | `/location`           | index, create, store, show, edit, update, destroy | Manage work locations                           |
| **EndUserController**           | `/enduser`            | index, create, store, show, edit, update, destroy | Manage end users (clients/contacts)             |
| **EndUserDepartmentController** | `/enduser-department` | index, create, store, show, edit, update, destroy | Manage end user departments                     |
| **AbsenController**             | `/absen`              | index, create, store, show, edit, update, destroy | Manage absences/leaves                          |
| **PriorityController**          | `/priority`           | index, create, store, show, edit, update, destroy | Manage task priorities (not exposed in web.php) |
| **StatusController**            | `/status`             | index, create, store, show, edit, update, destroy | Manage task statuses (not exposed in web.php)   |

---

### 4. Activity & History Controllers

#### A. ActivityHistoryController

**Lokasi:** `app/Http/Controllers/ActivityHistoryController.php`

| Method         | HTTP      | URI                                      | Deskripsi                        | Middleware              |
| -------------- | --------- | ---------------------------------------- | -------------------------------- | ----------------------- |
| `index()`      | GET       | `/activity_history`                      | List semua activity history      | `role:ADMIN,MANAGEMENT` |
| `show()`       | GET       | `/activity_history/{id}`                 | Detail activity history record   | `role:ADMIN,MANAGEMENT` |
| `list()`       | GET       | `/activity_history/list/{userId}`        | List history per user            | `role:ADMIN,MANAGEMENT` |
| `listFilter()` | GET       | `/activity_history/list/{userId}/filter` | Filter history dengan date range | `role:ADMIN,MANAGEMENT` |
| `edit()`       | GET       | `/activity_history/{id}/edit`            | Form edit history (admin only)   | `role:ADMIN`            |
| `update()`     | PUT/PATCH | `/activity_history/{id}`                 | Update history record            | `role:ADMIN`            |
| `destroy()`    | DELETE    | `/activity_history/{id}`                 | Delete history record            | `role:ADMIN`            |

**Activity History Record Structure:**

```php
[
  'id' => id,
  'user_id' => user who performed activity,
  'reference_type' => 'ACTIVITY' | 'TASK' | 'JOB',
  'reference_id' => activity_id/task_id,
  'location' => location string,
  'start_time' => timestamp,
  'end_time' => timestamp,
  'duration' => calculated in minutes,
  'description' => optional notes
]
```

#### B. ProfileNewController

**Lokasi:** `app/Http/Controllers/ProfileNewController.php`

| Method     | HTTP      | URI                  | Deskripsi             | Middleware |
| ---------- | --------- | -------------------- | --------------------- | ---------- |
| `edit()`   | GET       | `/profile/edit/{id}` | Form edit profil user | `auth`     |
| `update()` | PUT/PATCH | `/profile/update`    | Update profil user    | `auth`     |

---

## 🔄 Data Flow Diagrams

### Flow 1: Operator Mengambil Task Departemen

```
┌─────────────────────────────────────────────────────────────────┐
│ OPERATOR TAKES DEPARTMENT TASK FLOW                             │
└─────────────────────────────────────────────────────────────────┘

START: Operator click "Take Activity" on Dashboard
  │
  ├──→ DashboardOperatorController::index()
  │      └─ Display available activities
  │
  ├──→ Operator selects activity
  │
  ├──→ POST /dashboard_operator/take/{activityId}
  │
  ├──→ DashboardOperatorController::takeActivity()
  │      │
  │      ├─ Check: Active session exists?
  │      │   ├─ YES → End previous session (end_time = now)
  │      │   │        Calculate duration
  │      │   │        Update ActivityHistory
  │      │   │
  │      │   └─ NO → Continue
  │      │
  │      ├─ Create NEW ActivityHistory:
  │      │   ├─ user_id = Auth::id()
  │      │   ├─ reference_type = 'ACTIVITY'
  │      │   ├─ reference_id = activityId
  │      │   ├─ location = from form/session
  │      │   ├─ start_time = Carbon::now()
  │      │   └─ end_time = null (ongoing)
  │      │
  │      └─ Redirect to /activity/active/{activityId}
  │
  ├──→ Display Idle Screen with Timer
  │
  └──→ Operator completes activity
       │
       └─→ PUT /dashboard_operator/complete/{historyId}
           │
           └─→ Update ActivityHistory:
               ├─ end_time = now()
               ├─ duration = calculated
               └─ Redirect to dashboard/operator (STAND BY)

END
```

### Flow 2: Manager Creates Department Task & Assigns to Operator

```
┌─────────────────────────────────────────────────────────────────┐
│ CREATE & ASSIGN DEPARTMENT TASK FLOW                            │
└─────────────────────────────────────────────────────────────────┘

START: Manager navigates to /task/department/create
  │
  ├──→ TaskController::create()
  │      └─ Render form dengan:
  │         ├─ Categories dropdown
  │         ├─ Locations dropdown
  │         ├─ Users dropdown (for assign_to)
  │         ├─ End users dropdown (or create new)
  │         └─ Parent task selector (for sub-tasks)
  │
  ├──→ Manager fills form and submits
  │
  ├──→ POST /task/department
  │
  ├──→ TaskController::store()
  │      │
  │      ├─ Validate input (StoreTaskRequest)
  │      │
  │      ├─ Create/Find EndUser
  │      │   └─ If create new: EndUser::create()
  │      │
  │      ├─ Create/Find Location
  │      │   └─ If create new: Location::create()
  │      │
  │      ├─ Create Tasks record:
  │      │   ├─ name, description
  │      │   ├─ category_id, location_id
  │      │   ├─ enduser_id, assign_to (user_id)
  │      │   ├─ priority (string), task_level = 'DEPARTMENT'
  │      │   ├─ status = 'NEW'
  │      │   ├─ progress = 0
  │      │   ├─ schedule_start, schedule_end
  │      │   ├─ in_timeline = true
  │      │   └─ relation_task = parent_id (if sub-task)
  │      │
  │      ├─ Send Email Notification to assignee
  │      │   │
  │      │   ├─ Build email using NotifCreateActivityDept mailable
  │      │   ├─ Filter by MAIL_ALLOWED_DOMAINS
  │      │   ├─ Queue for sending (retry 3x if failed)
  │      │   │
  │      │   └─ Log notification sent
  │      │
  │      └─ Redirect with success message
  │
  ├──→ Assigned Operator receives email notification
  │
  ├──→ Operator logs in and sees new task on dashboard
  │
  └──→ Operator can:
       ├─ Click "Take Task" → Start session
       │   └─ Creates ActivityHistory
       │   └─ Updates task status to ON_DUTY
       │   └─ Redirect to idle screen
       │
       └─ Or schedule for later

END
```

### Flow 3: Task Progress Calculation (Weighted)

```
┌─────────────────────────────────────────────────────────────────┐
│ WEIGHTED TASK PROGRESS CALCULATION                              │
└─────────────────────────────────────────────────────────────────┘

SCENARIO: Parent task has 3 subtasks with different loads

  Parent Task (ID: 1)
    ├─ SubTask 1: task_load = 30%, progress = 50% → Contribution = 30% × 50% = 15%
    ├─ SubTask 2: task_load = 40%, progress = 100% → Contribution = 40% × 100% = 40%
    └─ SubTask 3: task_load = 30%, progress = 0% → Contribution = 30% × 0% = 0%

  Parent Progress = (15% + 40% + 0%) = 55%


TRIGGER: When subtask is updated (on Dashboard Management load)

  DashboardManagementController::index()
    │
    ├─ For each parent task:
    │   │
    │   ├─ Get all children (where relation_task = parent_id)
    │   │
    │   ├─ Calculate: weightedProgress = 0
    │   │   For each child:
    │   │     ├─ child_contribution = (child.task_load / 100) × (child.progress / 100)
    │   │     ├─ weightedProgress += child_contribution
    │   │     └─ Aggregate by sum
    │   │
    │   ├─ Update parent task:
    │   │   └─ progress = weightedProgress
    │   │
    │   ├─ Check timeline:
    │   │   ├─ If progress == 100 && actual_end > schedule_end:
    │   │   │   └─ in_timeline = false
    │   │   │   └─ Flag as LATE
    │   │   │
    │   │   └─ Else:
    │   │       └─ in_timeline = true
    │   │
    │   └─ Persist to database
    │
    └─ Display updated progress on dashboard (with color coding)

END
```

### Flow 4: Absence Notification System

```
┌─────────────────────────────────────────────────────────────────┐
│ ABSENCE/LEAVE NOTIFICATION FLOW                                 │
└─────────────────────────────────────────────────────────────────┘

START: Admin/Management creates absence record
  │
  ├──→ GET /absen (or /absen/create)
  │
  ├──→ AbsenController::create() or store()
  │      │
  │      ├─ Validate input (user_id, date, reason)
  │      │
  │      ├─ Create Absen record
  │      │
  │      ├─ Trigger: Send Absence Notification
  │      │   │
  │      │   ├─ Get all users (broadcast to all)
  │      │   │
  │      │   ├─ Filter emails by MAIL_ALLOWED_DOMAINS
  │      │   │
  │      │   ├─ Build email using NotifAbsen mailable
  │      │   │   ├─ Include:
  │      │   │   │  ├─ Absent user name
  │      │   │   │  ├─ Date of absence
  │      │   │   │  ├─ Reason
  │      │   │   │  └─ Generated at
  │      │   │   │
  │      │   │   └─ Template: resources/views/emails/absence.blade.php
  │      │   │
  │      │   ├─ Send via Mail::to($emails)->send($mailable)
  │      │   │
  │      │   └─ Retry 3x if failed (queue retry logic)
  │      │
  │      └─ Log notification sent
  │
  ├──→ All staff receive absence notification email
  │
  └──→ On dashboard/management:
       └─ Absence data pulled cutoff 4:30 PM
          (for today's absence tracking)

END
```

---

## 📊 Model Relationships & Data Structure

### Complete Model Diagrams

**User Model:**

```php
class User {
  Has Many: tasks (via assign_to)
  Has Many: delivered_tasks (via ask_to)
  Has Many: created_tasks (via created_by)
  Has Many: activity_histories (via user_id)
  Has Many: absences (via user_id)

  Properties:
    - id, name, email, password
    - phone, photo, role
    - email_verified_at, deleted_at (SoftDeletes)
}
```

**Tasks Model:**

```php
class Tasks {
  Belongs To: category (category_id)
  Belongs To: location (location_id)
  Belongs To: enduser (enduser_id)
  Belongs To: assignee User (assign_to)
  Belongs To: parent Task (relation_task)
  Has Many: children Tasks (relation_task)
  Has Many: activity_histories (polymorphic)

  Properties:
    - id, name, description
    - priority (string), category_id, location_id
    - enduser_id, assign_to (user_id)
    - task_level ('DEPARTMENT' | 'PERSONAL')
    - status ('NEW' | 'ON_DUTY' | 'ON_HOLD' | 'ON_PROGRESS' | 'COMPLETED' | 'CANCELLED')
    - progress (percentage 0-100)
    - task_load (percentage, for weighted calculation)
    - schedule_start, schedule_end
    - actual_start, actual_end
    - in_timeline (boolean)
    - relation_task (parent_id)
    - deleted_at (SoftDeletes)
}
```

**ActivityHistory Model (for tracking):**

```php
class ActivityHistory {
  Belongs To: user (user_id)
  Belongs To: activity or task (polymorphic reference_type/reference_id)

  Properties:
    - id
    - user_id (who performed activity)
    - reference_type ('ACTIVITY' | 'TASK' | 'JOB')
    - reference_id (id of activity/task)
    - location (string)
    - start_time, end_time
    - duration (calculated in minutes)
    - description (optional)
    - deleted_at (SoftDeletes)
}
```

---

## 🔌 Email Notification System

### Mailable Classes

| File                                   | Purpose                      | Triggered                 | Domain Filtering           |
| -------------------------------------- | ---------------------------- | ------------------------- | -------------------------- |
| `app/Mail/NotifCreate.php`             | General task notification    | Task created              | Yes (MAIL_ALLOWED_DOMAINS) |
| `app/Mail/NotifCreateActivityDept.php` | Department task notification | Department task created   | Yes                        |
| `app/Mail/NotifAbsen.php`              | Absence broadcast            | Absence recorded          | Yes                        |
| `app/Mail/NotifNoActivity.php`         | No activity alert            | (Optional/custom trigger) | Yes                        |

### Configuration

**Environment (.env):**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="Dashboard IT"

# Domain whitelist for email sending
MAIL_ALLOWED_DOMAINS=tifico.co.id,tificoventures.com
```

---

## 💾 Excel Export Functions

### Export Task Department

**Handler:** `TaskController::export()`

**URL:** `GET /export-task-department`

**Parameters:**

-   `start_date` (optional): Format Y-m-d
-   `end_date` (optional): Format Y-m-d

**Returns:** Excel file `Task_Department_{Y-m-d_H-i-s}.xlsx`

**Columns in Export:**

-   Task ID, Name, Priority, Category
-   Location, Assigned To, Status, Progress
-   Schedule Start, Schedule End, Actual Start, Actual End
-   In Timeline, Description

### Export Activity List

**Handler:** `ActivityController::export()`

**URL:** `GET /export-activity`

**Parameters:** None (exports all activities)

**Returns:** Excel file `Activity_List_{Y-m-d_H-i-s}.xlsx`

**Columns in Export:**

-   Activity ID, Name, Location, Description

---

## 🛡 Middleware & Authorization

### RoleMiddleware

**File:** `app/Http/Middleware/RoleMiddleware.php`

**Usage:** `role:ADMIN,MANAGEMENT,OPERATOR`

**Logic:**

```
if user not authenticated → redirect to login
if user's role not in allowed roles → abort 403 Forbidden
else → proceed
```

### ActiveSession Middleware

**File:** `app/Http/Middleware/ActiveSession.php`

**Usage:** Routes yang require session check

**Logic:**

```
Check: Does user have active ActivityHistory (end_time = null)?
  ├─ YES:
  │  └─ Store active session info in session
  │  └─ User can interact but cannot take new activity/task
  │     (automatic redirect to idle page)
  │
  └─ NO:
     └─ Proceed normally
```

---

## 📝 Catatan Penting

-   Semua model utama menggunakan **Soft Delete** — data yang dihapus tidak hilang permanen dari database.
-   Operator yang sedang dalam sesi aktif (activity/task) akan di-redirect ke halaman **idle** hingga sesi selesai.
-   Setiap kali operator menyelesaikan sesi, sistem otomatis membuat sesi **STAND BY** baru.
-   Task mendukung **relasi parent-child** untuk mengelola sub-task di bawah task departemen.
-   Progress task departemen dihitung secara **weighted** berdasarkan `task_load` masing-masing sub-task.
-   Flag `in_timeline` otomatis di-set `false` jika task selesai melewati `schedule_end`.
-   Email notification hanya dikirim ke domain yang terdaftar di `MAIL_ALLOWED_DOMAINS`.
-   Setiap email notification memiliki retry logic 3x jika gagal terkirim.

---

## 📄 Lisensi

Proyek ini dikembangkan untuk kebutuhan internal **PT Tifico Fiber Indonesia Tbk**.
