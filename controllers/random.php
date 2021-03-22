<?php

declare(strict_types=1);

namespace Controllers;

final class Random
{
    function generateRandomPassword(): string
    {
        $chars = "ABCDEFGHIJKMNOPQRSTUVXYZabcdefghijkmnopqrstuvwxyz0123456789";
        srand(intval((float) microtime() * 1000000));
        $i = 0;
        $pass = '';

        while ($i <= 7) {
            $num = rand() % strlen($chars);
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }

        return $pass;
    }
}
