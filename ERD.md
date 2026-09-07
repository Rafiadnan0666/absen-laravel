# Entity Relationship Diagram - ABS (Attendance & Employee Management System)

## Mermaid ERD

```mermaid
erDiagram
    USERS ||--o{ DEPARTMENTS : "belongs to"
    USERS ||--o{ JOB_TITLES : "has"
    USERS ||--o{ ROLES : "has"
    USERS ||--o{ ATTENDANCES : "records"
    USERS ||--o{ ATTENDANCE_LOGS : "logs"
    USERS ||--o{ LEAVES : "requests"
    USERS ||--o{ PAYROLLS : "receives"
    USERS ||--o{ REIMBURSEMENTS : "submits"
    USERS ||--o{ FACE_LOGS : "verifies"
    USERS ||--o{ SHIFTS : "assigned"
    USERS ||--o{ LOCATIONS : "checks in at"
    USERS ||--o{ ANNOUNCEMENTS : "receives"
    USERS ||--o{ OVER_TIME_RULES : "governed by"
    USERS ||--o{ SALARY_RULES : "governed by"
    USERS ||--o{ PAYROLL_DETAILS : "has"
    USERS ||--o{ USER_SHIFTS : "assigned"

    DEPARTMENTS {
        bigint id PK
        string nama_department
        text deskripsi
        timestamp created_at
        timestamp updated_at
    }

    JOB_TITLES {
        bigint id PK
        string nama_jabatan
        text deskripsi
        timestamp created_at
        timestamp updated_at
    }

    ROLES {
        bigint id PK
        string nama_role
        text deskripsi
        timestamp created_at
        timestamp updated_at
    }

    USERS {
        bigint id PK
        string nama_lengkap
        string email UK
        string password
        string no_hp
        text alamat
        bigint job_title_id FK
        bigint department_id FK
        bigint role_id FK
        enum tipe_gaji [hourly, daily, monthly]
        decimal jumlah_gaji
        date tanggal_masuk
        enum status_akun [active, inactive]
        json face_embedding
        timestamp created_at
        timestamp updated_at
    }

    ATTENDANCES {
        bigint id PK
        bigint user_id FK
        date tanggal
        time check_in
        time check_out
        enum status_hadir [present, late, absent]
        time jam_kerja
        time jam_lembur
        integer menit_telat
        integer menit_pulang_cepat
        bigint location_id FK
        boolean face_verified
        timestamp created_at
        timestamp updated_at
    }

    ATTENDANCE_LOGS {
        bigint id PK
        bigint user_id FK
        enum tipe_log [check_in, check_out]
        datetime waktu_log
        decimal latitude
        decimal longitude
        string foto_path
        enum device [web, mobile]
        timestamp created_at
        timestamp updated_at
    }

    LEAVES {
        bigint id PK
        bigint user_id FK
        enum tipe_cuti [sick, annual, unpaid]
        date tanggal_mulai
        date tanggal_selesai
        text alasan
        enum status_pengajuan [pending, approved, rejected]
        bigint approved_by FK
        timestamp created_at
        timestamp updated_at
    }

    PAYROLLS {
        bigint id PK
        bigint user_id FK
        date periode_mulai
        date periode_selesai
        decimal gaji_pokok
        decimal total_lembur
        decimal total_potongan
        decimal bonus
        decimal total_gaji
        enum status_pembayaran [pending, paid]
        timestamp created_at
        timestamp updated_at
    }

    PAYROLL_DETAILS {
        bigint id PK
        bigint payroll_id FK
        string komponen
        decimal jumlah
        timestamp created_at
        timestamp updated_at
    }

    REIMBURSEMENTS {
        bigint id PK
        bigint user_id FK
        string kategori
        decimal jumlah
        text deskripsi
        enum status [pending, approved, rejected]
        bigint approved_by FK
        timestamp created_at
        timestamp updated_at
    }

    LOCATIONS {
        bigint id PK
        string nama_lokasi
        decimal latitude
        decimal longitude
        integer radius_meter
        timestamp created_at
        timestamp updated_at
    }

    SHIFTS {
        bigint id PK
        string nama_shift
        time jam_masuk
        time jam_pulang
        integer toleransi_telat_menit
        timestamp created_at
        timestamp updated_at
    }

    HOLIDAYS {
        bigint id PK
        string nama_hari
        date tanggal
        boolean is_national
        timestamp created_at
        timestamp updated_at
    }

    ANNOUNCEMENTS {
        bigint id PK
        string judul
        text konten
        enum target [all, department, role]
        bigint target_id
        timestamp publish_at
        timestamp created_at
        timestamp updated_at
    }

    OVER_TIME_RULES {
        bigint id PK
        string nama_rule
        decimal rate_per_jam
        integer max_jam_per_hari
        boolean active
        timestamp created_at
        timestamp updated_at
    }

    SALARY_RULES {
        bigint id PK
        string nama_rule
        enum tipe_gaji [hourly, daily, monthly]
        decimal base_amount
        json rules
        boolean active
        timestamp created_at
        timestamp updated_at
    }

    FACE_LOGS {
        bigint id PK
        bigint user_id FK
        text embedding
        enum result [matched, unmatched, error]
        decimal confidence
        timestamp created_at
    }

    USER_SHIFTS {
        bigint id PK
        bigint user_id FK
        bigint shift_id FK
        date tanggal_mulai
        date tanggal_selesai
        timestamp created_at
    }

    ROLE_PERMISSIONS {
        bigint id PK
        bigint role_id FK
        bigint permission_id FK
        timestamp created_at
    }

    PERMISSIONS {
        bigint id PK
        string nama_permission
        string guard_name
        timestamp created_at
    }
```

