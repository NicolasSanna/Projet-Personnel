<?php

namespace App\Framework;

class File
{

    const VALID_EXTENSIONS = ['img', 'png', 'jpg', 'jpeg'];
    const VALID_MIME_TYPES = ['image/png', 'image/jpeg'];

    public function __construct()
    {
        $this->createFolderImage();
    }

    private function checkSize(array $file)
    {
        if($file['size'] > 2000000)
        {
            FlashBag::addFlash("Le fichier est trop volumineux (plus de 2Mo)", 'error');
        }
    }

    private function checkMime(array $file)
    {
        $fileMimeInfo = mime_content_type($file['tmp_name']);

        if(!in_array($fileMimeInfo, self::VALID_MIME_TYPES))
        {
            FlashBag::addFlash("L'extension du fichier n'est pas valide.", 'error');
        }
    }

    private function checkExtension (array $file)
    {
            
        $fileName = pathinfo($file['name']);
        $fileExtension = strtolower($fileName['extension']);

        if(!in_array($fileExtension, self::VALID_EXTENSIONS))
        {
            FlashBag::addFlash("L'extension du fichier n'est pas valide.", 'error');
        }
    }

    public function generateRandomFileName(array $file)
    {
        $fileName = pathinfo($file['name']);
        $fileExtension = strtolower($fileName['extension']);

        $uniqueName = md5(uniqid(rand(), true));
        $fileName = $fileName['filename'] . '-' . $uniqueName . '.' . $fileExtension;

        return $fileName;
    }
    
    public function uploadFileImage(array $file, string $imageExist = null)
    {

        $this->checkSize($file);
        $this->checkMime($file);
        $this->checkExtension($file);

        if(!FlashBag::hasMessages('error'))
        {
            $fileName = $this->generateRandomFileName($file);
            
            move_uploaded_file($file['tmp_name'], IMAGE_DIR .  '/' . $fileName);

            if (!empty($imageExist))
            {
                unlink(IMAGE_DIR . '/' . $imageExist);
            }

            return $fileName;
        }
    }

    private function createFolderImage()
    {
        if (!file_exists(PROJECT_DIR . '/public/img/imgArticle'))
        {
            mkdir(PROJECT_DIR . '/public/img/imgArticle', 0777, true);
        }
    }
}