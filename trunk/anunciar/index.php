<?php
// Notice Unix only
include "../opciones.php";
 $Usado = exec("du $DirectorioImagenes",$NO,$ERRORLEVEL);
if($ERRORLEVEL > 0){
    die("NDU"); // El servidor no soporta du o ejecución de binarios del sistema
}
$TamanoUsado = intval(substr($Usado,0,strpos($Usado,"\t")));
$CapacidadBytes = $EspacioMaximo * 1024;
$CapacidadBytes = $CapacidadBytes *1024;
$CapacidadBytes = $CapacidadBytes * 1024;

echo $CapacidadBytes;
