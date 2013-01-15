<?php
if(!$_POST["Nick"]){
    ?>
    <style>
        .Color{
            background-color: black;
            color: black;
        }
        table.Colores{
            background-color: gray;
        }
        table.Colores tr td{
            width: 6px;
        }
        table.colores tr td:hover{
            cursor: hand;
            cursor: pointer;
        }
    </style>
    <script>
        function CAMBIAR_COLORES(Color){
            window.document.getElementById('ColorUsar').value = Color.replace(/,/g,";");
            window.document.getElementById('CajaColor').style.color = 'rgb(' + Color + ')';
            window.document.getElementById('CajaColor').style.backgroundColor = 'rgb(' + Color + ')';
        }
    </script>
    <form name="ProFirmas" method="post" action="." enctype="multipart/form-data">
        <table>
            <tr>
                <td>Nick :</td><td><input type="text" name="Nick"/></td>
                <td>Contraseña : </td><td><input type="password" name="Contrasena"/></td>
                <!--<td>Contraseña otra vez : </td><td><input type="password" name="ContrasenaV"/></td>-->
                <td>Fichero firma(Max 640x240 a 80Kbytes) :</td><td><input type="file" name="ImagenSubida"/></td>
            </tr><tr>
                <td>Color Letras : </td><td><input type="hidden" id="ColorUsar" name="Color"/><a id="CajaColor" href="#Color" class="Color">XYZ</a></td>
                <td colspan="2"><input type="submit" value="Enviar"/></td>
            </tr>
        </table>
    </form>
    <br>
    <table class="Colores">
        <tr>
            <td style="color: black; background-color: black;" onclick="CAMBIAR_COLORES('0,0,0');">X</td><td style="color: rgb(100,100,100); background-color: rgb(100,100,100);" onclick="CAMBIAR_COLORES('100,100,100');">X</td><td style="color: rgb(128,0,0); background-color: rgb(128,0,0);" onclick="CAMBIAR_COLORES('128,0,0');">X</td><td style="color: rgb(128,128,0); background-color: rgb(128,128,0);" onclick="CAMBIAR_COLORES('128,128,0');">X</td><td style="color: rgb(0,128,0); background-color: rgb(0,128,0);" onclick="CAMBIAR_COLORES('0,128,0');">X</td><td style="color: rgb(0,128,128); background-color: rgb(0,128,128);" onclick="CAMBIAR_COLORES('0,128,128');">X</td><td style="color: rgb(0,0,128); background-color: rgb(0,0,128);" onclick="CAMBIAR_COLORES('0,0,128');">X</td><td style="color: rgb(128,0,128); background-color: rgb(128,0,128);" onclick="CAMBIAR_COLORES('128,0,128');">X</td><td style="color: rgb(128,128,64); background-color: rgb(128,128,64);" onclick="CAMBIAR_COLORES('128,128,64');">X</td><td style="color: rgb(0,64,64); background-color: rgb(0,64,64);" onclick="CAMBIAR_COLORES('0,64,64');">X</td><td style="color: rgb(0,128,255); background-color: rgb(0,128,255);" onclick="CAMBIAR_COLORES('0,128,255');">X</td><td style="color: rgb(0,64,128); background-color: rgb(0,64,128);" onclick="CAMBIAR_COLORES('0,64,128');">X</td><td style="color: rgb(128,0,255); background-color: rgb(128,0,255);" onclick="CAMBIAR_COLORES('128,0,255');">X</td><td style="color: rgb(128,64,0); background-color: rgb(128,64,0);" onclick="CAMBIAR_COLORES('128,64,0');">X</td>
        </tr>
        <tr>
            <td style="color: rgb(255,255,255); background-color: rgb(255,255,255);" onclick="CAMBIAR_COLORES('255,255,255');">X</td><td style="color: rgb(192,192,192); background-color: rgb(192,192,192);" onclick="CAMBIAR_COLORES('192,192,192');">X</td><td style="color: rgb(255,0,0); background-color: rgb(255,0,0);" onclick="CAMBIAR_COLORES('255,0,');">X</td><td style="color: rgb(255,255,0); background-color: rgb(255,255,0);" onclick="CAMBIAR_COLORES('255,255,0');">X</td><td style="color: rgb(0,255,0); background-color: rgb(0,255,0);" onclick="CAMBIAR_COLORES('0,255,0');">X</td><td style="color: rgb(0,255,255); background-color: rgb(0,255,255);" onclick="CAMBIAR_COLORES('0,255,255');">X</td><td style="color: rgb(0,0,255); background-color: rgb(0,0,255);" onclick="CAMBIAR_COLORES('0,0,255');">X</td><td style="color: rgb(255,0,255); background-color: rgb(255,0,255);" onclick="CAMBIAR_COLORES('255,0,255');">X</td><td style="color: rgb(255,255,128); background-color: rgb(255,255,128);" onclick="CAMBIAR_COLORES('255,255,128');">X</td><td style="color: rgb(0,255,128); background-color: rgb(0,255,128);" onclick="CAMBIAR_COLORES('0,255,128');">X</td><td style="color: rgb(128,255,255); background-color: rgb(128,255,255);" onclick="CAMBIAR_COLORES('128,255,255');">X</td><td style="color: rgb(128,128,255); background-color: rgb(128,128,255);" onclick="CAMBIAR_COLORES('128,128,255');">X</td><td style="color: rgb(255,0,128); background-color: rgb(255,0,128);" onclick="CAMBIAR_COLORES('255,0,128');">X</td><td style="color: rgb(255,128,64); background-color: rgb(255,128,64);" onclick="CAMBIAR_COLORES('255,128,64');">X</td>
        </tr>
    </table>
    <?php
}else{
    include "opciones.php";
    $TamanoMaximo = $MaxTamanoKbytes * 1024;
    $Conexion = mysql_connect($IPServidorMysql,$UsuarioMysql,$ContrasenaMysql);
    mysql_select_db($DbDatos);
    $DirectorioImagenes = "imagenes/"; // El directorio donde van a ir a parar las imágenes aacabada en /
    $URLImagen = "http://los50primeros.x10.mx/imagenes/"; // la url que se guadará la img, acabada en /
    if($_FILES["ImagenSubida"]["error"] == 0 and isset($_FILES["ImagenSubida"])){
        if(intval($_FILES["ImagenSubida"]["size"]) > $TamanoMaximo){
            $PesoEnKbytes = intval($_FILES["ImagenSubida"]["size"]) / 1024;
            $AReducir = $PesoEnKbytes - $MaxTamanoKbytes;
            $AReducir = round($AReducir,2);
            die("Imagen demasiado pesada,max 80Kbytes, pesaba $PesoEnKbytes Kbytes, a reducir $AReducir Kbytes esta imagen!");
        }
        $Dimensiones = getimagesize($_FILES["ImagenSubida"]["tmp_name"]);
        $Imagen = true;
        if($Dimensiones[0] > 800 and $Dimensiones[1] > 600){
            echo "La imagen tiene unas dimensiones demasiado grandes","Dimensiones imagen muy grande";
            exit;
        }
        if($Dimensiones["mime"] != "image/jpeg" and $Dimensiones["mime"] != "image/png"){
            echo "Formato no sopotado : los formatos soportados son, png, , y jpg","Formato NO soportado";
            exit;
        }
        $Extension = substr($_FILES["ImagenSubida"]["name"],strrpos($_FILES["ImagenSubida"]["name"],"."));
        if(file_exists($DirectorioImagenes . "1$Extension")){
            $i = 1;
            while(file_exists($DirectorioImagenes . "$i$Extension")){
                $i++;
            }
        }else{
            $i = 1;
        }
        move_uploaded_file($_FILES["ImagenSubida"]["tmp_name"],$DirectorioImagenes . "$i$Extension") or die("Error de permisos en el servidor");
        $Nick =urlencode($_POST["Nick"]);
        /* Es un login no entiendo el porque quise verificar la contraseña aqui
        if($_POST["Contrasena"] != $_POST["ContrasenaV"]){
            die("Las contraseñas no coinciden");
        }
        */
        $Contrasena = urlencode($_POST["Contrasena"]);
        $Respuesta = @file_get_contents("http://sgtravellers.net/loginRemoto.php?Nick=$Nick&Contrasena=$Contrasena");
        if(!$Respuesta){
            die("FATAL, no se pudo alcanzar el servidor maestro del juego");
        }
        if($Respuesta == "NO"){ // Petición al servidor del juego
            die("Usuario o contraseña incorrecto");
        }
        if($Respuesta == "PDN"){
            die("Este servidor de firmas no ha sido autorizado por el servidor del juego");
        }
        $cdUsuario = intval($Respuesta);
        $Colores = explode(";",$_POST["Color"]);
        $Rojo = intval($Colores[0]);
        $Verde = intval($Colores[1]);
        $Azul = intval($Colores[2]);
        if($Rojo > 255){
            $Rojo = 255;
        }
        if($Verde > 255){
            $Verde = 255;
        }
        if($Azul > 255){
            $Azul = 255;
        }
        $Consulta = mysql_query("SELECT `usercdFirma` FROM `FirmasPersonalizadas` WHERE `usercdFirma`='$cdUsuario';") or die(mysql_error());
        if(mysql_num_rows($Consulta) > 0){
            mysql_query("UPDATE `FirmasPersonalizadas` SET `Firma`='$URLImagen" . "$i$Extension" . "',`Rojo`='$Rojo',`Verde`='$Verde',`Azul`='$Azul' WHERE `usercdFirma`='$cdUsuario';") or die(mysql_error());
        }else{
            mysql_query("INSERT INTO `FirmasPersonalizadas`(`usercdFirma`,`Firma`,`Rojo`,`Verde`,`Azul`)VALUES('$cdUsuario','$URLImagen" . "$i$Extension" . "','$Rojo','$Verde','$Azul');",$Conexion) or die(mysql_error());            
        }
        if(mysql_error()){
            echo "Error de SQL";
        }else{
            header("Location:imagenfirma.png/?cd=$cdUsuario");
        }
    }
}