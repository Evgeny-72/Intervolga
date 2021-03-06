<?php
    include_once('data.php');
    // убрал пробел в конце строки, иначе может не сработать регулярное выражение
    $a = trim($a);
    $b = '';

    if (strlen($a) > 180) {
        $a = mb_substr($a, 0, 180) . '...';
    }
    // есть вероятность получить некорректный текст ссылки, в случае, если в регулярное выражение попадет "потому что" и т.п.
    preg_match('/[\S]+\s[\S]+$/', $a, $matches);
    $link = "<a href='news.php'>" . $matches[0] . "</a>";
    $b = preg_replace('/[\S]+\s[\S]+$/', $link, $a);
