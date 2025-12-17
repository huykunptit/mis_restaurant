# 📊 KẾ HOẠCH TÁCH DATABASE

## Database Schema cho E-commerce Service

### Tables:
1. **users** (chỉ customers)
   - id, name, email, password, phone, role_id (chỉ = 2), created_at, updated_at
   - Index: email (unique)

2. **products** (read-only, sync từ MIS)
   - id, name, price, stock, store_id, created_at, updated_at
   - Foreign key: store_id -> stores.id

3. **stores** (read-only, sync từ MIS)
   - id, name, address, phone, created_at, updated_at

4. **invoices** (orders của customers)
   - id, user_id, store_id, total, payment_id, created_at, updated_at
   - Foreign keys: user_id, store_id, payment_id

5. **invoice_details** (chi tiết orders)
   - id, invoice_id, product_id, quantity, price, created_at, updated_at
   - Foreign keys: invoice_id, product_id

6. **payments** (read-only, sync từ MIS)
   - id, method, bank_id, created_at, updated_at
   - Foreign key: bank_id -> banks.id

7. **banks** (read-only, sync từ MIS)
   - id, name, account_number, account_name, created_at, updated_at

8. **personal_access_tokens** (Laravel Sanctum)
   - id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, created_at, updated_at

---

## Database Schema cho MIS Service

### Tables:
1. **users** (tất cả users - admin và customer)
   - id, name, email, password, phone, role_id, created_at, updated_at
   - Foreign key: role_id -> roles.id

2. **roles**
   - id, name, created_at, updated_at

3. **stores** (CRUD)
   - id, name, address, phone, created_at, updated_at

4. **products** (CRUD)
   - id, name, price, stock, store_id, created_at, updated_at
   - Foreign key: store_id -> stores.id

5. **banks** (CRUD)
   - id, name, account_number, account_name, created_at, updated_at

6. **payments** (CRUD)
   - id, method, bank_id, created_at, updated_at
   - Foreign key: bank_id -> banks.id

7. **invoices** (read-only, sync từ E-commerce hoặc shared)
   - id, user_id, store_id, total, payment_id, created_at, updated_at
   - Foreign keys: user_id, store_id, payment_id

8. **invoice_details** (read-only, sync từ E-commerce)
   - id, invoice_id, product_id, quantity, price, created_at, updated_at
   - Foreign keys: invoice_id, product_id

---

## Data Sync Strategy

### Option 1: Event-Driven (Recommended)
- Khi MIS tạo/cập nhật Product, Store, Bank, Payment → Gửi event → E-commerce sync
- Khi E-commerce tạo Invoice → Gửi event → MIS sync

### Option 2: API Polling
- E-commerce định kỳ gọi API MIS để sync Products, Stores, Banks, Payments
- MIS định kỳ gọi API E-commerce để sync Invoices

### Option 3: Shared Database (Không khuyến nghị cho microservices)
- Chia sẻ một số tables giữa 2 services

---

## Migration Scripts

### E-commerce Database:
```sql
-- Tạo database
CREATE DATABASE ecommerce_db;

-- Chỉ import các tables cần thiết
-- users (với constraint role_id = 2)
-- products, stores, banks, payments (read-only)
-- invoices, invoice_details
-- personal_access_tokens
```

### MIS Database:
```sql
-- Tạo database
CREATE DATABASE mis_db;

-- Import tất cả tables
-- users, roles, stores, products, banks, payments
-- invoices, invoice_details (nếu cần)
```

---

## Foreign Key Constraints

### E-commerce:
- invoices.user_id → users.id (ON DELETE CASCADE)
- invoices.store_id → stores.id (ON DELETE CASCADE)
- invoices.payment_id → payments.id (ON DELETE SET NULL)
- invoice_details.invoice_id → invoices.id (ON DELETE CASCADE)
- invoice_details.product_id → products.id (ON DELETE CASCADE)
- products.store_id → stores.id (ON DELETE CASCADE)
- payments.bank_id → banks.id (ON DELETE SET NULL)

### MIS:
- users.role_id → roles.id (ON DELETE SET NULL)
- products.store_id → stores.id (ON DELETE CASCADE)
- payments.bank_id → banks.id (ON DELETE SET NULL)
- invoices.user_id → users.id (ON DELETE CASCADE)
- invoices.store_id → stores.id (ON DELETE CASCADE)
- invoices.payment_id → payments.id (ON DELETE SET NULL)
- invoice_details.invoice_id → invoices.id (ON DELETE CASCADE)
- invoice_details.product_id → products.id (ON DELETE CASCADE)






