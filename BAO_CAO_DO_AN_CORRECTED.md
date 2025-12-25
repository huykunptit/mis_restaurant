# LỜI MỞ ĐẦU

Trong bối cảnh công nghệ số hóa phát triển, ngành dịch vụ ăn uống (F&B) đang đối mặt với nhiều thách thức trong việc quản lý vận hành nhà hàng: ghi nhận đơn hàng tại bàn, theo dõi món chưa giao, quản lý trạng thái bàn, và quy trình thanh toán. Việc phụ thuộc vào sổ giấy hoặc ghi chú thủ công dễ gây nhầm lẫn, thất thoát dữ liệu và làm chậm tốc độ phục vụ.

Đối với nhà hàng hiện đại, một hệ thống quản lý tập trung là cần thiết để hỗ trợ **nhân viên (staff)** đặt món nhanh tại bàn, theo dõi trạng thái món theo thời gian thực, tạo thanh toán QR, và cung cấp cho **quản lý (admin)** công cụ quản trị menu, nhân sự, ca làm và chấm công. Ngoài ra, hệ thống có thể tích hợp thêm kênh đặt món trực tuyến cho khách hàng (customer) như một tính năng mở rộng tùy chọn.

Xuất phát từ thực tiễn trên, nhóm chúng em chọn thực hiện đề tài: **"Xây dựng hệ thống quản lý nhà hàng (Restaurant Management System)"**.

Thông qua quá trình thực hiện, nhóm hy vọng đề tài không chỉ giúp nâng cao kỹ năng phân tích, thiết kế và phát triển phần mềm, mà còn mang lại một giải pháp thực tiễn hỗ trợ vận hành nhà hàng hiệu quả, áp dụng trực tiếp vào dự án `mis_restaurant`.

---

# MỤC LỤC

- LỜI CẢM ƠN (I)
- LỜI MỞ ĐẦU (II)
- DANH MỤC HÌNH VẼ
- DANH MỤC BẢNG BIỂU

## CHƯƠNG 1: GIỚI THIỆU ĐỀ TÀI

- 1.1 Giới thiệu về TPS – Hệ thống xử lý giao dịch (Transaction Processing Systems)
  - 1.1.1 Khái niệm giao dịch và đặc trưng của TPS
  - 1.1.2 Vai trò của TPS trong doanh nghiệp
  - 1.1.3 Kết luận
- 1.2 Lý do chọn đề tài
- 1.3 Vấn đề thực tế mà đề tài giải quyết
- 1.4 Yêu cầu hệ thống
- 1.5 Mục tiêu và chức năng hệ thống
  - 1.5.1 Mục tiêu của hệ thống
  - 1.5.2 Chức năng của hệ thống

## CHƯƠNG 2: CÔNG NGHỆ SỬ DỤNG

- 2.1 Front-End
  - 2.1.1 HTML
  - 2.1.2 CSS
  - 2.1.3 JavaScript
  - 2.1.4 Blade Template + Livewire
- 2.2 Back-End
  - 2.2.1 PHP
  - 2.2.2 Laravel Framework + Eloquent ORM
  - 2.2.3 Livewire + Event/Broadcasting
- 2.3 Database
- 2.4 Một số dịch vụ bên thứ 3
  - 2.4.1 Thanh toán QR (SePay/VNPay/Chuyển khoản) và dịch vụ tạo QR

## CHƯƠNG 3: PHÂN TÍCH VÀ THIẾT KẾ HỆ THỐNG

- 3.1 Biểu đồ usecase
  - 3.1.1 Biểu đồ usecase tổng quan hệ thống
  - 3.1.2 Các usecase phân rã
- 3.2 Xây dựng kịch bản
  - 3.2.1 Các kịch bản chính (staff/admin)
  - 3.2.2 Các kịch bản mở rộng (customer - tùy chọn)
- 3.3 Xây dựng biểu đồ lớp phân tích
  - 3.3.1 Biểu đồ lớp phân tích
  - 3.3.2 Xác định quan hệ giữa các lớp
