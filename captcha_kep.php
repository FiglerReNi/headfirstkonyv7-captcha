<?php
session_start();
include "kapcs.php";
include 'Captcha.php';
$captcha = new \Captcha\Captcha();
//terület létrehozása
$img = imagecreatetruecolor(captcha_width, captcha_height);
//szine létrehozása
$bg_color = imagecolorallocate($img, 255, 255, 255);
$text_color = imagecolorallocate($img, 0, 0, 0);
$graphic_color = imagecolorallocate($img, 64, 64, 64);
//háttér kitöltése
imagefilledrectangle($img, 0, 0, captcha_width, captcha_height, $bg_color);
//véletlenszerű vonalak
for ($i = 0; $i < 5; $i++) {
    imageline($img, 0, rand() % captcha_height, captcha_width, rand() % captcha_height, $graphic_color);
}
//véletlenszerű pont
for ($i = 0; $i < 5; $i++) {
    imagesetpixel($img, rand() % captcha_width, rand() % captcha_height, $graphic_color);
}
//jelszó rajzolása
$text = $captcha -> check();
$_SESSION['text']= sha1($text);
imagestring($img, 5, 15,  5, $text, $text_color);
//imagettftext($img, 18, 0,5, captcha_height-5, $text_color, 'Courier New Bold.ttf', $text);
header("Content-Type: image/png");
imagepng($img);
imagedestroy($img);