<?php
// carga la imagen
$Dimensiones = getimagesize($Avatar);
$Bits = $Dimensiones["bits"];
$Bits = 24 / $Bits;
if(!$Bits > 0){
    $Bits = 1;
}
$Ancho = $Dimensiones[0];
$Alto = $Dimensiones[1];
$PosicionAncho = $Dimensiones[0] / 3; // Diferencial de área
$SeparadorAncho = $PosicionAncho / 3; // Diferencia que se puede sacar, de forma más avanzada
$PosicionAlto = $Dimensiones[1] / 4;
$im = imagecreatefrompng($Avatar) or imagecreatefromjpeg($Avatar);
//imagerectangle()
imagesavealpha($im,true);
imagealphablending($im,true);

// colores base
$blanco = imagecolorallocate($im, 250 / $Bits, 250 / $Bits, 250 / $Bits);
$amarillo = imagecolorallocate($im, 255 / $Bits, 255 / $Bits, 0);
$gris   = imagecolorallocate($im, 128, 128, 128);
$ColorLetraImagen  = imagecolorallocate($im, $filas["Rojo"], $filas["Verde"], $filas["Azul"]);
$negro = imagecolorallocatealpha($im,0,0,255,110);
$transparente = imagecolorallocatealpha($im,255,255,255,110);
$azulTransparentado = imagecolorallocatealpha($im,0,0,10,125);
//imagefilledrectangle($im, 0, 0, 449, 249, $blanco);
imagefilledellipse($im,$Dimensiones[0] - 37,$Dimensiones[1] - 40,40,40,$azulTransparentado);
imagefilledrectangle($im,30,$Dimensiones[1] - 12,$Dimensiones[0] - 30,$Dimensiones[1],$azulTransparentado);
// las variables de texto 
$texto = 'NICK: ' . $Nick;
$textoB = 'ALIANZA: ' . $filas["Alianza"] ;
$texto2 = 'POSICION: ' . $filas["PosicionTotal"] ;
$texto3 = 'PUNTOS : ' . $filas["PuntosTotales"];
// tipo de fuente
$fuente = "../STARGATE.ttf";
$FuenteArial = "../arial.ttf";
// sombreado gris
/*
$i = $PosicionAncho + $SeparadorAncho - 8;
while($i < $Dimensiones[0]){
    $a = $Dimensiones[1] - 30;
    while($a < $Dimensiones[1]){
        imagesetpixel($im,$i, $a,$negro);
        $a++;
    }
    $i++;
}

imageline($im,$PosicionAncho + $SeparadorAncho -8,$Dimensiones[1] - 30,$Dimensiones[0],$Dimensiones[1] - 30,$amarillo); // isquierda derecha
imageline($im,$PosicionAncho + $SeparadorAncho -8,$Dimensiones[1] - 30,$PosicionAncho + $SeparadorAncho -8,$Dimensiones[1],$amarillo); // isquierda derecha
imageline($im,$PosicionAncho + $SeparadorAncho -8,$Dimensiones[1] - 2,$Dimensiones[0],$Dimensiones[1] - 2,$amarillo); // isquierda derecha
imageline($im,$Dimensiones[0] - 2,$Dimensiones[1] - 30,$Dimensiones[0] - 2,$Dimensiones[1] - 2,$amarillo); // isquierda derecha
*/
imagettftext($im, 14, 0, 200, 32, $gris, $fuente, $texto);
imagettftext($im, 14, 0, $SeparadorAncho, 62, $gris, $fuente, $textoB);
imagettftext($im, 14, 0, $SeparadorAncho, 102, $gris, $fuente, $texto2);
imagettftext($im, 14, 0, $SeparadorAncho, 142, $gris, $fuente, $texto3);
imagettftext($im, 14, 0, $SeparadorAncho, 142, $gris, $fuente, $texto3);
// impresion de texto en imagen
imagettftext($im, 14, 0, $SeparadorAncho -2, 31, $ColorLetraImagen, $fuente, $texto);
imagettftext($im, 14, 0, $SeparadorAncho -2, 61, $ColorLetraImagen, $fuente, $textoB);
imagettftext($im, 14, 0, $SeparadorAncho -2, 101, $ColorLetraImagen, $fuente, $texto2);
imagettftext($im, 14, 0, $SeparadorAncho -2, 141, $ColorLetraImagen, $fuente, $texto3);
imagettftext($im, 14, 0, $Dimensiones[0] - 55,$Dimensiones[1] - 34, $blanco, $fuente, "SGT");
imagettftext($im,12,0,$PosicionAncho,$Dimensiones[1],$blanco,$FuenteArial,"Visita nuestro foro: www.foro-sgalactic.tk");

//imageline($im,10,20,20,40,$ColorLetraImagen);

// tipo de imagen y control de caché

header("Cache-Control: max-age=300, must-revalidate");
header("Content-type: image/png");

// genera la imagen y libera la imagen

imagepng($im) or imagejpeg($im);
imagedestroy($im);

?> 