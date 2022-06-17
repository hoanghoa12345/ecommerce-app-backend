<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>eClean - Đơn hàng</title>
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
    <p class="text-secondary">Cảm ơn bạn đã đặt hàng tại eClean Store!</p>

    <div class="card">
        <div class="card-body">
            <b>Xin chào {{ $user->name }}, </b>
            <br>eClean đã nhận được yêu cầu đặt hàng của bạn và đang xử lý nhé!

            <div>
                <p>Đơn hàng: {{ $order->order_number }}</p>
                <h4>Đơn hàng được giao đến:</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Tên: {{ $user->name }}</li>
                    <li class="list-group-item">Địa chỉ: {{ $order->address }}</li>
                    <li class="list-group-item">Số điện thoại: {{ $order->phone_number }}</li>
                </ul>
            </div>
            <div>
                <h4>Sản phẩm:</h4>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Hình ảnh</th>
                        <th scope="col">Sản phẩm</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Giá</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($order_list as $item)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td><img src="{{ config('app.url') }}/{{ $item->product->image }}" width="32" height="32" alt="product"/></td>
                            <td>{{$item->product->name}}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->price }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Thành tiền: {{ $order->total_price }} VND</li>
                    <li class="list-group-item">Phí vận chuyển: 0 VND</li>
                    <li class="list-group-item">Tổng cộng: {{ $order->total_price }} VND</li>
                </ul>
            </div>
        </div>
    </div>

    <div>
        <p class="text-secondary">eClean Store | e-clean.xyz</p>
        <p class="text-secondary">Đây là thư tự động được tạo từ danh sách đăng ký của chúng tôi. Do đó, xin đừng trả lời thư này.</p>
    </div>

</div>
</body>
</html>
