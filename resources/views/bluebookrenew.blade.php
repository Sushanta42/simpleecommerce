<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Gau - Bluebook Renewal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
            background-color: #f84235;
            color: white;
            padding: 10px;
        }

        .header-logo {
            width: 70px;
            height: 70px;
            border-radius: 50%;
        }

        h1 {
            margin-left: 20px;
            font-size: 24px;
        }

        .header-title {
            margin-left: 20px;
        }

        .header-title h1 {
            margin: 0;
            font-size: 24px;
        }

        .header-title .smart-gau {
            font-size: 16px;
            display: block;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .tnc-link {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 17px;
            color: #007bff;
            text-decoration: none;
        }

        .tnc-link i {
            margin-right: 5px;
        }

        .tnc-link:hover {
            text-decoration: underline;
        }

        .alert {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-success {
            color: #3c763d;
            background-color: #dff0d8;
            border-color: #d6e9c6;
        }

        .alert-danger {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
        }

        .alert-dismissible .close {
            position: relative;
            top: -2px;
            right: -21px;
            color: inherit;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .required {
            color: red;
        }

        .input-group {
            display: flex;
            align-items: center;
        }

        .input-group .fa {
            margin-right: 10px;
            font-size: 1.2em;
        }

        input,
        select,
        textarea {
            width: calc(100% - 30px);
            padding: 10px;
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

        .image-representation {
            text-align: center;
            margin: 5px 0;
        }

        .image-representation img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            border: 2px solid #ddd;
        }

        .image-citizenship {
            width: 200px;
            /* Adjust width as needed */
            height: auto;
        }

        .image-vehicleinfo {
            width: 150px;
            /* Adjust width as needed */
            height: auto;
        }

        .image-renewinfo {
            width: 150px;
            /* Adjust width as needed */
            height: auto;
        }

        .notice {
            font-size: 15px;
            color: #f39c12;
            text-align: center;
            margin-bottom: 10px;
        }

    </style>
</head>

<body>
    <div class="header">
        <a href="">
            <img alt="image" src="/assets/img/logo1.png" class="header-logo" />
            <span class="logo-name"></span>
        </a>
        <div class="header-title">
            <span class="smart-gau">SmartGau - स्मार्ट गाउँ</span>
            <h1>Bluebook Renewal</h1>
        </div>
    </div>

    <div class="container">
        <a href="{{ url('/bluebookrenewtnc') }}" class="tnc-link"><i class="fa fa-file-alt"></i>T&C</a>
        <div class="image-representation">
            <img src="/assets/img/bluebookrenew.png" alt="Bluebook Renewal Service">
        </div>

        @if (Session::has('success') || Session::has('error'))
            <div class="alert alert-{{ Session::has('success') ? 'success' : 'danger' }} alert-dismissible fade show"
                role="alert">
                {{ Session::has('success') ? Session::get('success') : Session::get('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <script>
                setTimeout(function() {
                    $('.alert').alert('close');
                }, 3000); // Close the alert after 3 seconds (3000 milliseconds)
            </script>
        @endif
        <p class="notice">Register Now to Avoid Fine</p>
        <form action="{{ route('bluebookrenew.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Full Name<span class="required"> *</span></label>
                <div class="input-group">
                    <i class="fa fa-user"></i>
                    <input id="name" class="form-control" type="text" name="name"
                        value="{{ old('name') }}">
                </div>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone">Phone<span class="required"> *</span></label>
                <div class="input-group">
                    <i class="fa fa-phone"></i>
                    <input id="phone" class="form-control" type="number" name="phone"
                        value="{{ old('phone') }}">
                </div>
                @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email (Optional)</label>
                <div class="input-group">
                    <i class="fa fa-envelope"></i>
                    <input id="email" class="form-control" type="email" name="email"
                        value="{{ old('email') }}">
                </div>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="municipality">Municipality<span class="required"> *</span></label>
                <div class="input-group">
                    <i class="fa fa-map-marker-alt"></i>
                    <input id="municipality" class="form-control" type="text" name="municipality"
                        value="{{ old('municipality') }}">
                </div>
                @error('municipality')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="address">Address<span class="required"> *</span></label>
                <div class="input-group">
                    <i class="fa fa-home"></i>
                    <input id="address" class="form-control" type="text" name="address"
                        value="{{ old('address') }}">
                </div>
                @error('address')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="image_citizen">CitizenShip/License (Optional)</label>
                <input id="image_citizen" class="form-control-file" type="file" name="image_citizen">
                @error('image_citizen')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="image-representation">
                    <img src="/assets/img/citizenship.png" alt="Citizenship/License Image" class="image-citizenship">
                </div>
            </div>
            <div class="form-group">
                <label for="image_front">Vehicle Info Page (Optional)</label>
                <input id="image_front" class="form-control-file" type="file" name="image_front">
                @error('image_front')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="image-representation">
                    <img src="/assets/img/vehicleinfo.png" alt="Vehicle Info Page Image" class="image-vehicleinfo">
                </div>
            </div>
            <div class="form-group">
                <label for="image">Renew Info Page (Optional)</label>
                <input id="image" class="form-control-file" type="file" name="image">
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="image-representation">
                    <img src="/assets/img/renewinfo.png" alt="Renew Info Page Image" class="image-renewinfo">
                </div>
            </div>
            <div class="form-group">
                <label for="vehicle_type">Vehicle Type</label>
                <select id="vehicle_type" class="form-control" name="vehicle_type">
                    <option value="2_wheeler" {{ old('vehicle_type') == '2_wheeler' ? 'selected' : '' }}>2 Wheeler
                    </option>
                    <option value="4_wheeler" {{ old('vehicle_type') == '4_wheeler' ? 'selected' : '' }}>4 Wheeler
                    </option>
                    <option value="others" {{ old('vehicle_type') == 'others' ? 'selected' : '' }}>Others</option>
                </select>
                @error('vehicle_type')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Description (Optional)</label>
                <textarea id="description" class="form-control" name="description" rows="4">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-md">Renew Bluebook</button>
        </form>
    </div>
</body>

</html>
