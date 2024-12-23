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
            background-color: #1e2b37;
            color: white;
        }
        .navbar ul {
            display: flex;
            list-style: none;
        }
        .navbar ul li {
            margin: 0 15px;
        }
        .navbar a {
            color: white;
            font-weight: bold;
        }
        .navbar .login-btn {
            background-color: #00a8cc;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <h3>PFE TRACK</h3>
        </div>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#portfolio">Portfolio</a></li>
            <li><a href="#blog">Blog</a></li>
        </ul>
        <a href="{{ route('login') }}" class="login-btn">Login</a>
    </div>
</body>
</html>
