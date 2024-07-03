<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>

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
            /* background-image: url('{{ asset('images/image2.png') }}'); */
            background-image: url('https://images.fineartamerica.com/images/artworkimages/mediumlarge/1/desert-road-landscape-bekim-art.jpg');

            /* background-size: cover;
            background-position: center; */
            background-size: cover;
            /* Ensure the whole image is shown */
            background-repeat: no-repeat;
            /* Prevent the image from repeating */
            background-position: center;
            /* Center the image within the container */
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
    <div class="left">
        <div class="form-container">
            <h1>ROUTE PLANNER</h1>
            <h3>Register</h3>
            <form method="POST" action = '/register_submit'>
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter name">
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
    <div class="right"></div>
</body>

</html>
