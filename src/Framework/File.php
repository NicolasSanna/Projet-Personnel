<?php

namespace App\Framework;

class File
{
    private array $file;
    private ?string $imageExist = null;

    const VALID_EXTENSIONS = ['img', 'png', 'jpg', 'jpeg'];
    const VALID_MIME_TYPES = ['image/png', 'image/jpeg'];

    public function __construct(array $file, string $imageExist = null)
    {
        $this->createFolderImage();
        $this->file = $file;
        $this->imageExist = $imageExist;

        $this->checkSize();
        $this->checkMime();
        $this->checkExtension();
    }

    private function checkSize()
    {
        if($this->file['size'] > 2000000)
        {
            FlashBag::addFlash("Le fichier est trop volumineux (plus de 2Mo)", 'error');
        }
    }

    private function checkMime()
    {
        $fileMimeInfo = mime_content_type($this->file['tmp_name']);

        if(!in_array($fileMimeInfo, self::VALID_MIME_TYPES))
        {
            FlashBag::addFlash("L'extension du fichier n'est pas valide.", 'error');
        }
    }

    private function checkExtension ()
    {
            
        $fileName = pathinfo($this->file['name']);
        $fileExtension = strtolower($fileName['extension']);

        if(!in_array($fileExtension, self::VALID_EXTENSIONS))
        {
            FlashBag::addFlash("L'extension du fichier n'est pas valide.", 'error');
        }
    }

    private function generateRandomFileName()
    {
        $fileName = pathinfo($this->file['name']);
        $fileExtension = strtolower($fileName['extension']);

        $uniqueName = md5(uniqid(rand(), true));
        $fileName = $fileName['filename'] . '-' . $uniqueName . '.' . $fileExtension;

        return $fileName;
    }
    
    public function uploadFileImage()
    {

        if(!FlashBag::hasMessages('error'))
        {
            $fileName = $this->generateRandomFileName();
            
            move_uploaded_file($this->file['tmp_name'], IMAGE_DIR .  '/' . $fileName);

            if (!empty($this->imageExist))
            {
                unlink(IMAGE_DIR . '/' . $this->imageExist);
            }

            return $fileName;
        }

        return null;
    }

    private function createFolderImage()
    {
        if (!file_exists(PROJECT_DIR . '/public/img/imgArticle'))
        {
            mkdir(PROJECT_DIR . '/public/img/imgArticle', 0777, true);
        }
    }
}