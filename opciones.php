<?php
// Secreto de acceso ( es el que permite preguntar al servidor);
$cdSecreto = "pepitolospalotes";
$cocdSecreto = "paquitoelchocolatero";
// IMPORTANTE : Recordar buscar sobre compresión 
$DirectorioImagenes = "../imagenes/"; // El directorio donde van a ir a parar las imágenes aacabada en / , si se usan rutas relativas, el pwd es  este fichero
$DirectorioImagenesThis = "./imagenes"; // Relativo a este fichero
$URLImagen = "http://los50primeros.x10.mx/imagenes/"; // la url que se guadará la img, acabada en /
$MaxTamanoKbytes = 160;
/* Obsoleto
$URLUso = "http://172.74.32.150/imagenfirma.png/?cd="; // Le dice al servidor del juego la dirección a utilizar
*/
// Detalles mysql

$IPServidorMysql = "127.0.0.1"; // Cambiar if required

$UsuarioMysql = "root";

$ContrasenaMysql = "";

$DbDatos = "Db_Temporal";
// Detalles demonio

$SaltoDelinea = "\n"; // usar \n para consola y <br> para html


// Detalles a anunciar! ( Estos detalles serán vistos por los jugadores cuando vayan a elegir firma)

$SoloServidorDelJuego = false; // Requiere que solo el servidor del juego pueda soliticar información de este servidor de manera directa. Recomendado, no obstante desactivar para pruebas locales.
$Propietario = "Kevin Guanche Darias"; // Máx 30

$EspacioMaximo = 1; // En gygabytes, decimales americanos permitidos, ejemplo 0.5 (512Mbytes)

$Descripcion = "IMPORTANTE: Este es para pruebas mias no lo usen D:"; // Máx 150

$Formatos = array();
// Formatos permitidos mediante identificador mime
$Formatos[] = "image/png";
$Formatos[] = "image/jpeg";
$Formatos[] = "image/gif";

//No tocar a partir de aqui
$included = strtolower(realpath(__FILE__)) != strtolower(realpath($_SERVER['SCRIPT_FILENAME']));
$Version = "1.0-r7";
if(isset($_GET["ConsultaInfo"])){
    $ArrayContenidos = array();
    @mysql_connect($IPServidorMysql,$UsuarioMysql,$ContrasenaMysql) or printf("Error al conectar a MySQL : %s(%d) en %s:%d",mysql_error(),mysql_errno(),__FILE__,__LINE__) and exit;
    @mysql_select_db($DbDatos) or printf("Error al seleccionar la base de datos : %s(%d) en %s:%d",mysql_error(),mysql_errno(),__FILE__,__LINE__) and exit;
    $Hash = mysql_query("SELECT `Hash` FROM `Hashes` LIMIT 1;");
    $Hash = mysql_fetch_array($Hash);
    $Hash = $Hash["Hash"];
    include "funciones_ajenas.php";
    $EspacioMaximoBytes = $EspacioMaximo * 1024;
    $EspacioMaximo *= 1024;
    $EspacioMaximo *= 1024;
    $EspacioMaximo *= 1024;
    $EspacioMaximo += 1; // Garantizar que se usa Giga, en format_size
    $ConsumoBytes = foldersize($DirectorioImagenesThis);
    $EspacioDisponible = $EspacioMaximo - $ConsumoBytes;
    $i = 50;
    //echo format_size($EspacioMaximo) . "|" . format_size($ConsumoBytes) . "|" . format_size($EspacioDisponible);
    //echo "<br><br>";
    if($SoloServidorDelJuego){
        $IPServidorDelJuego = gethostbyname("sgtravellers.net");
        if($IPServidorDelJuego != $_SERVER["REMOTE_ADDR"]){
            $ArrayContenidos[] = "FATAL: El servidor del que viene la petición NO es el servidor del juego IP Servidor del juego = $IPServidorDelJuego , y la IP del servidor que manda la petición es " . $_SERVER["REMOTE_ADDR"];
        }
    }
    switch($_GET["ConsultaInfo"]){
        case "TODO":
            $ArrayContenidos[] = $Propietario;
            $ArrayContenidos[] = $EspacioMaximo;
            $ArrayContenidos[] = $Descripcion;
            $ArrayContenidos[] = $Formatos;
            $ArrayContenidos[] = $ConsumoBytes;
            $ArrayContenidos[] = $EspacioDisponible;
            //$ArrayContenidos[] = $URLUso;
            $ArrayContenidos[] = format_size(intval(disk_free_space(".")));
            if(function_exists("sys_getloadavg")){
                $ArrayContenidos[] = sys_getloadavg();
            }else{
                $ArrayContenidos[] = "NO_SOPORTADO_POR_EL_SO";
            }
            $ArrayContenidos[] = $Hash;
            $ArrayContenidos[] = $Version;
            break;
        case "PROPIETARIO":
            $ArrayContenidos[] = $Propietario;
            break;
        case "ESPMAX":
            $ArrayContenidos[] = $EspacioMaximo;
            break;
        case "DESCRIPCION":
            $ArrayContenidos[] = $Descripcion;
            break;
        case "FORMATOS":
            $ArrayContenidos[] = $Formatos;
            break;
        case "ESPUSADO":
            $ArrayContenidos[] = $ConsumoBytes;
            break;
        case "ESPDIS": // No tiene mucho sentido, puede ser computado
            $ArrayContenidos[] = $EspacioDisponible;
            break;
        /* Obsoleto
        case "URLUSO":
            $ArrayContenidos[] = $URLUso;
            break;
        */
        case "DISDIS": // Disco disponible
            $ArrayContenidos[] = format_size(intval(disk_free_space(".")));
            break;
        case "CARSIS":
            if(function_exists("sys_getloadavg")){
                $ArrayContenidos[] = sys_getloadavg();
            }else{
                $ArrayContenidos[] = "NO_SOPORTADO_POR_EL_SO";
            }
            break;
        case "HASH":
            $ArrayContenidos[] = $Hash;
            break;
        case "VALIDAR":
            if($_GET["cdSecreto"] == $cdSecreto and $_GET["cocdSecreto"] == $cocdSecreto ){
                $ArrayContenidos[] = "SI";
            }else{
                $ArrayContenidos[] = "NO, Valor en SERVIDOR_DE_FIRMAS(cdSecreto=$cdSecreto | cocdSecreto=$cocdSecreto), y en SERVIDOR_DEL_JUEGO(cdSecreto=" . $_GET["cdSecreto"] . "&cocdSecreto=" . $_GET["cocdSecreto"];
            }
            break;
        case "PDNGD":
            break;
        case "ONLINE":
            $ArrayContenidos[] = "Funcionando";
            break;
        case "VERSION":
            $ArrayContenidos[] = $Version;
        default:
            die("FATAL1(Orden no encontrada)");
            break;
        
    }
}else if(!$included){
    die("FATAL2");
}
if(count($ArrayContenidos) < 1 and !$included){
    die("FATAL3");
}

if(!$included) echo serialize($ArrayContenidos);