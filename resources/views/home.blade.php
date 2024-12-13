<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        h1 {
            color: #4CAF50;
        }

        p {
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Bienvenido a Batuta Gestión</h1>
        <p>La ruta está funcionando correctamente.</p>
        <a href="{{ url('/login') }}"
            style="text-decoration: none; color: white; background-color: #4CAF50; padding: 10px 20px; border-radius: 5px;">Ir
            a Login</a>
    </div>
</body>

</html>