## Table Relationships Summary

| Table | Primary Key | Foreign Keys | Description |
|-------|-------------|--------------|-------------|
| `users` | `id` | `job_title_id`, `department_id`, `role_id` | Core user table with profile, employment, and auth info |
| `departments` | `id` | - | Organizational departments |
| `job_titles` | `id` | - | Job positions/titles |
| `roles` | `id` | - | User roles (Admin, HR, Employee) |
| `permissions` | `id` | - | Granular permissions |
| `role_permissions` | `id` | `role_id`, `permission_id` | Role-Permission many-to-many |
| `shifts` | `id` | - | Work shift definitions |
| `user_shifts` | `id` | `user_id`, `shift_id` | User-Shift assignments with date ranges |
| `locations` | `id` | - | Office locations for GPS check-in |
| `attendances` | `id` | `user_id`, `location_id` | Daily attendance records |
| `attendance_logs` | `id` | `user_id` | Detailed check-in/out logs with GPS |
| `leaves` | `id` | `user_id`, `approved_by` | Leave requests and approvals |
| `payrolls` | `id` | `user_id` | Payroll periods and totals |
| `payroll_details` | `id` | `payroll_id` | Individual payroll components |
| `reimbursements` | `id` | `user_id`, `approved_by` | Expense claims |
| `overtime_rules` | `id` | - | Overtime calculation rules |
| `salary_rules` | `id` | - | Salary calculation rules |
| `holidays` | `id` | - | Company holidays |
| `announcements` | `id` | - | Company announcements |
| `face_logs` | `id` | `user_id` | Face verification logs |

## Key Relationships

1. **User → Department/Job Title/Role**: Many-to-One
2. **User → Attendance**: One-to-Many (daily records)
3. **User → Attendance Logs**: One-to-Many (check-in/out events)
4. **User → Leaves**: One-to-Many (leave requests)
5. **User → Payrolls**: One-to-Many (payroll periods)
6. **User → Reimbursements**: One-to-Many (expense claims)
7. **User → Face Logs**: One-to-Many (face verification)
8. **User → User Shifts**: One-to-Many (shift assignments)
9. **Payroll → Payroll Details**: One-to-Many
10. **Role → Permissions**: Many-to-Many via `role_permissions`

## Indexes

- `users`: email (unique), department_id, job_title_id, role_id
- `attendances`: user_id + tanggal (unique), location_id
- `attendance_logs`: user_id, waktu_log
- `leaves`: user_id, status_pengajuan
- `payrolls`: user_id, periode_mulai
- `reimbursements`: user_id, status