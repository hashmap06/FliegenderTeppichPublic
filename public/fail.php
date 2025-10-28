<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            color: #333;
            text-align: center;
            padding: 25px;
        }
        h1 {
            color: #d9534f;
        }
        p {
            line-height: 1.6;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .container {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        .stefan_face {
            width: 100%;
            height: 100%;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment Failed</h1>
        <p>
            We're sorry, but there was an issue processing your payment. This may be due to incorrect or mismatched information in your order.
        </p>
        <p>
            If you believe this is an error, or if you need assistance, please <a href="contact.php">contact us</a> for support. We are here to help.
        </p>
        <p>
            Please check your PayPal account to ensure the transaction is cancelled, as the ordered item will not be delivered.
        </p>
        <p>
            We apologize for any inconvenience and thank you for your understanding.
        </p>
        <!--<img class="stefan_face" src="uploads\angry_stefan.jpeg">-->
    </div>
</body>
</html>
