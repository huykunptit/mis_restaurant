# 📋 KIỂM TRA DATABASE - CHECKLIST

## ✅ CÁC BẢNG ĐÃ CÓ

### 1. **Users** ✅
- `id`, `name`, `email`, `password`, `phone`, `role_id`
- ⚠️ **Cần thêm**: `first_name`, `last_name` (nếu chưa có)

### 2. **Roles** ✅
- `id`, `name`

### 3. **Tables** ✅
- `id`, `table_number`, `status`, `seats`, `zone`, `is_merged`, `merged_from`
- ✅ Đã có `zone` (khu vực)

### 4. **Reservations** ✅
- `id`, `user_id`, `table_id`, `menu_id`, `menu_option_id`, `reservation_time`, `status`, `guests`
- ✅ Đã có `guests` (số lượng khách)

### 5. **Transactions** ✅
- `id`, `user_id`, `table_id`, `menu_id`, `menu_option_id`, `quantity`, `remarks`, `completion_status`, `payment_status`
- ✅ Đã có `table_id`
- ⚠️ **Cần thêm**: `staff_id`, `order_group_id`

### 6. **TemporaryOrders** ✅
- `id`, `user_id`, `menu_id`, `menu_option_id`, `quantity`, `remarks`, `table_id`

### 7. **Menus** ✅
- `id`, `name`, `category_id`, `pre_order`, `disable`

### 8. **MenuOptions** ✅
- `id`, `menu_id`, `name`, `cost`

### 9. **Categories** ✅
- `id`, `name`

---

## ⚠️ CẦN THÊM

### 1. **Payments Table** ⚠️
- ❌ Chưa có bảng `payments` riêng
- ✅ **Đã tạo migration**: `2025_12_21_100001_create_payments_table.php`
- Columns:
  - `id`
  - `table_id` (nullable)
  - `order_group_id` (nullable)
  - `payment_method` (enum: sepay_qr, vnpay_qr, bank_transfer, cash)
  - `qr_code_url` (nullable)
  - `amount`
  - `status` (enum: pending, success, failed, cancelled)
  - `payment_gateway_response` (text, nullable)
  - `transaction_id` (nullable)
  - `paid_at` (nullable)
  - `timestamps`

### 2. **Notifications Table** ⚠️
- ❌ Chưa có bảng `notifications`
- ✅ **Đã tạo migration**: `2025_12_21_100002_create_notifications_table.php`
- Columns:
  - `id`
  - `user_id` (nullable)
  - `type` (string: new_order, order_delivered, payment_success)
  - `title`
  - `message`
  - `related_type` (nullable: table, order, payment)
  - `related_id` (nullable)
  - `is_read` (boolean, default: false)
  - `timestamps`

### 3. **Transactions - Thêm columns** ⚠️
- ✅ **Đã tạo migration**: `2025_12_21_100000_add_staff_and_order_group_to_transactions_table.php`
- `staff_id` (nullable, FK to users) - Nhân viên đặt món
- `order_group_id` (string, nullable, indexed) - Group orders cùng bàn, cùng thời gian

---

## 🔍 KIỂM TRA RESERVATIONS

### Status hiện tại:
- ✅ Có bảng `reservations`
- ✅ Có `user_id`, `table_id`
- ✅ Có `reservation_time`
- ✅ Có `status` (enum: pending, confirmed, canceled)
- ✅ Có `guests` (số lượng khách)
- ⚠️ Có `menu_id`, `menu_option_id` (nullable) - **Có vẻ không cần thiết cho đặt bàn**

### Đề xuất:
- Giữ nguyên structure hiện tại
- `menu_id`, `menu_option_id` có thể để null (đặt bàn không cần chọn món trước)

---

## 📝 MIGRATIONS CẦN CHẠY

1. ✅ `2025_12_21_100000_add_staff_and_order_group_to_transactions_table.php`
2. ✅ `2025_12_21_100001_create_payments_table.php`
3. ✅ `2025_12_21_100002_create_notifications_table.php`

---

## 🗑️ XÓA DỮ LIỆU

### Script đã tạo:
- ✅ `database/seeders/ClearDatabaseSeeder.php`

### Chạy lệnh:
```bash
php artisan db:seed --class=ClearDatabaseSeeder
```

### Sẽ xóa:
- ❌ `transactions`
- ❌ `temporary_orders`
- ❌ `reservations`
- ❌ `payments` (nếu có)
- ❌ `notifications` (nếu có)

### Sẽ giữ lại:
- ✅ `users`
- ✅ `roles`
- ✅ `categories`
- ✅ `menus`
- ✅ `menu_options`
- ✅ `tables` (nhưng reset status về 'available')

---

## ✅ TỔNG KẾT

### Đã có:
- ✅ Users, Roles, Tables, Reservations
- ✅ Transactions (cần thêm columns)
- ✅ Menus, MenuOptions, Categories

### Cần thêm:
- ⚠️ Payments table (đã tạo migration)
- ⚠️ Notifications table (đã tạo migration)
- ⚠️ staff_id, order_group_id trong transactions (đã tạo migration)

### Cần chạy:
1. Run migrations mới
2. Run ClearDatabaseSeeder để xóa dữ liệu

---

**Tạo bởi**: AI Assistant  
**Ngày**: 2025-12-21  
**Version**: 1.0

