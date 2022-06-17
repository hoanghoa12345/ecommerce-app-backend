<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>eClean - Đăng ký gói sản phẩm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <style>
        .container {
            font-family: Arial, serif;
            font-size: 14px;
        }

        .bg-orange {
            background-color: #ea580c;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-light bg-orange font-weight-bold p-4">eClean</h1>
    <p class="text-secondary">Cảm ơn bạn đã đăng ký dịch vụ cung cấp gói sản phẩm của chúng tôi</p>
    <div class="card">
        <div class="card-body">
            <p><b>Xin chào {{ $user->name }}, </b>
            <br>eClean đã nhận được yêu cầu đặt hàng của bạn và đang xử lý nhé!</p>
            <div>
                <h4>Gói sản phẩm được giao đến:</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Tên: {{ $user->name }}</li>
                    <li class="list-group-item">Địa chỉ: {{ $profile->address }}</li>
                    <li class="list-group-item">Số điện thoại: {{ $profile->phone_number }}</li>
                </ul>
            </div>

            <div>
                <h4>Thông tin đăng ký gói:</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Tên gói: {{ $subscription->name }}</li>
                    <li class="list-group-item">Ngày bắt đầu: {{ $userSubscription->start_date }}</li>
                    <li class="list-group-item">Ngày kết thúc: {{ $userSubscription->end_date }}</li>
                    <li class="list-group-item">Tổng số tiền: {{ $subscription->total_price }} VND</li>
                    <li class="list-group-item">Thời gian giao hàng: {{ $userSubscription->delivery_schedule }}</li>
                </ul>
            </div>

        </div>
    </div>
    <div>
        <p class="text-secondary">
            <span>Nhóm hỗ trợ | eClean Store</span><br>
            <span>Đây là thư tự động gửi! Vui lòng không trả lời thư này</span>
        </p>
    </div>
</div>
</body>
</html>
