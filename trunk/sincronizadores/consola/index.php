<?php
ini_set('max_execution_time', 90); 
$Inicio = microtime(1);
    // Este fichero al ser de llamada Web, cada vez que es llamado hace la tarea, sin importar el valor del hash
include "../../opciones.php";
    $Conexion = mysql_connect($IPServidorMysql,$UsuarioMysql,$ContrasenaMysql);
    mysql_select_db($DbDatos,$Conexion) or die("DB Inéxistente");
    $HashDelServer = file_get_contents("http://sgtravellers.net/ranking/anunciar/index.php?TokenGen=true&cdSecreto=$cdSecreto&cocdSecreto=$cocdSecreto");
    $ContenidoRankingTotal = file_get_contents("http://sgtravellers.net/ranking/anunciar/index.php?cdSecreto=$cdSecreto&cocdSecreto=$cocdSecreto");
        if($ContenidoRankingTotal == "PDN"){
            echo "El servidor ha denegado la petición $SaltoDelinea";
            die("el servidor ha denegado la petición");
        }
        //echo $HashDelServer . "\n" . "Contenido Sin tratar : $ContenidoRankingTotal";
        $Posiciones = explode("|",$ContenidoRankingTotal);
        $i = 1;
        mysql_query("TRUNCATE `Ranking`") or die("Imposible vaciar la tabla");
        
        system("echo 1 > ../../bloqueado.txt",$Valor);
        if($Valor > 0){
            die("chmod 664(si no estás en el grupo hazle un) 666, o chown NombreDelUsuario que ejecuta el demonio al directorio actual, Error($Valor)");
        }
        if(count($Posiciones) < 2){
            die("Error de comunicación?");
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
        //exec("echo 0 > ../../bloqueado.txt");
        
        
        mysql_close($Conexion);
    $Fin = microtime(1) - $Inicio;
    echo "El servidor ha tardado $Fin , en renegerar el ranking, con el hash $HashDelServer";

