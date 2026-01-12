# Final06 圖書館管理系統（Library Management System）

> Laravel 專題：提供「訪客查書 / 讀者查書與借閱紀錄 / 館員借還書流程 / 管理者書目管理」的一套完整小型圖書館系統。

---

## 系統名稱與主要作用

**系統名稱：Final06 圖書館管理系統**  
**主要作用：**
- 讓一般使用者（訪客/讀者）可以**查詢館藏**、查看書籍詳情與可借副本數
- 讓讀者登入後可以查看**我的借閱紀錄**
- 讓館員（librarian）可以在後台**辦理借書/還書**並查看借閱總覽
- 讓管理者（admin）可以在後台**管理書目（CRUD）**，包含搜尋、顯示可借副本數等

---



### 公共服務 / 前台
1. **首頁 / Welcome**
   - `docs/screenshots/01_welcome.png`
   - 說明：系統入口，提供導向功能頁。
2. **圖書查詢列表**
   - `docs/screenshots/02_books_index.png`
   - 路徑：`/books`
   - 說明：可用 `q` 依「書名/作者/ISBN」搜尋，列表顯示可借副本數。
3. **書籍詳情**
   - `docs/screenshots/03_books_show.png`
   - 路徑：`/books/{id}`
   - 說明：顯示書籍基本資料 + 各副本條碼與狀態（available/loaned…）。

### 讀者（member）
4. **我的借閱紀錄**
   - `docs/screenshots/04_my_loans.png`
   - 路徑：`/my/loans`
   - 說明：顯示借閱日期、到期日、歸還日、狀態；書名可點回書籍詳情。

### 館員（librarian）— 流通櫃台
5. **辦理借書**
   - `docs/screenshots/05_staff_checkout.png`
   - 路徑：`/staff/loans/checkout`
   - 說明：輸入讀者 Email + 副本條碼 + 借閱天數，建立借閱紀錄並更新副本狀態。
6. **辦理還書**
   - `docs/screenshots/06_staff_return.png`
   - 路徑：`/staff/loans/return`
   - 說明：輸入副本條碼，更新借閱紀錄 return_date/status，並將副本狀態改回 available。
7. **借閱紀錄總覽**
   - `docs/screenshots/07_staff_loans_index.png`
   - 路徑：`/staff/loans`
   - 說明：館員查看全館借閱紀錄（含借出/已歸還）。

### 管理者（admin）— 書籍管理
8. **後台書籍管理列表**
   - `docs/screenshots/08_staff_books_index.png`
   - 路徑：`/staff/books`
   - 說明：可搜尋、可看到每筆書目可借副本數，提供新增/編輯/刪除入口。
9. **新增書目**
   - `docs/screenshots/09_staff_books_create.png`
   - 路徑：`/staff/books/create`
   - 說明：建立 `book_titles` 書目資料（title/author/isbn/published_year）。
10. **編輯/更新/刪除書目**
   - `docs/screenshots/10_staff_books_edit.png`
   - 路徑：`/staff/books/{id}/edit`
   - 說明：修改書目資料、刪除書目（destroy）。

---

## 主要使用案例（功能）與負責同學

> ⚠️ 請將「組長/組員姓名學號」自行替換

| 使用案例（功能） | 說明 | 負責同學 |
|---|---|---|
| 使用者登入/註冊/登出 | 使用 Laravel Starter Kit（Fortify/Breeze）提供驗證流程 | 093負責
| 前台圖書查詢（列表/搜尋） | `/books?q=` 查詢書名/作者/ISBN，顯示可借副本數 |  093負責
| 書籍詳情（副本狀態列表） | `/books/{id}` 顯示副本 barcode/status |  093負責
| 讀者：我的借閱紀錄 | `/my/loans` 顯示個人借閱與狀態 badge |  025負責
| 館員：借書流程 | 建立 loans、更新 book_copies.status |  025負責
| 館員：還書流程 | 更新 loans.return_date/status、book_copies.status |  025負責
| 管理者：後台書目 CRUD | `/staff/books` 列表/搜尋/新增/編輯/刪除 |  025負責
| 版型整合與導覽列權限顯示 | SB Admin 模板整合、依角色顯示左側選單 |  093負責
| README.md檔案 |093負責

---

##  以「使用案例」為單位列出路由（Routes）

### A. 使用者驗證（Auth）
- `GET /login`（login）
- `POST /login`（login.store）
- `GET /register`（register）
- `POST /register`（register.store）
- `POST /logout`（logout）
- 其餘 Fortify/2FA/Verify routes 由套件提供

### B. 前台：圖書查詢（訪客/所有人可看）
**使用案例：查詢書籍**
- `GET /books`（books.index）
  - Query：`q`（書名/作者/ISBN）
- `GET /books/{id}`（books.show）

### C. 讀者：我的借閱
**使用案例：查看我的借閱紀錄**
- `GET /my/loans`（my.loans.index）  
  - Middleware：`auth`

### D. 館員（librarian）：流通櫃台（借/還/總覽）
**使用案例：館員查看借閱總覽**
- `GET /staff/loans`（staff.loans.index）  
  - Middleware：`auth` + `role:librarian`

**使用案例：館員辦理借書**
- `GET /staff/loans/checkout`（staff.loans.create）
- `POST /staff/loans/checkout`（staff.loans.store）  
  - Middleware：`auth` + `role:librarian`

**使用案例：館員辦理還書**
- `GET /staff/loans/return`（staff.loans.return.form）
- `POST /staff/loans/return`（staff.loans.return.store）  
  - Middleware：`auth` + `role:librarian`

### E. 管理者（admin）：後台書目管理（CRUD）
**使用案例：後台書目列表/搜尋**
- `GET /staff/books`（staff.books.index）  
  - Middleware：`auth` + `role:admin`

**使用案例：新增書目**
- `GET /staff/books/create`（staff.books.create）
- `POST /staff/books`（staff.books.store）  
  - Middleware：`auth` + `role:admin`

**使用案例：編輯/更新書目**
- `GET /staff/books/{id}/edit`（staff.books.edit）
- `PUT/PATCH /staff/books/{id}`（staff.books.update）  
  - Middleware：`auth` + `role:admin`

**使用案例：刪除書目**
- `DELETE /staff/books/{id}`（staff.books.destroy）  
  - Middleware：`auth` + `role:admin`

> 備註：角色檢查使用自訂 `RoleMiddleware`（例如 `role:librarian` / `role:admin`）

---

##  ERD、關聯式綱要圖、與資料表欄位設計

### ERD（Mermaid）
```mermaid
erDiagram
  users ||--o{ loans : "borrows"
  book_titles ||--o{ book_copies : "has"
  book_copies ||--o{ loans : "loan_records"

  users {
    bigint id PK
    string name
    string email
    string password
    string role  "admin/librarian/member"
    timestamp created_at
    timestamp updated_at
  }

  book_titles {
    bigint id PK
    string title
    string author
    string isbn
    year published_year
    timestamp created_at
    timestamp updated_at
  }

  book_copies {
    bigint id PK
    bigint book_title_id FK
    string barcode
    string status "available/loaned/maintenance/..."
    timestamp created_at
    timestamp updated_at
  }

  loans {
    bigint id PK
    bigint book_copy_id FK
    bigint user_id FK
    date loan_date
    date due_date
    date return_date "nullable"
    string status "loaned/returned"
    timestamp created_at
    timestamp updated_at
  }
