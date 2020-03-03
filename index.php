<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

require __DIR__ . '/vendor/autoload.php';

use InstagramScraper\Instagram;

define('ITEMS_NUMBER', 15);

$images = [];
$tag = !empty($_REQUEST['tag']) ? $_REQUEST['tag'] : '';

if (!empty($tag)) {
    $instagram = new Instagram();
    $medias = $instagram->getMediasByTag($tag, ITEMS_NUMBER);

    foreach ($medias as $media) {
        $square_images = $media->getSquareImages();
        $images[] = !empty($square_images[1]) ? $square_images[1] : '';
    }
}

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);

echo $twig->render('index.html', [
    'images' => $images,
    'tag' => $tag,
]);
