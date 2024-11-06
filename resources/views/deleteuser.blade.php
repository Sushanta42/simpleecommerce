<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Gau - Remove User</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            align-items: center;
            background-color: #333;
            color: white;
            padding: 10px;
        }

        .header-logo {
            max-width: 100px;
            max-height: 70px;
        }

        h1 {
            margin-left: 20px;
            font-size: 24px;
        }

        .message-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 20vh; /* Adjust as needed */
        }

        .message {
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="header">
        <a href="">
            <img alt="image" src="/assets/img/logo1.png" class="header-logo" />
            <span class="logo-name"></span>
        </a>
        <h1>Remove User</h1>
    </div>

    <div class="message-container">
        <div class="message">
            <p>You may delete your account at any time. Removal requests must be made by contacting our customer support at 9843855539 or by filling up the form.</p>
        </div>
    </div>

    <form action="#" method="post" onsubmit="showSuccessDialog()">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" required>

        <label for="reason">Reason:</label>
        <textarea id="reason" name="reason" rows="4" required></textarea>

        <button type="submit">Submit</button>
    </form>

    <script>
        function showSuccessDialog() {
            alert("User removal request submitted successfully!");
            // You can replace the alert with a more sophisticated dialog library if needed
        }
    </script>
</body>

</html>
