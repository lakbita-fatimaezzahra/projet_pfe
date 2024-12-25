<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            background-color: #006D24;
            color: white;
        }
        .navbar ul {
            display: flex;
            list-style: none;
        }
        .navbar ul li {
            margin: 0 15px;
        }
        .navbar .a {
            color: rgb(255, 255, 255);
            font-weight: bold;
        }
        .navbar .login-btn {
            background-color: #ffffff;
            color: rgb(0, 0, 0);
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 0.9rem;
            margin-left: 95%;
        }



    </style>
</head>
<body>
    <div class="navbar">
        
        
        <a href="{{ route('Showlogin') }}" class="login-btn">Logout</a>
    </div>
</body>
</html>
