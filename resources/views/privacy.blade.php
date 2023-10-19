<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Gau - Privacy Policy</title>
    <style>
        .header {
            display: flex;
            align-items: center;
        }

        .header-logo {
            max-width: 100px;
            /* Set your desired maximum width */
            max-height: 70px;
            /* Set your desired maximum height */
        }

        .logo-name {
            margin-left: 10px; /* Adjust the margin as needed */
        }

        h1 {
            margin-left: 20px; /* Adjust the margin as needed */
        }
    </style>
</head>

<body>
    <div class="header">
        <a href="">
            <img alt="image" src="/assets/img/logo1.png" class="header-logo" />
            <span class="logo-name"></span>
        </a>
        <h1>Privacy Policy</h1>
    </div>

    @if (isset($privacyPolicy))
        <p>{!! $privacyPolicy->description !!}</p>
    @else
        <p>No privacy policy available.</p>
    @endif
</body>

</html>
