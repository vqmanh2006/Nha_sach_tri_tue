<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nhan_vien', function (Blueprint $table) {
            $table->id('id_nhan_vien');
            $table->string('ho_ten', 150);
            $table->string('dia_chi_email', 190)->unique();
            $table->string('so_dien_thoai', 20)->nullable()->unique();
            $table->string('mat_khau');
            $table->enum('vai_tro', ['quan_tri', 'nhan_vien'])->default('nhan_vien');
            $table->boolean('dang_hoat_dong')->default(true);
            $table->timestamps();
        });

        Schema::create('khach_hang', function (Blueprint $table) {
            $table->id('id_khach_hang');
            $table->string('ho_ten', 150);
            $table->string('dia_chi_email', 190)->nullable()->unique();
            $table->string('so_dien_thoai', 20)->nullable()->unique();
            $table->string('mat_khau')->nullable();
            $table->date('ngay_sinh')->nullable();
            $table->enum('gioi_tinh', ['nam', 'nu', 'khac'])->nullable();
            $table->unsignedInteger('diem_tich_luy')->default(0);
            $table->boolean('dang_hoat_dong')->default(true);
            $table->timestamps();
        });

        Schema::create('danh_muc', function (Blueprint $table) {
            $table->id('id_danh_muc');
            $table->foreignId('id_danh_muc_cha')->nullable()->constrained('danh_muc', 'id_danh_muc')->nullOnDelete()->cascadeOnUpdate();
            $table->string('ten_danh_muc', 120);
            $table->text('mo_ta')->nullable();
            $table->boolean('dang_hoat_dong')->default(true);
            $table->timestamp('ngay_tao')->useCurrent();
            $table->unique(['id_danh_muc_cha', 'ten_danh_muc']);
        });

        Schema::create('san_pham', function (Blueprint $table) {
            $table->id('id_san_pham');
            $table->foreignId('id_danh_muc')->constrained('danh_muc', 'id_danh_muc')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('ma_san_pham', 50)->unique();
            $table->string('ten_san_pham', 200);
            $table->enum('loai_san_pham', ['sach', 'do_choi', 'do_dung_hoc_tap', 'do_an', 'khac'])->default('khac');
            $table->string('tac_gia', 150)->nullable();
            $table->string('nha_xuat_ban', 150)->nullable();
            $table->string('ma_isbn', 20)->nullable()->unique();
            $table->text('mo_ta')->nullable();
            $table->string('duong_dan_hinh_anh', 500)->nullable();
            $table->decimal('gia_nhap', 12, 2)->default(0);
            $table->decimal('gia_ban', 12, 2)->default(0);
            $table->unsignedInteger('so_luong_ton')->default(0);
            $table->unsignedInteger('nguong_canh_bao_ton')->default(5);
            $table->enum('trang_thai', ['con_hang', 'het_hang', 'ngung_kinh_doanh'])->default('con_hang');
            $table->timestamps();
            $table->index(['id_danh_muc', 'trang_thai']);
            $table->index(['so_luong_ton', 'nguong_canh_bao_ton']);
        });

        Schema::create('gio_hang', function (Blueprint $table) {
            $table->id('id_gio_hang');
            $table->foreignId('id_khach_hang')->unique()->constrained('khach_hang', 'id_khach_hang')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });

        Schema::create('chi_tiet_gio_hang', function (Blueprint $table) {
            $table->id('id_chi_tiet_gio_hang');
            $table->foreignId('id_gio_hang')->constrained('gio_hang', 'id_gio_hang')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_san_pham')->constrained('san_pham', 'id_san_pham')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedInteger('so_luong')->default(1);
            $table->timestamp('ngay_them')->useCurrent();
            $table->unique(['id_gio_hang', 'id_san_pham']);
        });

        Schema::create('don_hang', function (Blueprint $table) {
            $table->id('id_don_hang');
            $table->string('ma_don_hang', 30)->unique();
            $table->foreignId('id_khach_hang')->nullable()->constrained('khach_hang', 'id_khach_hang')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_nhan_vien')->nullable()->constrained('nhan_vien', 'id_nhan_vien')->nullOnDelete()->cascadeOnUpdate();
            $table->enum('kenh_ban', ['truc_tuyen', 'tai_quay']);
            $table->enum('hinh_thuc_nhan_hang', ['giao_hang', 'nhan_tai_cua_hang', 'mua_tai_quay']);
            $table->enum('trang_thai', ['cho_xac_nhan', 'da_xac_nhan', 'dang_dong_goi', 'dang_giao', 'cho_den_nhan', 'hoan_thanh', 'da_huy', 'yeu_cau_tra_hang', 'da_tra_hang'])->default('cho_xac_nhan');
            $table->enum('phuong_thuc_thanh_toan', ['tien_mat', 'chuyen_khoan', 'the', 'khac'])->default('tien_mat');
            $table->enum('trang_thai_thanh_toan', ['chua_thanh_toan', 'da_thanh_toan', 'da_hoan_tien'])->default('chua_thanh_toan');
            $table->string('ten_nguoi_nhan', 150)->nullable();
            $table->string('sdt_nguoi_nhan', 20)->nullable();
            $table->string('dia_chi_giao_hang', 500)->nullable();
            $table->decimal('tong_tien_hang', 12, 2)->default(0);
            $table->decimal('so_tien_giam', 12, 2)->default(0);
            $table->decimal('phi_giao_hang', 12, 2)->default(0);
            $table->decimal('tong_thanh_toan', 12, 2)->default(0);
            $table->unsignedInteger('diem_da_tich')->default(0);
            $table->unsignedInteger('diem_da_dung')->default(0);
            $table->text('ghi_chu_khach_hang')->nullable();
            $table->text('ghi_chu_nhan_vien')->nullable();
            $table->timestamp('ngay_dat')->useCurrent();
            $table->timestamp('ngay_cap_nhat')->useCurrent()->useCurrentOnUpdate();
            $table->index(['trang_thai', 'ngay_dat']);
        });

        Schema::create('chi_tiet_don_hang', function (Blueprint $table) {
            $table->id('id_chi_tiet_don_hang');
            $table->foreignId('id_don_hang')->constrained('don_hang', 'id_don_hang')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_san_pham')->nullable()->constrained('san_pham', 'id_san_pham')->nullOnDelete()->cascadeOnUpdate();
            $table->string('ten_san_pham_luc_dat', 200);
            $table->string('ma_san_pham_luc_dat', 50);
            $table->unsignedInteger('so_luong');
            $table->decimal('don_gia', 12, 2);
            $table->decimal('gia_nhap_luc_ban', 12, 2)->default(0);
            $table->decimal('thanh_tien', 12, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_don_hang');
        Schema::dropIfExists('don_hang');
        Schema::dropIfExists('chi_tiet_gio_hang');
        Schema::dropIfExists('gio_hang');
        Schema::dropIfExists('san_pham');
        Schema::dropIfExists('danh_muc');
        Schema::dropIfExists('khach_hang');
        Schema::dropIfExists('nhan_vien');
    }
};
