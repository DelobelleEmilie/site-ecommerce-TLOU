<?php

use App\Controller\AbstractController;
use App\Core\Router\Router;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Core\Security\AuthenticationManager;
class upload extends AbstractController
{
    function upload($file): string|null
    {
        $uploads = [
            'extensions' => ['png', 'jpg'],
            'path' => 'uploads/',
            'state' => false
        ];

        $file_path = null;

        $file_name = null;

        if (isset($file)) {
            if (!empty($file['name'])) {
                $file_upload = explode(".", $file['name']);
                // Vérification de l'extension
                # permet de vérifier la présence d’une valeur dans un tableau.
                if (in_array($file_upload[count($file_upload) - 1],
                    $uploads['extensions'])) {
                    // Nettoyage des accents
                    $file_name = strtr($file_upload[0],
                        'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                    // Nettoyage des caractères spéciaux
                    $file_name = preg_replace('/([^.a-z0-9]+)/i', '_', $file_name);
                    # permet de couper la chaine de caractères à chaque fois qu’un point sera présent.
                    $file_name = $file_name . '.' .
                        $file_upload[count($file_upload) - 1];
                    $file_path = $uploads['path'] . $file_name;
                    #’instruction de la condition s’attarde à vérifier qu’un fichier ayant le même nom n’existe pas.
                    #Si aucun fichier du même nom n’est trouvé, l’envoi de fichier est autorisé à continuer
                    #Si toutes les conditionssont vérifiées,le déplacement du fichier vers ledossier «uploads» situé dans le dossier «public» est autorisé. Le déplacement s’effectue

                    if (!file_exists($file_path)) {
                        // Déplacement du fichier
# l’autorisation est effectuée en passant l’état de la variable «uploads» à vrai
                        move_uploaded_file($file['tmp_name'], $file_path);
                        $uploads['state'] = true;
                    } else {
                        $msg = "Une image avec ce nom existe déjà !";
                    }
                } else {
                    $msg = "L'extension du fichier n'est pas acceptée!";
                }
            } else {
                $msg = "Veuillez choisir un fichier !";
            }


            if (isset($_POST['submit'])) {
                $file = $_FILES['file'];

                $fileName = $_FILES['file']['name'];
                $fileTmpName = $_FILES['file']['tmp_name'];
                $fileSize = $_FILES['file']['size'];
                $fileError = $_FILES['file']['error'];
                $fileType = $_FILES['file']['type'];

                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));

                $allowed = array('jpg', 'jpeg', 'png', 'pdf');

                if (in_array($fileActualExt, $allowed)) {
                    if ($fileError === 0) {
                        if ($fileSize < 1000000) {
                            $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                            $fileDestination = 'uploads/' . $fileNameNew;
                            move_uploaded_file($fileTmpName, $fileDestination);
                            header("Location: index.php?uploadsuccess");
                        } else {
                            echo "Your file is too big!";
                        }
                    } else {
                        echo "There was an error uploading your file!";
                    }
                } else {
                    echo "You cannot upload files of this type!";
                }
            }


        }

        return $file_path;
    }
}
