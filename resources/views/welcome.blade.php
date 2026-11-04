<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nha Sach Tri Tue</title>
    <style>
        :root { --ink:#202124; --muted:#6b7280; --brand:#c2410c; --cream:#fffaf2; --line:#eadfce; }
        * { box-sizing:border-box; }
        body { margin:0; color:var(--ink); background:var(--cream); font-family:Inter,Segoe UI,Arial,sans-serif; }
        a { color:inherit; text-decoration:none; }
        .top { background:#231f20; color:#fff; font-size:13px; padding:9px 5%; text-align:center; }
        header { background:#fff; border-bottom:1px solid var(--line); }
        .nav { max-width:1180px; margin:auto; padding:20px 24px; display:flex; align-items:center; gap:28px; }
        .logo { color:var(--brand); font-size:25px; font-weight:800; white-space:nowrap; }
        .logo span { display:block; color:#8b5e3c; font-size:11px; letter-spacing:2px; font-weight:600; }
        .search { flex:1; display:flex; border:1px solid #d8cbb9; border-radius:9px; overflow:hidden; background:#fff; }
        .search input { flex:1; border:0; outline:0; padding:13px 15px; font-size:15px; }
        .search button { border:0; background:var(--brand); color:#fff; padding:0 20px; cursor:pointer; font-weight:700; }
        .cart { color:var(--brand); font-weight:700; white-space:nowrap; }
        .account-link { display:inline-block; border:1px solid var(--brand); border-radius:7px; padding:9px 12px; color:var(--brand); font-weight:700; white-space:nowrap; }
        main { max-width:1180px; margin:auto; padding:28px 24px 60px; }
        .hero { border-radius:18px; padding:42px; color:#fff; background:linear-gradient(110deg,#8b2f13,#d66b28); display:flex; justify-content:space-between; align-items:center; min-height:220px; overflow:hidden; }
        .hero h1 { margin:0 0 10px; font-size:38px; max-width:590px; }
        .hero p { margin:0; font-size:17px; opacity:.9; }
        .hero-badge { font-size:90px; opacity:.2; transform:rotate(-12deg); }
        .layout { display:grid; grid-template-columns:220px 1fr; gap:28px; margin-top:32px; }
        aside { background:#fff; border:1px solid var(--line); border-radius:12px; padding:20px; height:max-content; }
        aside h3 { margin:0 0 14px; font-size:17px; }
        .category { display:block; padding:10px 0; color:var(--muted); border-bottom:1px solid #f1e9dd; }
        .category:hover, .category.active { color:var(--brand); font-weight:700; }
        .section-head { display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; }
        .section-head h2 { margin:0; font-size:25px; }
        .count { color:var(--muted); font-size:14px; }
        .products { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:18px; }
        .card { background:#fff; border:1px solid var(--line); border-radius:12px; overflow:hidden; transition:.2s; }
        .card:hover { transform:translateY(-3px); box-shadow:0 8px 22px #8b5e3c18; }
        .cover { height:180px; display:grid; place-items:center; background:linear-gradient(135deg,#f6dfbd,#fff7ea); color:#b45309; font-size:54px; }
        .info { padding:16px; }
        .tag { color:var(--brand); font-size:12px; font-weight:700; text-transform:uppercase; }
        .name { min-height:44px; margin:7px 0 8px; font-size:16px; font-weight:700; }
        .author { color:var(--muted); font-size:13px; min-height:19px; }
        .bottom { display:flex; justify-content:space-between; align-items:center; gap:8px; margin-top:15px; }
        .price { color:var(--brand); font-size:17px; font-weight:800; }
        .stock { color:#15803d; font-size:12px; }
        .empty { grid-column:1/-1; background:#fff; border:1px dashed var(--line); border-radius:12px; padding:45px; text-align:center; color:var(--muted); }
        footer { background:#231f20; color:#ddd; padding:28px 5%; text-align:center; font-size:13px; }
        @media (max-width:760px) { .nav { flex-wrap:wrap; gap:14px; } .search { order:3; flex-basis:100%; } .hero { padding:28px; } .hero h1 { font-size:28px; } .hero-badge { display:none; } .layout { grid-template-columns:1fr; } .products { grid-template-columns:repeat(2,minmax(0,1fr)); } }
        @media (max-width:470px) { .products { grid-template-columns:1fr; } main { padding-left:14px; padding-right:14px; } }
    </style>
</head>
<body>
    <div class="top">Chào mừng đến với Nhà Sách Trí Tuệ · Sách hay cho mọi hành trình</div>
    <header>
        <div class="nav">
            <a class="logo" href="/">NHÀ SÁCH TRÍ TUỆ<span>TRI THỨC MỞ LỐI TƯƠNG LAI</span></a>
            <form class="search" method="GET" action="/">
                <input name="q" value="{{ $timKiem }}" placeholder="Tìm kiếm sách, tác giả...">
                @if($danhMucDangChon)<input type="hidden" name="danh_muc" value="{{ $danhMucDangChon }}">@endif
                <button type="submit">Tìm kiếm</button>
            </form>
            @if(session('khach_hang_id'))
                <a class="cart" href="{{ route('cart') }}">🛒 Giỏ hàng</a>
                <a class="account-link" href="{{ route('account') }}">👤 Tài khoản</a>
                <form method="POST" action="{{ route('logout') }}" style="margin:0">
                    @csrf
                    <button class="cart" style="border:0;background:none;padding:0;cursor:pointer;font:inherit">Đăng xuất</button>
                </form>
            @else
                <a class="account-link" href="{{ route('customer.login') }}">👤 Đăng nhập</a>
                <a class="account-link" href="{{ route('customer.register') }}">Đăng ký</a>
            @endif
        </div>
    </header>
    <main>
        <section class="hero">
            <div>
                <h1>Mở một cuốn sách,<br>mở thêm một thế giới.</h1>
                <p>Khám phá sách, đồ dùng học tập và những món quà tri thức.</p>
            </div>
            <div class="hero-badge">✦</div>
        </section>
        <div class="layout">
            <aside>
                <h3>Danh mục sản phẩm</h3>
                <a class="category {{ !$danhMucDangChon ? 'active' : '' }}" href="/">Tất cả sản phẩm</a>
                @foreach($danhMucs as $danhMuc)
                    <a class="category {{ (string) $danhMucDangChon === (string) $danhMuc->id_danh_muc ? 'active' : '' }}" href="/?danh_muc={{ $danhMuc->id_danh_muc }}">{{ $danhMuc->ten_danh_muc }}</a>
                @endforeach
            </aside>
            <section>
                <div class="section-head">
                    <h2>{{ $timKiem ? 'Kết quả tìm kiếm' : 'Sản phẩm nổi bật' }}</h2>
                    <span class="count">{{ $sanPhams->count() }} sản phẩm</span>
                </div>
                <div class="products">
                    @forelse($sanPhams as $sanPham)
                        <article class="card">
                            <div class="cover">📖</div>
                            <div class="info">
                                <div class="tag">{{ str_replace('_', ' ', $sanPham->loai_san_pham) }}</div>
                                <div class="name">{{ $sanPham->ten_san_pham }}</div>
                                <div class="author">{{ $sanPham->tac_gia ?: 'Sản phẩm Nhà Sách Trí Tuệ' }}</div>
                                <div class="bottom">
                                    <div><div class="price">{{ number_format($sanPham->gia_ban, 0, ',', '.') }}đ</div><div class="stock">Còn {{ $sanPham->so_luong_ton }} sản phẩm</div></div>
                                    <a class="cart" href="{{ route('product', $sanPham) }}">Chi tiết →</a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="empty">Không tìm thấy sản phẩm phù hợp.</div>
                    @endforelse
                </div>
            </section>
        </div>
    </main>
    <footer>© {{ date('Y') }} Nhà Sách Trí Tuệ · Nền tảng bán sách và sản phẩm học tập</footer>
</body>
</html>
