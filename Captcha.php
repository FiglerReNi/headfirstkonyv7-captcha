<?php


namespace Captcha;
include 'kapcs.php';

class Captcha
{
    function check()
    {   $ellenorzo = '';
        for ($i = 0; $i < captcha; $i++) {
            $ellenorzo .= chr(rand(97, 122));
        }
        return $ellenorzo;
    }
}