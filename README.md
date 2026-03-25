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

## 📝 Catatan Penting

-   Semua model utama menggunakan **Soft Delete** — data yang dihapus tidak hilang permanen dari database.
-   Operator yang sedang dalam sesi aktif (activity/task) akan di-redirect ke halaman **idle** hingga sesi selesai.
-   Setiap kali operator menyelesaikan sesi, sistem otomatis membuat sesi **STAND BY** baru.
-   Task mendukung **relasi parent-child** untuk mengelola sub-task di bawah task departemen.
-   Progress task departemen dihitung secara **weighted** berdasarkan `task_load` masing-masing sub-task.
-   Flag `in_timeline` otomatis di-set `false` jika task selesai melewati `schedule_end`.

---

## 📄 Lisensi

Proyek ini dikembangkan untuk kebutuhan internal **PT Tifico Fiber Indonesia Tbk**.
