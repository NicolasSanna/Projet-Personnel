<?php

namespace App\Framework;

class File
{
    public function __construct()
    {
        $this->createFolder = $this->createFolderImage();
    }
    
    public function uploadFileImage(array $file, string $imageExist = null)
    {
        if($file['error'] > 0)
        {
            FlashBag::addFlash("Une erreur est survenue lors du chargement du fichier.", 'error');
            return null;
        }

        if($file['size'] > 2000000)
        {
            FlashBag::addFlash("Le fichier est trop volumineux (plus de 2Mo)", 'error');
            return null;
        }

        $fileName = pathinfo($file['name']);
        $fileExtension = $fileName['extension'];

        $validExtension = ['img', 'png', 'jpg', 'jpeg', 'jpg'];

        if(!in_array($fileExtension, $validExtension))
        {
            FlashBag::addFlash("L'extension du fichier n'est pas valide.", 'error');
            return null;
        }
        else
        {
            
            $uniqueName = md5(uniqid(rand(), true));
            $fileName = $uniqueName . '.' . $fileExtension;

            if (!empty($imageExist))
            {
                unlink(IMAGE_DIR . '/' . $imageExist);
            }

            return $fileName;
        }
    }

    function createFolderImage()
    {
        if (!file_exists(PROJECT_DIR . '/public/img/imgArticle'))
        {
            mkdir(PROJECT_DIR . '/public/img/imgArticle', 0777, true);
        }
    }
}