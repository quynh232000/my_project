@php
    $logo ="https://res.cloudinary.com/daebxc8ex/image/upload/v1738422979/dbnvpiaxh1ga1e9eedim.png";
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mail - order - success</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link rel="stylesheet" href="style.css"> -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .mail-order-success {
            /* justify-content: center;
            align-items: center;
            display: flex; */
            min-height: 100vh;
            padding: 20px 0;
        }

        .mail-order-success-wrapper {
            max-width: 600px;
            border-radius: 6px;
            padding: 20px 30px;
            min-height: 70vh;
            box-shadow: 0 0 4px #ccc;
            margin: 0 auto;
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
            color: #8037F1;
        }

        .mail-order-success-content-hello {
            padding-bottom: 16px;
            display: flex;
        }

        .mail-order-success-icon {
            font-size: 4rem;
            color: rgb(0, 175, 0);
        }

        button {
            outline: none;
            padding: 8px 12px;
            border: none;
            margin-top: 24px;
            text-align: center;
            background-color: #8037F1;
            color: white;
            border-radius: 8px;
            cursor: pointer;
        }

        a.mail-order-success-signature {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        tr,
        td,
        th {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="mail-order-success">
        <div class="mail-order-success-wrapper">
            <div class="mail-order-success-header">
                <div class="mail-order-success-header-img" style="width:140px; height:48px;">
                    <img src="{{$logo}}" style="width:100%;height:100%;object-fit:contain"  alt="" />
                </div>
                <div class="mail-order-success-header-title">Liên hệ mới</div>
            </div>
            <div class="mail-order-success-content" style="padding-top: 32px;">
                <div class="mail-order-success-content-hello">
                    <p class="mail-order-success-content-title">Xin Chào Admin</p>
                    {{-- <span style="padding: 0 4px;">{{ $data['order']->user->name }}</span> --}}
                </div>
                <div class="mail-order-success-content-title-one">
                    <p> Bạn nhận được 1 liên hệ mới từ <strong> {{config('app.name')}}</strong></p>
                </div>
                <hr style="margin:10px 0">
                <div style="padding-bottom: 5px">
                    <i>Thông tin khách hàng liên hệ:</i>
                </div>

                <div style="margin-bottom: 10px">
                    <strong>Họ tên:</strong>
                    <div
                        style="">{{$data['name']}}</div>
                </div>
                <div style="margin-bottom: 10px">
                    <strong>Số điện thoại:</strong>
                    <div
                        style="">{{$data['phone']}}</div>
                </div>
                <div style="margin-bottom: 10px">
                    <strong>Email:</strong>
                    <div
                        style="">{{$data['email']}}</div>
                </div>
                <div style="margin-bottom: 10px">
                    <strong>Tiêu đề:</strong>
                    <div
                        style="">{{$data['title']}}</div>
                </div>
                <div style="margin-bottom: 10px">
                    <strong>Nội dung:</strong>
                    <div
                        style="">{{$data['message']}}</div>
                </div>
            </div>
            <div class="mail-order-success-footer" style="color: #959494; padding-top: 16px;border-top:1px solid gray">
                <p style="text-align: center">Email này không thể nhận thư trả lời. Để biết thêm thông tin, hãy liên hệ với chúng tôi qua hotline:
                    <span style="color: #8037F1;">{{config('app.info.phone')}}</span>
                </p>
            </div>
        </div>
    </div>
</body>

</html>
