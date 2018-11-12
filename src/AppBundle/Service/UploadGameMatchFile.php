<?php

namespace AppBundle\Service;


use AppBundle\Entity\GameMatch;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadGameMatchFile
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param GameMatch $gameMatch
     * @param string $uploadsDir
     * @return bool
     */
    public function uploadFile($gameMatch, $uploadsDir)
    {
        /** @var UploadedFile|$uploadedFile */
        $uploadedFile = $gameMatch->getFile();
        $date = new \DateTime();
        $timestamp = $date->format('Ydm-His');

        if ($uploadedFile instanceof UploadedFile) {
            $fileName = $uploadedFile->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
//            $extension = substr(strrchr($fileName, '.'), 1);

            $uploadedFile->move($uploadsDir, $timestamp . '_' . $fileName);
            $fileName = $timestamp . '_' . $fileName;

            $gameMatch->setFile(DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $fileName);

            return true;
        }

        return false;
    }
}