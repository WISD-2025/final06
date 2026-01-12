# 📚 Final06 圖書館管理系統 (Library Management System)

> Laravel 專題：提供「訪客查書 / 讀者查書與借閱紀錄 / 館員借還書流程 / 管理者書目管理」的一套完整小型圖書館系統。

---

## 1. 系統名稱及主要作用

* **系統名稱**：Final06 圖書館管理系統
* **主要作用**：
    本系統旨在協助圖書館進行自動化管理。
    * **訪客/讀者**：可**查詢館藏**，查看書籍詳情與目前在架上的副本數量；登入後可查看**我的借閱紀錄**。
    * **館員 (Librarian)**：透過後台流通櫃台進行**辦理借書/還書**，並即時查看逾期與借閱總覽。
    * **管理者 (Admin)**：在後台進行**書目管理 (CRUD)**，包含新增書籍資料、建檔 ISBN 與庫存條碼。

---

## 2. 系統主要畫面

> (請將系統截圖放入 `docs/screenshots/` 資料夾中，並確認檔名與下方一致)

### 公共服務 / 前台
* **首頁 / Welcome**
    * <img width="1476" height="831" alt="Welcome" src="https://github.com/user-attachments/assets/6e4466bd-fe3b-47e0-84f8-f3b74c084756" />

    * 說明：系統入口，提供導向功能頁。
* **圖書查詢列表**
    *<img width="1466" height="829" alt="books_index" src="https://github.com/user-attachments/assets/0ffe8c8a-49af-499f-9966-b9083de711c6" />

    * 說明：支援依「書名/作者/ISBN」搜尋，列表即時顯示可借副本數。
* **書籍詳情**
    *<img width="1472" height="828" alt="book_show" src="https://github.com/user-attachments/assets/36b0a29a-e6d6-4b62-bcdd-e0ef4ddb566a" />

    * 說明：顯示書籍基本資料 (Meta Data) 以及各實體副本的條碼與狀態 (Available/Loaned)。

### 讀者 (Member)
* **我的借閱紀錄**
    * <img width="1475" height="828" alt="my_loans" src="https://github.com/user-attachments/assets/58c9858e-29d1-4124-b590-69ca9a7d4f6b" />

    * 說明：顯示個人借閱歷史，包含借出日、到期日、歸還日，並以狀態標籤顯示是否逾期。

### 館員 (Librarian) — 流通櫃台
* **辦理借書**
    * <img width="1473" height="827" alt="image" src="https://github.com/user-attachments/assets/e835a699-74e3-4804-9ae7-f9d2bda15cc0" />

    * 說明：輸入讀者 Email 與書籍副本條碼 (Barcode)，系統自動計算到期日並建立借閱紀錄。
* **辦理還書**
    *<img width="1473" height="825" alt="image" src="https://github.com/user-attachments/assets/6a362a79-e02e-40b2-95e9-6912220e623c" />

    * 說明：輸入副本條碼，系統更新歸還日期 (return_date) 並將書籍狀態改回「可借閱」。
* **借閱紀錄總覽**
    * <img width="1476" height="746" alt="image" src="https://github.com/user-attachments/assets/641979a8-fc97-4059-80f0-ed65deec9c09" />

    * 說明：館員查看全館借閱紀錄，逾期書籍會以紅色字體警示。

### 管理者 (Admin) — 書籍管理
* **後台書籍管理列表**
    * <img width="1473" height="744" alt="image" src="https://github.com/user-attachments/assets/91a9581c-144c-42e7-bf72-d5a10219b50a" />

    * 說明：後台條列式管理，顯示 ISBN、作者與庫存概況。
* **新增書目**
    * <img width="1470" height="747" alt="image" src="https://github.com/user-attachments/assets/ae928c51-234d-4e99-bade-ee6becc0a066" />

    * 說明：建立 `BookTitle` 資料，可同時輸入條碼以建立第一本 `BookCopy`。

---

## 3. 系統主要使用案例與負責同學

| 使用案例 (功能) | 說明 | 負責同學 |
| :--- | :--- | :--- |
| **使用者認證** | 登入/註冊/登出 (Laravel Fortify/Breeze) | **093** |
| **前台圖書查詢** | 列表搜尋 (書名/作者/ISBN) 與顯示可借數 | **093** |
| **書籍詳情頁** | 顯示書籍資訊與副本狀態列表 | **093** |
| **版型整合** | SB Admin 模板整合、權限導覽列顯示 | **093** |
| **README 文件** | 專案文件撰寫與整理 | **093** |
| **我的借閱紀錄** | 讀者查看個人借閱與狀態 | **025** |
| **館員借書流程** | 建立 Loans 紀錄、更新 Copy 狀態 | **025** |
| **館員還書流程** | 更新 Return Date、釋出 Copy 庫存 | **025** |
| **後台書目 CRUD** | 書籍新增/編輯/刪除/搜尋邏輯 | **025** |

---

## 4. 以「使用案例」為單位列出路由 (Routes)

### A. 使用者驗證 (Auth)
* `GET /login` (login) - 登入頁面
* `POST /login` - 執行登入
* `GET /register` (register) - 註冊頁面
* `POST /register` - 執行註冊
* `POST /logout` (logout) - 登出

### B. 前台：圖書查詢
* `GET /books` (books.index)
    * 參數：`?q=` (搜尋關鍵字)
* `GET /books/{id}` (books.show)

### C. 讀者：我的借閱
* `GET /my/loans` (my.loans.index)
    * Middleware: `auth`

### D. 館員：流通櫃台
* `GET /staff/loans` (staff.loans.index) - 借閱總覽
* `GET /staff/loans/create` (staff.loans.create) - 借書表單
* `POST /staff/loans` (staff.loans.store) - 執行借書
* `POST /staff/loans/{id}/return` (staff.loans.return) - 執行還書
    * Middleware: `auth`, `role:librarian/admin`

### E. 管理者：後台書目管理
* `GET /staff/books` (staff.books.index) - 列表與搜尋
* `GET /staff/books/create` (staff.books.create) - 新增表單
* `POST /staff/books` (staff.books.store) - 儲存 (含初始庫存邏輯)
* `GET /staff/books/{id}/edit` (staff.books.edit) - 編輯表單
* `PUT /staff/books/{id}` (staff.books.update) - 更新資料
* `DELETE /staff/books/{id}` (staff.books.destroy) - 刪除
* `POST /staff/books/{id}/copies` (staff.books.add_copy) - 增加副本庫存
    * Middleware: `auth`, `role:admin`

---

## 5. ERD、關聯式綱要圖與資料表設計

### ERD (Mermaid Diagram)

```mermaid
erDiagram
    users ||--o{ loans : "borrows (借閱)"
    book_titles ||--o{ book_copies : "has (擁有副本)"
    book_copies ||--o{ loans : "loan_records (被借紀錄)"

    users {
        bigint id PK
        string name
        string email
        string password
        string role "admin/librarian/member"
        timestamp created_at
    }

    book_titles {
        bigint id PK
        string title "書名"
        string author "作者"
        string isbn
        int published_year
        timestamp created_at
    }

    book_copies {
        bigint id PK
        bigint book_title_id FK
        string barcode "實體條碼"
        string status "available/loaned"
        timestamp created_at
    }

    loans {
        bigint id PK
        bigint book_copy_id FK
        bigint user_id FK
        datetime loan_date "借出日"
        datetime due_date "到期日"
        datetime return_date "歸還日(NULL為未還)"
        string status "loaned/returned"
    }
