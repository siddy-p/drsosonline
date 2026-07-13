<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $subject ?? 'Notification' }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border-top: 4px solid #0d9488;
        }
        .header {
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: bold;
            color: #0d9488;
        }
        .content {
            font-size: 15px;
            white-space: pre-line;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #999999;
            border-top: 1px solid #eeeeee;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Dr.SOS Online Alert</div>
        <div class="content">
            {!! nl2br(e($body)) !!}
        </div>
        <div class="footer">
            This is an automated notification from Dr.SOS Online portal.
        </div>
    </div>
</body>
</html>
