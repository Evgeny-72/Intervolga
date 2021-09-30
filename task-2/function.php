<?php
    // исходник тут http://labdes.ru/resize-images-in-php

    // ищу png
    function getPng(): string
    {
        $dir = 'img/';
        $path = '';
        $files = scandir($dir);

        foreach ($files as $elem) {
            if (preg_match('/.+\.png$/', $elem)) {
                $path = 'img/' . $elem;
            }
        }
        return $path;
    }


    function resizeImg($path, $save, $width, $height)
    {
        $info = getimagesize(getPng()); //получаем размеры картинки и ее тип
        $size = array($info[0], $info[1]); //закидываем размеры в массив

        //создаём новое изображение из файла
        if ($info['mime'] === 'image/png') {
            $src = imagecreatefrompng($path);
        } else {
            return false;
        }

        $mWidth = $width; // костыль для закрашивания черного фона в случае непропорционального масштабирования
        if ($width > $height) {
            $mWidth = $height;
        }
        $thumb = imagecreatetruecolor($mWidth, $height); //возвращает идентификатор изображения, представляющий черное изображение заданного размера
        imageAlphaBlending($thumb, false);
        imageSaveAlpha($thumb, true);


        $src_aspect = $size[0] / $size[1]; //отношение ширины к высоте исходника
        $thumb_aspect = $width / $height; //отношение ширины к высоте аватарки

        if ($src_aspect < $thumb_aspect) {        //узкий вариант (фиксированная ширина)      $scale = $width / $size[0];         $new_size = array($width, $width / $src_aspect);        $src_pos = array(0, ($size[1] * $scale - $height) / $scale / 2); //Ищем расстояние по высоте от края картинки до начала картины после обрезки   } else if ($src_aspect > $thumb_aspect) {
            //широкий вариант (фиксированная высота)
            $scale = $height / $size[1];
            $new_size = array($height * $src_aspect, $height);
            $src_pos = array(0, 0);
        } else {
            //другое
            $new_size = array($width, $height);
            $src_pos = array(500, 0);
        }

        $new_size[0] = max($new_size[0], 1);
        $new_size[1] = max($new_size[1], 1);

        //Копирование и изменение размера изображения с ресемплированием
        imagecopyresampled($thumb, $src, 0, 0, $src_pos[0], $src_pos[1], $new_size[0], $new_size[1], $size[0], $size[1]);


        if ($save === false) {
            return imagepng($thumb); //Выводит JPEG/PNG/GIF изображение
        } else {
            return imagepng($thumb, $save);//Сохраняет JPEG/PNG/GIF изображение
        }

    }

    resizeImg('img/pngegg.png', 'resizeimg/1.png', 200, 100);