- 3.4 Thiết kế các biểu đồ tuần tự
- 3.5 Thiết kế cơ sở dữ liệu
  - 3.5.1 Lược đồ cơ sở dữ liệu hệ thống
  - 3.5.2 Cơ sở dữ liệu vật lý

## CHƯƠNG 4: CÀI ĐẶT ỨNG DỤNG

- 4.1 Hướng dẫn chạy source code web
- 4.2 Giao diện hệ thống staff
  - 4.2.1 Giao diện chọn bàn/đặt món
  - 4.2.2 Giao diện quản lý đơn theo bàn
  - 4.2.3 Giao diện thanh toán (tạo QR/xác nhận)
- 4.3 Giao diện hệ thống admin
  - 4.3.1 Giao diện quản lý danh mục/menu
  - 4.3.2 Giao diện quản lý nhân sự/ca làm/chấm công
  - 4.3.3 Giao diện quản lý người dùng
- 4.4 Giao diện hệ thống customer (mở rộng - tùy chọn)
  - 4.4.1 Giao diện menu/giỏ hàng
  - 4.4.2 Giao diện checkout/lịch sử đơn

## CHƯƠNG 5: KẾT LUẬN VÀ ĐÁNH GIÁ

- 5.1 Kết quả đạt được
- 5.2 Các hạn chế
- 5.3 Định hướng phát triển

## TÀI LIỆU THAM KHẢO

---

# CHƯƠNG 1: GIỚI THIỆU ĐỀ TÀI

## 1.1 Giới thiệu về TPS – Hệ thống xử lý giao dịch (Transaction Processing Systems)

### 1.1.1 Khái niệm giao dịch và đặc trưng của TPS

Trong hệ thống quản lý nhà hàng, **giao dịch (transaction)** là các thao tác nghiệp vụ phát sinh liên tục và cần độ chính xác cao, ví dụ: tạo đơn đặt món, cập nhật trạng thái món (đã/chưa hoàn thành), xác nhận thanh toán.

Với dự án `mis_restaurant`, các giao dịch thể hiện rõ ở luồng **chính**:

- **Staff đặt món tại bàn**: staff chọn bàn → chọn món → tạo `order_group_id` (ví dụ `ORD-ABC123`) để gom nhiều dòng `Transaction` (mỗi món là một dòng) thành một nhóm đơn theo bàn.
- **Staff thanh toán**: chọn các `order_group_id` cần thanh toán → tạo QR (nếu thanh toán QR) → xác nhận thanh toán → cập nhật `payment_status` và trạng thái bàn.

TPS (Transaction Processing System) là hệ thống chuyên xử lý các giao dịch và đảm bảo dữ liệu **nhất quán**. Trong code, các nghiệp vụ quan trọng (đặt món, tạo payment, xác nhận thanh toán) đều được bao trong **DB transaction** (`DB::beginTransaction()`), giúp đảm bảo tính nguyên tử: hoặc thành công toàn bộ, hoặc rollback.

**Tính năng mở rộng (tùy chọn)**: Hệ thống cũng hỗ trợ customer đặt món online với giỏ hàng `TemporaryOrder` → checkout tạo `Transaction`, nhưng đây **không phải luồng chính** của dự án.

### 1.1.2 Vai trò của TPS trong doanh nghiệp

TPS giúp nhà hàng vận hành ổn định:

- **Giảm sai sót** khi ghi nhận món/giá/số lượng.
- **Tăng tốc phục vụ**: staff chọn bàn → đặt món nhanh → theo dõi món chưa giao.
- **Thanh toán minh bạch**: tính tổng tiền theo nhóm đơn, tạo QR, xác nhận và cập nhật trạng thái bàn.
- **Dễ kiểm soát**: truy vết lịch sử theo bàn/nhân viên/thời gian.

### 1.1.3 Kết luận

Dự án `mis_restaurant` là TPS ứng dụng vào bài toán quản lý nhà hàng, tập trung vào tính đúng đắn của dữ liệu đặt món và thanh toán bởi staff.

## 1.2 Lý do chọn đề tài

