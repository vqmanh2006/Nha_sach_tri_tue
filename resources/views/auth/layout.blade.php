<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Tài khoản' }} · Nhà Sách Trí Tuệ</title>
    <style>
        *{box-sizing:border-box}body{margin:0;background:#fffaf2;color:#292524;font-family:Segoe UI,Arial,sans-serif}.wrap{max-width:440px;margin:55px auto;padding:0 20px}.brand{text-align:center;color:#c2410c;font-size:26px;font-weight:800;margin-bottom:26px}.brand small{display:block;color:#8b5e3c;font-size:11px;letter-spacing:2px}.box{background:#fff;border:1px solid #eadfce;border-radius:16px;padding:28px;box-shadow:0 12px 30px #8b5e3c12}h1{font-size:24px;margin:0 0 7px}p.sub{color:#78716c;margin:0 0 22px}label{display:block;font-weight:600;font-size:14px;margin:14px 0 6px}input{width:100%;padding:12px;border:1px solid #d6c8b7;border-radius:8px;font-size:15px}button{width:100%;margin-top:22px;border:0;border-radius:8px;padding:13px;background:#c2410c;color:#fff;font-weight:700;font-size:15px;cursor:pointer}.error{background:#fff1f2;color:#be123c;padding:10px;border-radius:7px;font-size:14px}.link{text-align:center;margin-top:18px;font-size:14px}.link a{color:#c2410c;font-weight:700}.back{display:block;text-align:center;margin-top:20px;color:#78716c;font-size:14px}
    </style>
</head>
<body><div class="wrap"><a class="brand" href="/">NHÀ SÁCH TRÍ TUỆ<small>TRI THỨC MỞ LỐI TƯƠNG LAI</small></a><div class="box">@yield('content')</div><a class="back" href="/">← Quay về cửa hàng</a></div></body>
</html>
