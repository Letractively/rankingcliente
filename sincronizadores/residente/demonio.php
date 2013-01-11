<?php
// Este sería un demonio de ejecución constante

/* Se puede modificar para ejecución programa, bajo el comando at, si fuera necesario, o crontab, si no puede ser un proceso residente.
    También se puede usar un navegador programado para abrir esto como pag web
    Remover lineas de 9 a 11, o comentar, para habilitar el uso desde navegador
*/
include "/xampp/htdocs/rankingcliente/opciones.php";

if(isset($_SERVER["REMOTE_ADDR"])){
    die("Ejecución remota NO permitida, debe ejecutarse en una consola.");
}

while(true){
    //echo "Llamada al procesamiento";
    sleep(1);
    $Conexion = mysql_connect($IPServidorMysql,$UsuarioMysql,$ContrasenaMysql);
    mysql_select_db($DbDatos,$Conexion) or die("DB Inéxistente");
    if(!$Hash){
            $Hash = "0";
    }
    $HashLocal = mysql_query("SELECT `Hash` FROM `Hashes` LIMIT 1;");
    $HashLocal = mysql_fetch_array($HashLocal);
    $HashLocal = $HashLocal["Hash"];
    $HashDelServer = file_get_contents("http://sgtravellers.net/ranking/anunciar/index.php?TokenGen=true");
    if($HashDelServer == $HashLocal){
	sleep(1);
	echo "El Hash local coincidía con el del server ignorando petición\n";
	continue;
    }
    if(!$Comprobado){
	$Consulta = mysql_query("SELECT COUNT(`Hash`) FROM `Hashes`;");
	$Resultado = mysql_fetch_array($Consulta);
	$Resultado = $Resultado[0];
	if($Resultado < 1){
		printf("Notice : No existía ningun Hash, se ha introducido un valor valido en %s:%d$SaltoDelinea",__FILE__,__LINE__);
		mysql_query("INSERT INTO `Hashes` (`Hash`)VALUES('$HashDelServer');");
	}
	$Comprobado = true; 
    }else{
	mysql_query("UPDATE `Hashes` SET `Hash`='$HashDelServer';");// or printf("Error MySQL : %s(%d) en %s:%d $SaltoDelinea",mysql_error(),mysql_errno,__FILE__,__LINE__) and exit;
    }
    echo "Hash Actualizado $HashLocal <=> $HashDelServer\n";
        if($Hash != $HashDelServer){
        $Hash = $HashDelServer;
	$Inicio = microtime(1);
        $ContenidoRankingTotal = file_get_contents("http://sgtravellers.net/ranking/anunciar/index.php");
	$Fin = microtime(1) - $Inicio;
	$Fin = round($Fin,4);
	echo "Se ha tardado $Fin en descargar el nuevo ranking\n";
        if($ContenidoRankingTotal == "PDN"){
            echo "El servidor ha denegado la petición $SaltoDelinea";
            echo "Reintentando en 5 segundos $SaltoDelinea";
            sleep(5);
            continue;
        }
        $Posiciones = explode("|",$ContenidoRankingTotal);
        $i = 1;
        mysql_query("TRUNCATE `Ranking`");
        system("echo '1' > bloqueado.txt",$Valor);
        if($Valor > 0){
            die("chmod 664(si no estás en el grupo hazle un) 666, o chown NombreDelUsuario que ejecuta el demonio al directorio actual, Error($Valor)");
        }
        // Dear Kenpachi, con este exec(Impido que la gente vea una tabla vacia, comprobando, en el php de la página, que el valor sea 0);
        while(isset($Posiciones[$i])){
            $DatosTemporales = explode(";",$Posiciones[$i]);
            //print_r($Posiciones);
            mysql_query("INSERT INTO `Ranking` (`PosicionTotal`,`PuntosTotales`,`PuntosMejoras`,`PuntosTropas`,`PuntosNaves`,`PuntosDefensas`,`usercd`,`Avatar`,`Nick`)VALUES('" . $DatosTemporales[1] . "','" . $DatosTemporales[4] . "','" . $DatosTemporales[5] . "','" . $DatosTemporales[6] . "','" . $DatosTemporales[7] . "','" . $DatosTemporales[8] . "','" . $DatosTemporales[0] . "','" . $DatosTemporales[2] . "','" . $DatosTemporales[3] . "');");
            if(mysql_error()){
                die(mysql_error());
            }
            $i++;
        }
        exec("echo 0 > bloqueado.txt");
        mysql_close($Conexion);
		//die("DB Actualizada correctamente");
    }
}