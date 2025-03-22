<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to StoreMe</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Nunito', sans-serif;
        }

        body {
            background-color: #0A2540;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #1B4965;
            padding: 3rem;
            border-radius: 15px;
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        .logo {
            margin-bottom: 20px;
        }

        .logo h1 {
            font-size: 2.5rem;
            color: #F0F6F6;
        }

        .logo p {
            font-size: 0.9rem;
            color: #D2E4F0;
        }

        h2 {
            margin: 1rem 0 2rem;
        }

        .buttons a {
            display: block;
            background-color: #3B9EDC;
            color: white;
            text-decoration: none;
            padding: 12px;
            border-radius: 8px;
            margin: 10px 0;
            transition: background-color 0.3s ease;
        }

        .buttons a:hover {
            background-color: #3189c6;
        }
    </style>
</head>
<body>
    <div style="position: absolute; top: 5px; width: 100%; text-align: center;">
        <img src="{{ asset('images/storeme-logo.png') }}" alt="StoreMe Logo" style="width: 200px; height: auto;">
    </div>
    <div class="container">
        <div class="logo">
            <h1>StoreMe!</h1>
            <p>Lock it. Leave it. Love it.</p>
        </div>
        <h2>Welcome to StoreMe!</h2>
        <div class="buttons">
            <a href="{{ route('login') }}">Log In</a>
            <a href="{{ route('register') }}">Register</a>
        </div>
    </div>
</body>
</html>