<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .left {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .right {
            flex: 1;
            /* background-image: url('{{ asset('images/image1.png') }}'); */
            background-image: url('https://images.fineartamerica.com/images/artworkimages/mediumlarge/1/desert-road-landscape-2-bekim-art.jpg');

            background-size: cover;
            background-position: center;
        }

        .form-container {
            width: 80%;
            max-width: 400px;
        }

        .form-control {
            margin-bottom: 15px;
        }

        .form-container h1 {
            margin-bottom: 20px;
            text-align: left;
            /* color: #006666; */
            color: #f4623a;
            /* Change text color to teal */
            font-size: 36px;
            font-weight: bold;

        }
    </style>
</head>

<body>
    @if (session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif
    <div class="left">

        <div class="form-container">
            <h1>ROUTE PLANNER</h1>
            <h3>Login</h3>
            <form method="POST" action = "/login_submit">
                @csrf
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" name = "email" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
                @if (session('error'))
                    <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                @endif
                <span><a href="/register">Didn't have an account? Register</a></span><br>

                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
    <div class="right"></div>
</body>

</html>