- Nhu cầu số hóa vận hành nhà hàng tăng: quản lý đặt món theo bàn, theo dõi món, thanh toán QR.
- Cần giảm phụ thuộc vào giấy/ghi chú thủ công, tránh thất thoát đơn và nhầm lẫn khi giao ca.
- Cần hệ thống tập trung hỗ trợ **vận hành nội bộ** (staff đặt món/thanh toán, admin quản lý menu/nhân sự).
- (Mở rộng) Có thể bổ sung kênh đặt món online cho customer nếu cần.

## 1.3 Vấn đề thực tế mà đề tài giải quyết

- **Staff cần đặt món nhanh tại bàn**: chọn bàn → chọn món → gom đơn theo lượt gọi món (`order_group_id`) → theo dõi trạng thái món đã/chưa hoàn thành.
- **Thanh toán linh hoạt**: hỗ trợ nhiều phương thức (QR/tiền mặt/chuyển khoản), cho phép thanh toán sớm và "trừ món" trước khi tạo thanh toán.
- **Quản lý vận hành**: admin cần công cụ quản lý menu/danh mục, quản lý nhân sự/ca làm/chấm công, theo dõi thông báo đơn mới/thanh toán.
- **Giảm thất thoát**: dữ liệu đơn hàng được lưu vào database, tránh mất đơn khi giao ca.
- (Mở rộng) Khách hàng có thể đặt món online qua giỏ hàng nếu hệ thống bật tính năng này.

## 1.4 Yêu cầu hệ thống

### Yêu cầu chức năng

**Luồng chính (staff/admin - vận hành nội bộ):**

- **Staff**: chọn bàn, đặt món nhanh (tạo `order_group_id`), xem đơn theo bàn, cập nhật trạng thái món (hoàn thành/hủy), thanh toán (tạo QR, xác nhận), cập nhật trạng thái bàn.
- **Admin**: quản lý danh mục/menu, quản lý người dùng (staff/customer), ca làm/chấm công, xem thông báo đơn mới/thanh toán.
- **Thông báo**: phát sinh đơn mới/thanh toán thành công có notification real-time (hỗ trợ broadcast Redis).

**Luồng mở rộng (tùy chọn - customer online):**

- **Customer** (nếu bật): xem menu, thêm giỏ hàng (`TemporaryOrder`), checkout tạo đơn, xem lịch sử đơn hàng.

### Yêu cầu phi chức năng

- **Độ tin cậy**: các thao tác tạo đơn/thanh toán phải đảm bảo rollback khi lỗi.
- **Bảo mật**: xác thực và phân quyền theo middleware (customer/staff/admin).
- **Hiệu năng**: truy vấn theo bàn/nhóm đơn rõ ràng; UI đủ nhanh khi đông người dùng.
- **Khả năng mở rộng**: dễ tích hợp payment gateway thật (SePay/VNPay webhook) về sau.

## 1.5 Mục tiêu và chức năng hệ thống

### 1.5.1 Mục tiêu của hệ thống

- Xây dựng hệ thống quản lý nhà hàng tập trung vào vận hành nội bộ (staff đặt món/thanh toán, admin quản lý).
- Chuẩn hóa dữ liệu đặt món và thanh toán theo tư duy TPS (đảm bảo tính nhất quán).
- Cung cấp công cụ vận hành hiệu quả cho staff/admin, giảm thiểu sai sót thủ công.
- (Mở rộng) Hỗ trợ kênh đặt món online cho customer nếu cần.

### 1.5.2 Chức năng của hệ thống

Hình minh họa usecase tổng quan và phân rã được cung cấp trong **Phụ lục A**.

---

# CHƯƠNG 2: CÔNG NGHỆ SỬ DỤNG

## 2.1 Front-End

### 2.1.1 HTML

HTML xây dựng cấu trúc các trang: staff chọn bàn/đặt món/thanh toán, admin quản lý menu/nhân sự, (tùy chọn) customer menu/giỏ hàng.

### 2.1.2 CSS

Dự án sử dụng TailwindCSS (kết hợp CSS tùy chỉnh) để đảm bảo giao diện nhất quán và responsive.

