<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Online Market Place</title>
    <link rel="shortcut icon" href="{{ asset('public/assets/upload/bxell_logo.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #cfcdc8;
        }

        .login-container {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-form {
            background: rgba(246, 243, 243, 0.1);
            backdrop-filter: blur(80px);
            border-radius: 10px;
            padding: 20px 40px;
            box-shadow: 0 10px 30px rgba(44, 43, 43, 0.3);
            max-width: 422px;
            width: 100%;
            box-sizing: border-box;
            background-color: rgba(0, 0, 0, 0.9);
        }

        .login-form h2 {
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

        .text-danger {
            color: red;
        }
    </style>
  </head>

  <body>

    <div class="login-container">
        <form class="login-form" action="{{ url('login') }}" method="POST" id="login-form">
            @csrf

            @if (Session::has('success'))
                <div class="alert alert-success" role="alert" id="success-message">
                    {{ Session::get('success') }}
                </div>
            @endif

            @if (session('fail'))
                <div class="alert alert-danger" id="error-message">
                    {{ session::get('fail') }}
                </div>
            @endif

            <h2><b>Login</b></h2>
            <div class="input-group">
                <label for="email">Email ID</label>
                <input type="email" id="email" name="email" placeholder="Enter your email">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group mb-4">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password">
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="d-flex justify-content-around align-items-center mb-3">
                <button type="submit"><b>Login</b></button>
                <a href="{{ url('signup') }}" class="register"><b>Sign up</b></a>

            </div>
            {{-- <a href="{{ url('forgot-password') }}" style="color:white; ">Forgot Password ?</a> --}}
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // // Set the email value from localStorage if it exists
        // $(document).ready(function() {
        //     var storedEmail = localStorage.getItem('userEmail');
        //     if (storedEmail) {
        //         $('#email').val(storedEmail);
        //     }
        // });

        // // Save the email value to localStorage before form submission
        // $('#login-form').on('submit', function() {
        //     var email = $('#email').val();

        //     // Check if the email is not empty or undefined
        //     if (email) {
        //         localStorage.setItem('userEmail', email);
        //     } else {
        //         // Optionally, you can clear the storage or handle empty email
        //         localStorage.removeItem('userEmail'); // Clear stored email if any
        //     }
        // });


        // Fade out success message after 6 seconds
        setTimeout(function() {
            $('#success-message').fadeOut('fast');
        }, 10000);

        // Fade out error message after 6 seconds
        setTimeout(function() {
            $('#error-message').fadeOut('fast');
        }, 10000);
    </script>
  </body>

</html>
