<?php
$HashDelServer = file_get_contents("http://foro-sgalactic.tk/ranking/anunciar/index.php?TokenGen=true");
$Respuesta = file_get_contents("http://foro-sgalactic.tk/beta/loginRemoto.php?Nick=$Nick&Contrasena=$Contrasena");
$Ranking = file_get_contents("http://foro-sgalactic.tk/ranking/anunciar/index.php");
echo $Respuesta . " y " . $HashDelServer;

echo "<br><h1>Ranking parseado</h1>";

echo $Ranking;