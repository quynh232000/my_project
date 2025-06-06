{{-- <strong>{{$data['code']}}</strong> --}}


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

        .button {
            outline: none;
            padding: 8px 12px;
            border: none;
            margin-top: 32px;
            text-align: center;
            background-color: rgba(128, 55, 241, 1);
            color: white;
            font-weight: bold;
            font-size: 34px;
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
                <div class="mail-order-success-header-title">Mã xác nhận tài khoản</div>
            </div>
            <div class="mail-order-success-content" style="padding: 32px 0;">


                <div class="mail-order-success-icon" style="text-align: center; padding: 24px 0 0 0;">
                    <img src="https://res.cloudinary.com/dkj9bf0d3/image/upload/v1740152089/sql_rpqoqu.png"
                        width="120" alt="">
                </div>
                <div class="mail-order-success-content-title">
                    <p style="text-align: center; color: rgb(62 62 62); padding-top: 8px;font-size:50px;color:rgba(128, 55, 241, 1)">Security code</p>
                </div>
                <div>Vui lòng sử dụng mã bảo mật sau cho tài khoản của bạn</div>
                <div style="margin:20px 0">
                    <div class="mail-order-success-signature button" style="margin: auto" >
                        {{$data['code']}}
                    </div>
                </div>
            </div>
            <div style="margin:20px 0">Nếu bạn không nhận ra tài khoản, bạn có thể bỏ qua tin nhắn này.</div>
            <hr>

            <div class="mail-order-success-footer" style="color: #959494; padding-top: 16px;">
                <p>Email này không thể nhận thư trả lời. Để biết thêm thông tin, hãy liên hệ với chúng tôi qua hotline:
                    <span style="color: rgba(128, 55, 241, 1);">0358723520</span></p>
            </div>
        </div>
    </div>
</body>

</html>
