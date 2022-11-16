<?php
function homeController($twig)
{
  echo $twig->render('home.html.twig', []);
}

?>
