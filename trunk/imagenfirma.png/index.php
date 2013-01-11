<?php
//ini_set("display_errors",1);
//error_reporting(E_ALL);
include "../opciones.php";
$Conexion = mysql_connect($IPServidorMysql,$UsuarioMysql,$ContrasenaMysql);
mysql_select_db($DbDatos);
$Bloqueado = @file_get_contents("../bloqueado.txt");
$Bloqueado = intval($Bloqueado);
if(!$_GET["cd"]){
    die("Error");
}
$cd = intval($_GET["cd"]);
if($Bloqueado > 0){
    while($Bloqueado > 0){
        usleep(10000);
        $Bloqueado = @file_get_contents("../bloqueado.txt");
        $Bloqueado = intval($Bloqueado);
        echo "Lawl";
    }
}
    $Consulta = mysql_query("SELECT * FROM `Ranking` LEFT JOIN `FirmasPersonalizadas` ON `Ranking`.`usercd`=`FirmasPersonalizadas`.`usercdFirma` WHERE `Ranking`.`usercd`='$cd'  LIMIT 1");
    if(mysql_error()){
        die(mysql_error());
    }
    if(mysql_num_rows($Consulta) == 0){
        die("Usuario no existente");
    }
    $filas = mysql_fetch_array($Consulta);
        // Generar tablas stuff
        if($filas["Firma"]){
            $Avatar = $filas["Firma"];
            $Internal = $DirectorioImagenes;
            $Internal .= substr($filas["Firma"],strrpos($filas["Firma"],"/") + 1);
        }else{
            die("FATAL: El usuario existe, pero no teiene ninguna firma definida");
            $Avatar = $filas["Avatar"];
            $Internal = $Avatar;
        }
        $Nick = strtoupper($filas["Nick"]);
        $Avatar = $Internal;
        include "../otro.php";
        //echo "Valor $Avatar";
    
