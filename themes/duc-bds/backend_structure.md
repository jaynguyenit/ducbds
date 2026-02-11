# Tài liệu Cấu trúc Backend - Duc BDS

Tài liệu này ghi lại cấu trúc dữ liệu của theme `duc-bds` dựa trên các cấu hình trong thư mục `acf-jsons`.

## 1. Custom Post Types (CPT)

### [bds] - Bất động sản
- **Slug**: `bds`
- **Mô tả**: Loại bài viết chính dùng để đăng tin bất động sản.
- **Template**: `single-bds.php`

---

## 2. Taxonomies (Phân loại)

Sử dụng để phân loại các thuộc tính cốt lõi của bài viết `bds`.

| Taxonomy Slug | Tên hiển thị (Label) | Mô tả |
| :--- | :--- | :--- |
| `loai-bds` | Loại hình BĐS | Phân loại loại nhà, đất (Nhà phố, biệt thự, đất nền...) |
| `hinh-thuc-bds` | Hình thức BĐS | Phân biệt Bán hoặc Cho thuê. |
| `phuong-xa` | Phường / Xã | Vị trí địa lý cấp cơ sở. |
| `loai-duong` | Loại đường | Đặc điểm hạ tầng đường xá trước BĐS. |
| `huong-nha` | Hướng nhà | Các hướng Đông, Tây, Nam, Bắc... |
| `tinh-trang` | Tình trạng | Trạng thái giao dịch (Mở bán, Đã bán,...) |

---

## 3. Custom Fields (ACF Fields)

Nhóm trường: **Thông tin bất động sản** (`group_69725b25bc7e3`)

### Thông tin cơ bản
- `ma_bds` (Text): Mã số định danh của bất động sản.
- `gia` (Number): Giá tiền. Quy ước: 1 đơn vị = 1 triệu VNĐ. Ví dụ: `1000` tương đương 1 tỷ.
- `rong` (Number): Chiều rộng (m).
- `dai` (Number): Chiều dài (m).

### Thuộc tính chi tiết
- `so_pn` (Number): Số phòng ngủ.
- `so_pvs` (Number): Số phòng vệ sinh.
- `hinh_anh` (Gallery): Thư viện hình ảnh chi tiết của BĐS.

### Liên kết Taxonomy (Sử dụng trong Admin)
- `hinh_thuc_bds`
- `huong_nha`
- `loai_duong`
- `loai_hinh_bds`
- `phuong_xa`
- `tinh_trang`

---

## 4. Ghi chú Kỹ thuật
- Toàn bộ cấu trúc được đồng bộ qua JSON trong theme (`acf-jsons`).
- Khi có thay đổi trong ACF Admin, cần đảm bảo file JSON tương ứng được cập nhật để tài liệu này (và Assistant) có thể nhận biết được cấu trúc mới.