### 2.1.3 JavaScript

JavaScript phục vụ tương tác UI (cập nhật tổng tiền, chọn món/checkbox khi thanh toán), gọi API/AJAX. Dự án sử dụng Axios và Turbolinks.

### 2.1.4 Blade Template + Livewire

- **Blade** là template engine của Laravel để render giao diện server-side.
- **Livewire** hỗ trợ xây dựng UI động theo hướng component (phù hợp cho các màn hình có tương tác và refresh dữ liệu).

## 2.2 Back-End

### 2.2.1 PHP

Backend được xây dựng bằng PHP, đáp ứng tốt cho hệ thống web CRUD và nghiệp vụ giao dịch.

### 2.2.2 Laravel Framework + Eloquent ORM

- Laravel cung cấp routing, middleware, auth, validation, và cấu trúc dự án rõ ràng.
- Eloquent ORM ánh xạ model–database, hỗ trợ query và quan hệ dữ liệu.
- Các controller tiêu biểu: `StaffOrderController`, `PaymentController` (luồng chính), `CartController`, `CheckoutController` (luồng mở rộng).

### 2.2.3 Livewire + Event/Broadcasting

Hệ thống có event/broadcasting để phục vụ thông báo thời gian thực: `NewOrderCreated`, `PaymentSuccess` (có cấu hình Redis broadcasting).

## 2.3 Database

Hệ thống sử dụng MySQL (phù hợp triển khai qua Docker). Các bảng chính: `menus`, `menu_options`, `transactions`, `payments`, `tables`, `users`, `temporary_orders` (mở rộng). Lược đồ tham khảo trong **Phụ lục A**.

## 2.4 Một số dịch vụ bên thứ 3

### 2.4.1 Thanh toán QR (SePay/VNPay/Chuyển khoản) và dịch vụ tạo QR

Trong luồng thanh toán staff, hệ thống hỗ trợ nhiều **payment method**: `sepay_qr`, `vnpay_qr`, `bank_transfer`, `cash`. Hiện tại phần tạo QR sử dụng dịch vụ QR công khai (QRServer API) như placeholder, đã chuẩn bị sẵn điểm mở rộng cho webhook gateway thật.

---

# CHƯƠNG 3: PHÂN TÍCH VÀ THIẾT KẾ HỆ THỐNG

## 3.1 Biểu đồ usecase

### 3.1.1 Biểu đồ usecase tổng quan hệ thống

Hệ thống có các tác nhân chính: **Staff**, **Admin**, và nhóm dịch vụ thanh toán QR. Tác nhân **Customer** (đặt món online) là tính năng mở rộng tùy chọn. Các nhóm chức năng chính gồm: đặt món tại bàn (staff), thanh toán QR, quản trị menu/nhân sự (admin).

**Hình 3.1**: Usecase tổng quan hệ thống (mã UML: **Phụ lục A.1**).

### 3.1.2 Các usecase phân rã

**Luồng chính:**

- Nhóm **staff**: chọn bàn, đặt món nhanh (tạo `order_group_id`), quản lý đơn theo bàn, cập nhật trạng thái món, tạo QR thanh toán và xác nhận thanh toán.
- Nhóm **admin**: quản lý menu/danh mục, quản lý user (staff/customer), quản lý ca làm/chấm công, xem thông báo.

**Luồng mở rộng (tùy chọn):**

- Nhóm **customer**: xem menu, add/update/remove cart, checkout và xem lịch sử đơn.

**Hình 3.2**: Usecase staff (mã UML: **Phụ lục A.2.1**).

**Hình 3.3**: Usecase admin (mã UML: **Phụ lục A.2.2**).

**Hình 3.4** (tùy chọn): Usecase customer (mã UML: **Phụ lục A.2.3**).

## 3.2 Xây dựng kịch bản

### 3.2.1 Các kịch bản chính (staff/admin)

**Staff đặt món tại bàn:**

