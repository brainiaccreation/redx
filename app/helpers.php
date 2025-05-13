<?php
if (!function_exists('usernameAvatar')) {
    function usernameAvatar($name)
    {
        $nameSplitted = explode(' ', $name);

        $firstLetter = substr($nameSplitted[0], 0, 1);
        if (count($nameSplitted) == 1) {
            $secondLetter = substr($nameSplitted[0], 1, 1);
        } else {
            $secondLetter = substr($nameSplitted[(count($nameSplitted) - 1)], 0, 1);
        }

        return utf8_encode(strtoupper($firstLetter) . strtoupper($secondLetter));
    }
}