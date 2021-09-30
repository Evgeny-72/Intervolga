<?php
    $arr = [1, 1, 2, 3, 4 - 51, 12, 12, 12, 12, -51];
    $count = count($arr);
    $s = 0;
    for ($i = 0; $i < $count; $i++) {
        if ($arr[$i] === $arr[$i + 1]) {
            $s++;
            $i++;
        }
    }
    echo $s;