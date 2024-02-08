<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Congratulations on Signing Up!</title>
    <style>
        /* Inline CSS for styling */
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

        .token {
            font-size: 24px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 6px;
            margin: 30px auto;
            width: 60%;
        }

        .signature {
            font-style: italic;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome!</h1>
        <p>Congratulations on signing up with us. We are excited to have you on board.</p>
        <p>Here is your subscription token:</p>
        <div class="token">
            <strong>{{ $company->Token }}</strong>
        </div>
        <p>Use this token to access our platform and enjoy our services.</p>

        <p class="signature">Best regards,<br>{{ config('app.name') }}</p>
    </div>
</body>

</html>
