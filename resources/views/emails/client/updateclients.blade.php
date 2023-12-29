
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

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            th, td {
                padding: 8px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }
            .signature {
                font-style: italic;
                font-size: 14px;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <h1>Hello there!</h1>
            <p>We want to inform you that your company's information has been successfully updated.</p>
            <p>Here are the current details of your company:</p>
            
            <table>
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                </tr>
                <tr>
                    <td>Company ID</td>
                    <td>{{ $r->CompanyId }}</td>
                </tr>
              
                <tr>
                    <td>Company Name</td>
                    <td>{{ $r->CompanyName }}</td>
                </tr>
                <tr>
                    <td>Location</td>
                    <td>{{ $r->Location }}</td>
                </tr>
                <tr>
                    <td>Contact Person</td>
                    <td>{{ $r->ContactPerson }}</td>
                </tr>
                <tr>
                    <td>Company Phone</td>
                    <td>{{ $r->CompanyPhone }}</td>
                </tr>
                <tr>
                    <td>Company Email</td>
                    <td>{{ $r->CompanyEmail }}</td>
                </tr>
                <tr>
                    <td>Contact Person Phone</td>
                    <td>{{ $r->ContactPersonPhone }}</td>
                </tr>
                <tr>
                    <td>Contact Person Email</td>
                    <td>{{ $r->ContactPersonEmail }}</td>
                </tr>
                <tr>
                    <td>Company Status</td>
                    <td>{{ $r->CompanyStatus }}</td>
                </tr>
            </table>
            <p>It been a pleasure sticking with us</p>

            <p class="signature">Best regards,<br>{{ config('app.name') }}</p>

           
        </div>
    </body>

    </html>

