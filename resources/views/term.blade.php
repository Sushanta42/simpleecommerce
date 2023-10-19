<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Gau - Terms and Conditions</title>
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
        <h1>Terms and Conditions</h1>
    </div>

    @if (isset($termCondition))
        <p>{!! $termCondition->description !!}</p>
    @else
        <p>No Terms and Conditions available.</p>
    @endif
</body>

</html>