1. Staff chọn bàn từ danh sách (filter theo zone, search theo số bàn).
2. Staff chọn món nhanh (theo category), chọn option (size/giá).
3. Hệ thống tạo `order_group_id` và sinh nhiều dòng `Transaction` (mỗi món 1 dòng).
4. Staff xem đơn hiện tại của bàn (gom theo `order_group_id`).
5. Staff cập nhật trạng thái món: hoàn thành (`completion_status='yes'`) hoặc hủy.

**Staff thanh toán:**

1. Staff chọn bàn cần thanh toán → xem danh sách `order_group_id` chưa thanh toán.
2. Staff có thể bỏ chọn món không dùng (trừ món) trước khi thanh toán.
3. Chọn phương thức thanh toán (SePay QR/VNPay QR/Chuyển khoản/Tiền mặt) → tạo QR (nếu QR).
4. Xác nhận thanh toán → cập nhật `payment_status='yes'` của các `Transaction` và trạng thái bàn.

**Admin vận hành:**

- Quản lý menu/danh mục: CRUD món, category.
- Quản lý user: CRUD customer/staff.
- Quản lý ca làm/chấm công: theo dõi nhân sự.
- Theo dõi thông báo: đơn mới/thanh toán thành công.

### 3.2.2 Các kịch bản mở rộng (customer - tùy chọn)

- **Xem menu**: truy cập menu → chọn món → chọn option (giá) → thêm vào giỏ (`TemporaryOrder`).
- **Giỏ hàng**: xem danh sách món, cập nhật số lượng, xóa món.
- **Checkout/đặt món**: xác nhận giỏ hàng → (tùy chọn) chọn bàn → hệ thống tạo `Transaction` và xóa giỏ.
- **Lịch sử đơn hàng**: xem danh sách `Transaction` theo tài khoản.

## 3.3 Xây dựng biểu đồ lớp phân tích

Các lớp cốt lõi: `User`, `Category`, `Menu`, `MenuOption`, `Transaction` (dòng đơn), `Table`, `Payment`, `Bank`, `Notification`, `TemporaryOrder` (mở rộng).

**Hình 3.5**: Biểu đồ lớp phân tích (mã UML: **Phụ lục A.3**).

## 3.4 Thiết kế các biểu đồ tuần tự

Các biểu đồ tuần tự (staff đặt món, staff thanh toán, xác nhận thanh toán, admin quản lý) được cung cấp trong **Phụ lục A.4**.

## 3.5 Thiết kế cơ sở dữ liệu

Thiết kế tập trung vào dữ liệu giao dịch đặt món:

- Đơn hàng được lưu ở `transactions` theo dạng "line item", gom nhóm theo `order_group_id` (staff đặt món).
- Thanh toán theo bàn được lưu ở `payments`, liên kết `tables` và các `order_group_id`.
- (Mở rộng) Giỏ hàng customer được lưu ở `temporary_orders`.

**Hình 3.6**: Lược đồ cơ sở dữ liệu hệ thống (mã UML: **Phụ lục A.5**).

---

# CHƯƠNG 4: CÀI ĐẶT ỨNG DỤNG

## 4.1 Hướng dẫn chạy source code web

### Cách 1: Chạy bằng Docker (khuyến nghị)

1) `cp .env.docker.example .env`
2) `docker-compose run --rm artisan key:generate`
3) `docker-compose up -d --build`
4) `docker-compose exec app composer install`
5) `docker-compose exec artisan migrate`
6) `docker-compose exec artisan db:seed` (tùy chọn)
7) Truy cập: Web `http://localhost:8000`, phpMyAdmin `http://localhost:8080`

### Cách 2: Chạy local

1) `composer install`
2) `cp .env.example .env` và cấu hình DB
3) `php artisan key:generate`
4) `php artisan migrate`
5) `npm install && npm run dev`
6) `php artisan serve`

## 4.2 Giao diện hệ thống staff

- **4.2.1 Chọn bàn/đặt món**: chọn bàn theo zone, đặt món nhanh theo danh mục.
- **4.2.2 Quản lý đơn theo bàn**: gom theo `order_group_id`, theo dõi món đã/chưa hoàn thành.
- **4.2.3 Thanh toán (tạo QR/xác nhận)**: tạo QR, hỗ trợ thanh toán sớm và trừ món; xác nhận thanh toán.

