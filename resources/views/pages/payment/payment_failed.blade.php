<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
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
            border: 2px solid #FF0000; /* Red border */
            border-radius: 10px;
            background-color: #FFD2D2; /* Light red background */
        }
    </style>
</head>

<body>
    <div class="message">
        <h2>Payment Failed</h2>
        <p>We are sorry, but your payment has failed.</p>
        <p>Please check your payment details and try again.</p>
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
