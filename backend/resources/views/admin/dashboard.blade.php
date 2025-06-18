<!DOCTYPE html>
<html>
<head>
    <title>Panel del Administrador</title>
</head>
<body>
    <h1>Bienvenido, administrador {{ Auth::user()->name }}</h1>
    <p>Aquí podrás gestionar productos, categorías, imágenes, etc.</p>
</body>
</html>