## 4.3 Giao diện hệ thống admin

- **4.3.1 Quản lý danh mục/menu**: CRUD danh mục và món.
- **4.3.2 Quản lý nhân sự/ca làm/chấm công**: phục vụ nghiệp vụ MIS.
- **4.3.3 Quản lý người dùng**: xem danh sách staff/customer, khóa/mở.

## 4.4 Giao diện hệ thống customer (mở rộng - tùy chọn)

- **4.4.1 Menu/giỏ hàng**: hiển thị món, thêm giỏ, cập nhật số lượng.
- **4.4.2 Checkout/lịch sử đơn**: xem lại đơn, checkout và xem lịch sử `Transaction`.

---

# CHƯƠNG 5: KẾT LUẬN VÀ ĐÁNH GIÁ

## 5.1 Kết quả đạt được

**Luồng chính (staff/admin):**

- Hoàn thiện luồng đặt món tại bàn: staff chọn bàn → đặt món nhanh → tạo `order_group_id` → quản lý đơn theo bàn → cập nhật trạng thái món.
- Hoàn thiện luồng thanh toán: staff chọn phương thức → tạo payment → tạo QR (placeholder) → xác nhận thanh toán → cập nhật `payment_status` và trạng thái bàn.
- Hoàn thiện chức năng admin: quản lý menu/danh mục, quản lý user, quản lý ca làm/chấm công.
- Có hệ thống notification và event broadcasting (Redis) cho đơn mới/thanh toán thành công.

**Luồng mở rộng (customer - tùy chọn):**

- Bổ sung tính năng đặt món online: menu → cart (`TemporaryOrder`) → checkout → tạo `Transaction`.

## 5.2 Các hạn chế

- Tích hợp payment gateway thật (SePay/VNPay) mới ở mức chuẩn bị (webhook còn TODO), QR hiện tạo qua dịch vụ công khai.
- `order_group_id` ở luồng customer checkout (tính năng mở rộng) hiện chưa sinh tự động, đơn customer tạo theo từng dòng `Transaction` riêng lẻ.
- Chưa chuẩn hóa đầy đủ reporting/báo cáo doanh thu theo ngày/ca/staff trong phạm vi báo cáo.
- Chưa có tính năng đặt trước (reservation) tích hợp sâu với luồng đặt món.

## 5.3 Định hướng phát triển

- **Tích hợp payment gateway thật**: hoàn thiện SePay/VNPay webhook, chữ ký và xử lý callback idempotent.
- **Báo cáo/thống kê**: bổ sung dashboard doanh thu theo ngày/ca/staff, top món bán chạy.
- **Tối ưu UI/UX**: cải thiện giao diện staff (chọn bàn nhanh, đặt món nhanh), hỗ trợ tablet.
- **Đặt trước (reservation)**: tích hợp đặt bàn online và gắn với luồng đặt món.
- **Customer online**: chuẩn hóa `order_group_id` cho checkout customer, bổ sung tracking đơn real-time.
- **Mở rộng**: hỗ trợ nhiều chi nhánh, quản lý kho nguyên liệu.

---

# TÀI LIỆU THAM KHẢO

- Tài liệu Laravel 8 (Routing, Middleware, Validation, Eloquent).
- Tài liệu Livewire (component lifecycle, binding).
- Tài liệu MySQL 8 và thiết kế CSDL quan hệ.
- Tài liệu SePay/VNPay (tham khảo tích hợp QR và webhook).
- QRServer API (dùng để tạo QR dạng placeholder trong dự án).

---

**GHI CHÚ QUAN TRỌNG**: File này đã được chỉnh sửa theo đúng trọng tâm của hệ thống `mis_restaurant`:

- **CHÍNH**: Staff đặt món tại bàn + Admin quản lý (vận hành nội bộ nhà hàng)
- **PHỤ** (mở rộng tùy chọn): Customer đặt món online

Các phần UML trong Phụ lục A cần được cập nhật tương ứng (mình sẽ làm riêng file UML cho đúng).
