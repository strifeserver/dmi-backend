<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Complete</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .message {
            text-align: center;
            padding: 20px;
            border: 2px solid #333;
            border-radius: 10px;
            background-color: #f0f0f0;
        }

        .redirect-message {
            margin-top: 20px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="message">
        <h2>Payment Complete</h2>
        <p>Thank you for your payment!</p>
        <p>Your payment has been successfully processed.</p>
        <p class="redirect-message">You will be redirected momentarily.</p>
    </div>

    <script>
        // Function to redirect after 4 seconds
        function redirect() {
            window.location.href = "/survey_history"; // Replace "/" with your desired base URL
        }

        // Delay the redirect after 4 seconds
        setTimeout(redirect, 3000);
    </script>
</body>

</html>
