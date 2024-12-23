<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceuille</title>
    <style>
        /* Reset & Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        a {
            text-decoration: none;
            color: inherit;
        }

        /* Navbar */

        /* Hero Section */
        .hero-section {
            display: flex;
            /* align-items: center;
            justify-content: space-between; */
            background-color: #0B8E36;
            color: white;
            padding: 50px 20px;
        }
        .hero-text {
            flex: 1;
        }
        .hero-text h1 {
            font-size: 1.5rem;
        }
        .hero-text h2 {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 20px 0;
        }
        .hero-text p {
            font-size: 1.2rem;
            margin: 20px 0;
        }
        .hero-text a {
            background-color: #ffffff;
            padding: 10px 20px;
            color: rgb(0, 0, 0);
            border-radius: 5px;
            font-weight: bold;
            font-size: 1rem;
        }
        .hero-image {
            flex: 1;
            display: flex;
            justify-content: center;
        }
        .hero-image img {
            /* max-width: 90%; */
            height: 500px;
            width: 400px;
            border-radius: 10px;
        }

        /* Services Section */
        .services-section {
            padding: 50px 20px;
            text-align: center;
        }
        .services-section h2 {
            font-size: 2rem;
            margin-bottom: 30px;
        }
        .services-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .service {
            flex: 1;
            max-width: 300px;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            text-align: left;
        }
        .service h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }
        .service p {
            font-size: 1rem;
            color: #555;
        }

        /* Footer */
        .footer {
            background-color: #1e2b37;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 50px;
        }
        .body{
            margin-left: 15px
        }
        .home2{
            margin-left: 15px
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <x-navbar />

    <!-- Hero Section -->
    <div class="hero-section">
        <!-- Hero Text -->
        <div class="hero-text">
            <h1>Hi, There!</h1>
            <h2>We are a growing-up PFE TRACKER from Morocco!</h2>
            <p>Stay organized with PFE Tracker the ultimate tool to seamlessly manage your projects,
                track progress, and achieve success through a perfect blend of innovation and efficiency.
            </p>
            <a href="#services">Let’s Study →</a>
        </div>
        <!-- Hero Image -->
        <div class="hero-image">
            <img src={{ asset('images/hero.jpg') }} alt="Creative Team Working">
        </div>

    </div>
    <div class="body">
        <img src={{ asset('images/home.png') }} width="1500" alt="home">
    </div>
  

    <!-- Services Section -->
    <div class="services-section" id="services">
        <h2>Devouvrire</h2>
        <div class="services-container">
            <div class="service">
                <h3>Formation</h3>
                <p>Make your website user-friendly and visually stunning with our expertise.</p>
            </div>
            <div class="service">
                <h3>Employabilité</h3>
                <p>Gain more followers or subscribers with professional social media designs.</p>
            </div>
            <div class="service">
                <h3>recherche & inovation</h3>
                <p>Complete your digital work with custom and innovative illustrations.</p>
            </div>
        </div>
    </div>
    <div class="body2">
        <img src={{ asset('images/home2.png') }} width="1500" alt="home">
    </div>

    <!-- Footer -->
    <x-footer />
</body>
</html>
