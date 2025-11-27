<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reminder Notification</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
            color: #333;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            padding-bottom: 20px;
        }
        .email-header h1 {
            color: #4A90E2;
            font-size: 24px;
            margin: 0;
        }
        .email-content {
            font-size: 16px;
            line-height: 1.6;
            color: #555555;
            padding: 20px;
            background-color: #fafafa;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .email-footer {
            text-align: center;
            font-size: 14px;
            color: #888888;
        }
        .email-footer a {
            color: #4A90E2;
            text-decoration: none;
        }
        .button {
            display: inline-block;
            padding: 12px 20px;
            margin-top: 20px;
            background-color: #4A90E2;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-header">
            <h1>Admin Notification</h1>
            <p>You are receiving this email as a reminder for a follow-up on a quotation.</p>
        </div>

        <div class="email-content">
            <h3>Reminder Type: {{ $type }}</h3>
            <p><strong>Message:</strong> {{ $data }}</p>
            <p><strong>Sent On:</strong> {{ \Carbon\Carbon::parse($sent_date)->toFormattedDateString() }}</p>

            <p>This reminder is for internal follow-up purposes. Please review and take appropriate action.</p>

            <a href="#" class="button">View Quotation Details</a>
        </div>

        <div class="email-footer">
            <p>If you have any questions or need further assistance, please contact support.</p>
            <p>Best regards, <br> Your Company Name</p>
            <p><a href="#">Unsubscribe</a> | <a href="#">Contact Support</a></p>
        </div>
    </div>
</body>
</html>
