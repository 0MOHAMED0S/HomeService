<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رمز التحقق</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            direction: rtl;
            text-align: right;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #4CAF50;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }
        .content {
            padding: 30px;
            color: #333333;
            line-height: 1.6;
        }
        .otp-box {
            background-color: #f9f9f9;
            border: 2px dashed #4CAF50;
            text-align: center;
            padding: 15px;
            font-size: 24px;
            letter-spacing: 5px;
            font-weight: bold;
            color: #4CAF50;
            margin: 20px 0;
            border-radius: 5px;
        }
        .footer {
            background-color: #eeeeee;
            color: #777777;
            text-align: center;
            padding: 15px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>رمز التحقق (OTP)</h2>
        </div>
        <div class="content">
            <p>أهلاً بك،</p>
            <p>لقد طلبت رمز تحقق لإتمام عملية التسجيل. يرجى استخدام الرمز أدناه:</p>
            <div class="otp-box">
                {{ $otp }}
            </div>
            <p>علماً بأن هذا الرمز صالح لمدة 10 دقائق فقط. يرجى عدم مشاركة هذا الرمز مع أي شخص.</p>
            <p>شكراً لك،<br>فريق العمل</p>
        </div>
        <div class="footer">
            هذه الرسالة تم إرسالها تلقائياً، يرجى عدم الرد عليها.
        </div>
    </div>
</body>
</html>
