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
        if($file['size'] > 2000000)
        {
            FlashBag::addFlash("Le fichier est trop volumineux (plus de 2Mo)", 'error');
            return null;
        }

        $fileMimeInfo = mime_content_type($file['tmp_name']);

        $validMimeExtension = ['image/png', 'image/jpeg'];

        if(!in_array($fileMimeInfo, $validMimeExtension))
        {
            FlashBag::addFlash("L'extension du fichier n'est pas valide.", 'error');
            return null;
        }

        $fileName = pathinfo($file['name']);
        $fileExtension = strtolower($fileName['extension']);

        $validExtension = ['img', 'png', 'jpg', 'jpeg'];

        if(!in_array($fileExtension, $validExtension))
        {
            FlashBag::addFlash("L'extension du fichier n'est pas valide.", 'error');
            return null;
        }
        else
        {
            
            $uniqueName = md5(uniqid(rand(), true));
            $fileName = $fileName['filename'] . '-' . $uniqueName . '.' . $fileExtension;

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