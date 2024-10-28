<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <style>
        
    </style>
</head>
<body>
    
    <?php
        function soloLetras($c){
            return preg_match("'(?!.*[^a-zA-Z]).+'", $c);
        }

        function comprobarCadenas($c ){
            /*Para clasificar las cadenas usare una matriz con un booleano y el nombre de la categoria*/
            /*1. Cadena vacía. */
            $categoria[0]=[false, "Cadena vacía"];

            /*2. Cadena con una única palabra (sólo letras, puede haber espacios delante y detrás).*/
            $categoria[1]=[false, "Cadena con una única palabra"];

            /*3. Cadena con dos palabras (sólo letras, separadas por uno o variosespacios).*/
            $categoria[2]=[false, "Cadena con dos palabras"];

            /*4. Cadena con una enumeración (tres o más palabras separadas con comas).*/   
            $categoria[3]=[false, "Cadena con una enumeración"];

            /*5. Cadena con un número decimal.*/
            $categoria[4]=[false, "Cadena con un número decimal"];

            /*6. Cadena con un único número impar.*/
            $categoria[5]=[false, "Cadena con un número impar"];

            /*7. Número de teléfono (9 cifras, empezando por 6, 7, 8 o 9 y prefijo, signo+ y 2 números).*/
            $categoria[6]=[false, "Número de teléfono"];

            /*8. Número del DNI (8 números, con letra final mayúscula).*/
            $categoria[7]=[false, "Número del DNI"];

            /*9. Contraseña (al menos seis caracteres, debe contener
                a. Debe tener entre 8 y 20 caracteres.
                b. Debe contener al menos 2 números (no tienen que ser
                consecutivos).
                c. Debe contener al menos 1 letra mayúscula y 3 caracteres
                especiales (no consecutivos). */
            $categoria[8]=[false, "Contraseña"];

            /*10.Formato desconocido: Si no puede clasificarse en ninguna de las categorías anteriores.*/
            $categoria[9]=[false, "Formato desconocido"];

            /*Comprobar cadena*/
            $categorias= array(); //Aqui introducire a que categorias pertenece
            
            /*1. Cadena vacía. Como le he hecho un trim la longitud de una cadena de solo espacios es 0*/
            if(strlen($c) == 0){
                $categoria[0][0] = true;
                $categorias[]=$categoria[0][1]." ";
            }

            //AQUI AGRUPO TODAS LAS CADENAS QUE SEAN EXCLUYENTES: 7, 8 y 9
            /*7. Número de telfono (9 cifras, empezando por 6, 7, 8 o 9 y prefijo, signo+ y 2 números).*/
            if(preg_match("'^\+[0-9]{2}\s?[6789]\s*([0-9]\s*){8}'", $c)){// preg_match("'^\+[0-9]{2}[6789][0-9]{8}'", $c), empezar por + seguido de 2 cifras que sean 6789 y seguido de 8 cifras
                $categoria[6][0] = true;
                $categorias[]=$categoria[6][1]." ";

            /*8. Número del DNI (8 números, con letra final mayúscula).*/
            } else  if(preg_match("'^[0-9]{8}[A-Z]$'", $c)){ //preg_match("'^[0-9]{8}[A-Z]$'", $c), empezar por 8 numeros y terminar por letra mayuscula
                $categoria[7][0] = true;
                $categorias[]=$categoria[7][1]." ";

            /*9. Contraseña*/
            } else if(preg_match("'^(?!.*\s)(?=.*[0-9]{2,})(?=.*[A-Z])(?=.*[^a-zA-Z0-9]{3,}).{8,20}$'", $c)) { //(?=.*[0-9]){2,}, almenos 2 numeros. (?=.*[A-Z]), almenos una mayuscula. (?=.*[^a-zA-Z0-9]){3,}, almenos 3 caracteres que no sean los del corchete
                $categoria[8][0] = true;
                $categorias[]=$categoria[8][1]." ";
            } else{

                /*4. Cadena con una enumeración (tres o más palabras separadas con comas).*/              
                if(preg_match("'\b([a-zA-Z]+\s*,\s*){2}[a-zA-Z]+(?![0-9]])'", $c)){
                    $categoria[3][0] = true;
                    $categorias[]=$categoria[3][1]." ";

                /*3. Cadena con dos palabras (sólo letras, separadas por uno o variosespacios).*/
                } else if(preg_match("'\b[a-zA-Z]+\s+[a-zA-Z]+\b(?![0-9])'", $c)){
                        $categoria[2][0] = true;
                        $categorias[]=$categoria[2][1]." ";

                /*2. Cadena con una única palabra (sólo letras, puede haber espacios delante y detrás). preg_match("'(?!.*[^a-zA-Z]).+'") NO PERMITE INTRODUCIR CARACTERES QUE NO SEAN LETRAS*/
                } else if(preg_match("'\b[a-zA-Z]+\b(?![0-9])'", $c)){
                        $categoria[1][0] = true;
                        $categorias[]=$categoria[1][1]." ";
                    }  
            }

            /*5. Cadena con un número decimal. [0-9]+[.,][0-9] Empezar por un numero, puede haber 0 o mas numeros, continuar por punto o coma, tener despues almenos un numero y  terminar por numero*/
            if(preg_match("'[0-9]+[.,][0-9]'", $c)){
                $categorias[]=$categoria[4][1]." ";
            }
            
            /*6. Cadena con número impar.*/
            if(preg_match("'[0-9]*[13579]\b'", $c)){
                $categoria[5][0] = true;
                $categorias[]=$categoria[5][1]." ";
            }
                
            
            /*10.Formato desconocido.*/
            $aux= false; //para comprobar que todas las categorias estan en false
            for($i=0; $i<count($categoria); $i++){ //para este voy a comprobar si todas las categorias estan en false, si es asi la cadena pertenece a Formato desconocido
                if($categoria[$i][0] == true){
                    $aux=true;
                }
            } 
            if($aux==false){
                $categoria[9][0] = true;
                $categorias[]=$categoria[9][1]." ";
            }
            $cat=implode("," , $categorias);
            return $cat;
        }

        /*Si el isset($_FILES['img']) existe lo almaceno en $img*/
        if(isset($_FILES["img"])){
            if(strcmp(explode("/",$_FILES["img"]["type"])[0], "image")==0){ //Lo separo y lo comparo con "image"
                $img = $_FILES['img'];
                $ruta ="../img/";

                if(!file_exists($ruta)){
                    mkdir($ruta);
                }

                $origen = $_FILES["img"]["tmp_name"];

                if(isset($_POST["opt"])){
                    $opcion = "text".$_POST["opt"];
                    if(isset($_POST["$opcion"])){
                        $destino = $ruta.$_POST["$opcion"].".".explode("/",$_FILES["img"]["type"])[1];
                    } 
                } else {
                    $destino = $ruta.$_FILES["img"]["name"];
                }

                

                move_uploaded_file($origen, $destino);
            } else{ //Si no es imagen reinicio la pagina
                header("Location: ./procesamiento.php?err=1");
            }
        }

        /*isset($_POST['formulario']) Si el formulario ya se ha enviado alguna vez no me lo muestra*/
        if(isset($_POST['formulario'])){

            /*Meto las cadenas en un array vacio*/
            $cadenas = array();
            for($i = 0; $i < 7; $i++){
                /*si el isset($_POST['text'.$i]) existe que introduzca el valor en la siguiente posicion del array*/
                if(isset($_POST['text'.$i])){
                    $cadenas[] = trim($_POST['text'.$i]); //.trim() para eliminar espacios delante y detras
                }
            }

            echo "<div class='tabla'><table>
                    <tr><th>Cadenas</th><th>categorias</th></tr>";
                    foreach($cadenas as $c){
                        echo "<tr><td>$c</td><td>".comprobarCadenas($c)."</td></tr>";
                    }
            echo "</table> <br>
            <img src='$destino' width='200px' height='200px'>
            <a href='./procesamiento.php'>VOLVER</a><br></div>";

            

            

        }else{
        /*Formulario*/
        echo "<div class='form'>
            <h1>Bienvenido al procesador de cadenas</h1>
                <p>Introduce hasta 7 cadenas y una imagen</p>
                    <form action='#' method='post' enctype='multipart/form-data'>
                        <input type='text' name='text1' placeholder='Introduce una cadena'>
                        <input type='radio' name='opt' value='1'><br>
                        
                        <input type='text' name='text2' placeholder='Introduce una cadena'>
                        <input type='radio' name='opt' value='2'><br>

                        <input type='text' name='text3' placeholder='Introduce una cadena'>
                        <input type='radio' name='opt' value='3'><br>

                        <input type='text' name='text4' placeholder='Introduce una cadena'>
                        <input type='radio' name='opt' value='4'><br>

                        <input type='text' name='text5' placeholder='Introduce una cadena'>
                        <input type='radio' name='opt' value='5'><br>

                        <input type='text' name='text6' placeholder='Introduce una cadena'>
                        <input type='radio' name='opt' value='6'><br>

                        <input type='text' name='text7' placeholder='Introduce una cadena'>
                        <input type='radio' name='opt' value='7'><br><br>";

                        if(isset($_GET["err"])){
                            echo "<span class='err'>El archivo introducido no es una imagen</span><br>";
                            header("Refresh: 3; URL=./procesamiento.php");
                        }

                        echo "<div class='archivo'>
                            <input type='file' name='img' id='img'/>
                            <label for='img'>
                            <svg xmlns='http://www.w3.org/2000/svg' class='iborrainputfile' width='20' height='17' viewBox='0 0 20 17'><path d='M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z'></path></svg>
                            <span class='iborrainputfile'>Seleccionar archivo</span>
                            </label>
                        </div>  
                        
                        <input type='submit' name='formulario' value='ENVIAR'>
                    </form></div>";
    }
    ?>
</body>
</html>