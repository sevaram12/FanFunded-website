<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Online Market Place</title>
    
    <link rel="shortcut icon" href="{{asset('public/assets/upload/header-logo.png')}}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #cfcdc8;
        }

        .register-container {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-form {
            background: rgba(246, 243, 243, 0.1);
            backdrop-filter: blur(80px);
            border-radius: 10px;
            padding: 20px 40px;
            box-shadow: 0 10px 30px rgba(44, 43, 43, 0.3);
            max-width: 550px;
            width: 100%;
            box-sizing: border-box;
            background-color: rgba(0, 0, 0, 0.9);
        }

        .register-form h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #ffcc00;
            font-family: 'Silka-SemiBold';
            letter-spacing: 1.2px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: #000;
            font-family: Arial, Helvetica, sans-serif;
            letter-spacing: 1px;
            font-weight: 400;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 8px;
            outline: none;
            box-sizing: border-box;
        }

        button,
        .register {
            letter-spacing: 1.4px;
            font-weight: 400;
            border: 1px solid #ffcc00;
            color: #ffcc00;
            padding: 6px 14px;
            border-radius: 9px;
            background: transparent;
            text-transform: uppercase;
            text-decoration: none;
            font-family: 'Silka-SemiBold';
            transition: all 0.3s ease;
        }



        button:hover,
        .register:hover {
            background-color: #ffcc00;
            color: rgba(0, 0, 0, 0.9) !important;
        }

        .btn-submit {
            letter-spacing: 1px;
            font-weight: 400;
            border: 1px solid #ffcc00;
            color: #ffcc00;
            margin: 0px;
            padding: 6px 14px;
            border-radius: 9px;
            vertical-align: top;
            display: inline-block;
            background: transparent;
            text-transform: uppercase;
            text-decoration: none;
            font-family: 'Silka-SemiBold';
            transition: all 0.3s ease;
            margin-top: 12px;
        }

        .btn-submit:hover {
            background-color: #ffcc00;
            color: #fff !important;
        }

        .text-danger {
            color: red;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <form class="register-form" action="{{url('signup')}}" method="POST">
            @csrf
            <h2 style="color: #ffcc00; font-family: Silka-Black; letter-spacing:1.2px; text-align: center; margin-bottom:20px"><b>Registration</b></h2>
            <div class="row">
                <div class="col-6">
                    <div class="input-group">
                        <label for="name">Vendor Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your name" value="{{ old('name') }}">
                        @error('name')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-6">
                    <div class="input-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" id="phone_no" name="phone_no" placeholder="Enter your phone number" value="{{ old('phone_no') }}" maxlength="10">
                        @error('phone_no')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-group">
                        <label for="email">Email ID</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}">
                        @error('email')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                </div>
               

                <div class="col-6">
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password">
                        @error('password')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                
            </div>
            
            
            <div class="d-flex justify-content-center align-items-center gap-3">
              <a href="{{url('/')}}" class="btn-submit" style="text-decoration: none; margin: 0px;"><i class="fa-solid fa-left-long"></i></a>
                <button type="submit">Submit</button>
                <button type="reset" id="reset">Reset</button>
            </div>
            
        </form>
    </div>
</body>

</html>
