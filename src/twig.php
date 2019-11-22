<?php

require __DIR__ . '/../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader);
$twig->addFunction(new \Twig\TwigFunction('asset', 'asset'));
$twig->addFilter(new \Twig\TwigFilter('var_dump', 'dumpData'));

function asset($path = "")
{
    return sprintf("%s%s", ASSET_PATH, $path);
}

function dumpData($data)
{
    var_dump($data);
}
