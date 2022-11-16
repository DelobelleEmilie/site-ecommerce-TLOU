<?php
function initTwig($path)
{
    $loader = new \Twig\Loader\FilesystemLoader($path);
    return new \Twig\Environment($loader, []);
}
