<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Bienvenido al procesador de cadenas</h1>
    <?php
    echo "<form action='#' method='post' enctype='multipart/form-data'>
        <label></label>Introduce hasta 7 cadenas y una imagen</label><br>
        <input type='text' name='text1' placeholder='Introduce una cadena'><br>
        <input type='text' name='text2' placeholder='Introduce una cadena'><br>
        <input type='text' name='text3' placeholder='Introduce una cadena'><br>
        <input type='text' name='text4' placeholder='Introduce una cadena'><br>
        <input type='text' name='text5' placeholder='Introduce una cadena'><br>
        <input type='text' name='text6' placeholder='Introduce una cadena'><br>
        <input type='text' name='text7' placeholder='Introduce una cadena'><br><br>
        <label>Introduce una imagen</label><br>
        <input type='file' name='img''><br><br>
        <input type='submit' name='enviar'>
    </form>";
    ?>
</body>
</html>