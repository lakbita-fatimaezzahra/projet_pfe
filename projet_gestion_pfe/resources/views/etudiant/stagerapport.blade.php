<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <title>User Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #0B8E36;
            color: white;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .navbar {
            width: 100%;
            background-color: #006D24;
            padding: 10px 20px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            position: absolute;
            top: 0;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            margin: 0 10px;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .logout {
            background: none;
            border: 1px solid white;
            padding: 5px 10px;
            background-color: white;
            color: rgb(15, 15, 15);
            cursor: pointer;
            border-radius: 5px;
        }

        .logout:hover {
            background-color: #f1f1f1;
        }

        h1 {
            position: absolute;
            top: 90px;
            left: 300px;
            text-align: left;
        }
        .container{
            text-align: center;
            font-size: 30px
        }
        p{
            font-weight: bold
        }

        .button-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .button-row {
            display: flex;
            justify-content: center;
            gap: 200px;
            margin: 20px 0;
        }

        .btn {
            display: inline-block;
            padding: 20px 30px;
            font-size: 25px;
            color: #000000;
            background-color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #f1f1f1;
        }

        .study-btn {
            padding: 20px 40px;
            border-radius: 50px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    {{-- <div class="navbar">
        <div class="logo">
            <img src={{ asset('images/emsiLogo.png') }} alt="Logo" style="height: 40px;">
        </div>
        <div class="menu">
            <a href="#">Home</a>
            <a href="#">About</a>
            <a href="#">Service</a>
            <a href="#">Contact Us</a>
        </div>
        <button class="logout">Logout</button>
    </div> --}}
    <x-dashnav/>
    @if (Session::get('error'))
    <script>
   swal("message", "{{Session::get('error')}}",'error',{
    button:true,
    button:"OK",
    timer:3000,
    dangerMode:true,
   })
    </script>
    @endif
    <h1>Hi, Username!</h1>

    <div class="container">
        <p>Choose where to be redirected</p>
        <div class="button-wrapper">
            <div class="button-row">
                <a href="#" class="btn">Stage Documents</a>
                <a href="#" class="btn">Rapport de Stage</a>
            </div>
            <a href="#" class="btn study-btn">Let's Study →</a>
        </div>
    </div>
</body>
</html>
