{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đặt hàng thành công!</title>
</head>

<body>
    <h2>Đặt hàng thành công!</h2>
    <h2>Cảm ơn bạn đã tin tưởng mua sắm tại Quin Ecocmerce!</h2>
    <h3>Thông tin đơn hàng</h3>
    <hr>
    <h1>Đơn hàng: {{ $data['order']['order_code'] }}</h1>
    <h1>Tổng tiền: {{ $data['order']['total'] }}</h1>
</body>

</html> --}}


{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Create Tour</title>




    <style>
        * {
            box-sizing: inherit;
        }

        html,
        body {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
    </style>
    <style>
        #mail{
            display: flex;
            flex-direction: column;
        }
        #mail .content {
            flex: 1;
            padding-top: 20px;
            text-align: center

        }
        #mail .btn{
            margin-top: 20px;
            text-decoration: none;
            background-color: blue;
            color: white;
            padding: 10px 30px;
            border-radius: 6px
        }
        #mail #btn-wrapper{
            padding: 20px;
        }
        .quynh{
            height: 100vh;
        }
    </style>
</head>

<body id="mail" style="height:100vh;">

    <div class="quynh">
        <main style="display: flex;flex-direction:column;padding:10px">
            <div style="display: flex;justify-content: center;">
                <img src="https://quin.mr-quynh.com/assest/images/UNIDI_LOGO-FINAL%202.svg" alt="" width="96">
            </div>

            <div class="content" >
                <div>
                    <div><h1>Welcome to Quin Course</h1></div>
                    <div>Xin chào <strong>{{$data['user']['full_name']}}</strong> - Vui lòng nhấn đường link dưới đây để xác nhận thay đổi mật khẩu của bạn</div>
                </div>
                <div  id="btn-wrapper">
                    <a href="{{$data['url']}}" class="btn" href="">Đổi mật khẩu</a>
                </div>
            </div>
            <div>
                <div style="text-align: center;padding:5px;color: gray; background-color:rgba(22,22,24,.12);padding: 6px;">
                    Copyright © 2024 Mr Quynh
                </div>
            </div>
        </main>
    </div>



</body>

</html> --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mail - shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .mail-order-success {
            justify-content: center;
            align-items: center;
            display: flex;
            min-height: 100vh;
        }

        .mail-order-success-wrapper {
            max-width: 600px;
            border-radius: 6px;
            padding: 20px 30px;
            min-height: 70vh;
            box-shadow: 0 0 4px #ccc;
        }

        .mail-order-success-header {
            background-color: #f8f8f8;
            padding: 16px;
            display: flex;
            align-items: center;
        }

        img {
            max-width: 100px;
            max-height: 100px;
        }

        .mail-order-success-header-img {
            display: flex;
            flex: 1;
            margin-right: 103px;
        }

        .mail-order-success-header-title {
            font-size: 24px;
            font-weight: 600;
            color: rgba(128, 55, 241, 1);
        }

        .mail-order-success-content-hello {
            padding-bottom: 16px;
            display: flex;
        }

        .mail-order-success-icon {
            font-size: 4rem;
            color: rgba(128, 55, 241, 1);
        }

        button {
            outline: none;
            padding: 8px 12px;
            border: none;
            margin-top: 32px;
            text-align: center;
            background-color: rgba(128, 55, 241, 1);
            color: white;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            cursor: pointer;
            background-color: rgb(117, 48, 221);
        }

        a.mail-order-success-signature {
            /* display: flex;
        justify-content: center; */
            align-items: center;
            cursor: pointer;
            text-decoration: none;
        }

        a.mail-order-success-signature:hover {
            cursor: pointer;
        }

        .mail-order-success-content-title-one {
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 2rem;
            color: rgba(128, 55, 241, 1);
        }

        td {
            padding: 5px
        }

        .head {
            font-weight: bold
        }
    </style>
</head>

<body>
    <div class="mail-order-success">
        <div class="mail-order-success-wrapper">
            <div class="mail-order-success-header">
                <div class="mail-order-success-header-img">
                    <img src="https://res.cloudinary.com/dlmf8cmva/image/upload/v1740059980/z6336840228776_8842ffe7dfc4d3cc9c9393a0ba385a45_vudk3z.jpg"
                        alt="" />
                </div>
                <div class="mail-order-success-header-title">Đặt hàng thành công!</div>
            </div>
            <div class="mail-order-success-icon" style="text-align: center; padding: 24px 0 0 0;">
                <img src="https://res.cloudinary.com/dlmf8cmva/image/upload/v1740062518/check_yusnrr.png" width="120"
                    alt="">
            </div>
            <div class="mail-order-success-content" style="padding: 32px 0;">
                <div class="mail-order-success-content-hello">
                    <p class="mail-order-success-content-title">Xin Chào</p>
                    <span style="padding: 0 4px;">{{ $data['order']->user->full_name }}</span>
                </div>
                <div> Cảm ơn bạn đã tin tưởng và đặt hàng trên Quin Ecommerce.</div>
                <div>Thông tin chi tiết đơn hàng:</div>

                <div>
                    <table style="width: 100%;margin:20px 0" border="">
                        <tr>
                            <td class="head">Mã đơn hàng:</td>
                            <td><strong>#{{ $data['order']->order_code }}</strong></td>
                        </tr>
                        <tr>
                            <td class="head"> Ngày đặt hàng:</td>
                            <td>{{ date('d/m/Y H:i:s', strtotime($data['order']->created_at)) }}</td>
                        </tr>
                        <tr>
                            <td class="head">Tổng tiền:</td>
                            <td>{{ number_format($data['order']->total, 0, '', '.') }}đ</td>
                        </tr>
                        <tr>
                            <td class="head">Trạng thái:</td>
                            <td>Đã đặt hàng thành công.</td>
                        </tr>
                        <tr>
                            <td class="head">Địa chỉ giao hàng:</td>
                            <td>{{ $data['order']->address->address_detail }}</td>
                        </tr>
                    </table>
                </div>
                <hr>
                <div class="" style="color:blueviolet;padding-top:10px">Danh sách sản phẩm</div>
                <div>
                    <table class="" style="width:100%; margin:10px 0" border="">
                        <tr class="head">
                            <th>STT</th>
                            <th>Tên sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Tạm tính</th>
                        </tr>
                        <tbody style="text-align: center">
                            @foreach ($data['order']->order_details as $key => $order_detail)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $order_detail->product->name }}</td>
                                    <td>{{ number_format($order_detail->product->price, 0, '', '.') }}đ</td>
                                    <td>x{{ $order_detail->quantity}}</td>
                                    <td>{{ number_format($order_detail->quantity* $order_detail->price, 0, '', '.') }}đ
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </table>
                </div>
                {{-- <div class="mail-order-success-content-title">
                    <p style="text-align: center; color: rgb(62 62 62); padding-top: 8px;">Vui lòng nhấn vào nút bên
                        dưới để thực hiện thay đổi mật khẩu mới.</p>
                </div> --}}
                {{-- <div class="">
                    <a class="mail-order-success-signature" style="margin: auto">
                        <button>Đổi mật khẩu</button>
                    </a>
                </div> --}}
            </div>
            <hr>
            <div class="mail-order-success-footer" style="color: #959494; padding-top: 16px;">
                <p>Email này không thể nhận thư trả lời. Để biết thêm thông tin, hãy liên hệ với chúng tôi qua hotline:
                    <span style="color: rgba(128, 55, 241, 1);">0358723520</span>
                </p>
            </div>
        </div>
    </div>
</body>

</html>
