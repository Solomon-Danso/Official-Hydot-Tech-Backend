<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notification: Company Details Deleted</title>
    <style>
        /* Inline CSS for styling */
        /* Feel free to add your desired styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            text-align: center;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        p {
            color: #666;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .signature {
            font-style: italic;
            font-size: 14px;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Notification: Company Details Deleted</h1>
        <p>Dear {{$CompanyName->CompanyName}},</p>
        <p>We hope this message finds you well.</p>
        <p>We regret to inform you that your company details have been removed from our records. We appreciate the collaboration and engagement we have had with you.</p>
        <p>While it's unfortunate that we are parting ways, please know that we are open to future opportunities for collaboration and would be delighted to work with you again.</p>
        <p>If you have any inquiries or wish to discuss further, please feel free to reach out to us at any time.</p>
        <p>Thank you for your past association. We wish you continued success in your endeavors.</p>
        <p class="signature">Best regards,<br>{{ config('app.name') }}</p>
    </div>
</body>
</html>

