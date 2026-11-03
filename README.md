# Nha Sach Tri Tue

Backend Laravel cho nha sach, dung MySQL va bam theo schema `nhan_vien`, `khach_hang`, `danh_muc`, `san_pham`, `gio_hang`, `don_hang` va cac bang chi tiet.

## Chay local

```bash
cp .env.example .env
php artisan key:generate
# Tao database nha_sach_tri_tue trong MySQL va cap nhat DB_USERNAME/DB_PASSWORD trong .env
php artisan migrate --seed
php artisan serve
```

## API chinh

- `GET /api/health`
- `GET|POST /api/danh-muc`
- `GET|POST|PATCH /api/san-pham`
- `GET /api/khach-hang/{id}/gio-hang`
- `POST /api/khach-hang/{id}/gio-hang`
- `DELETE /api/khach-hang/{id}/gio-hang/{idSanPham}`
- `GET|POST /api/don-hang`

Tao don hang se luu snapshot gia/ten san pham vao `chi_tiet_don_hang`, tru ton kho trong transaction va xoa gio hang sau khi dat thanh cong.
