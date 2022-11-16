<?php
function errorController($twig)
{
  echo $twig->render('error.html.twig', []);
}

?>