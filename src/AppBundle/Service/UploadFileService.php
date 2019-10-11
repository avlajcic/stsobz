<?php

namespace AppBundle\Service;


use AppBundle\Entity\Document;
use AppBundle\Entity\GameMatch;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFileService
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
    public function uploadGameMatchFile($gameMatch, $uploadsDir)
    {
        /** @var UploadedFile|$uploadedFile */
        $uploadedFile = $gameMatch->getFile();
        $date = new \DateTime();
        $timestamp = $date->format('Ydm-His');

        if ($uploadedFile instanceof UploadedFile) {
            $fileName = $uploadedFile->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);

            $uploadedFile->move($uploadsDir, $timestamp . '_' . $fileName);
            $fileName = $timestamp . '_' . $fileName;

            $gameMatch->setFile(DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $fileName);

            return true;
        }

        return false;
    }

    /**
     * @param Document $document
     * @param string $uploadsDir
     * @return bool
     */
    public function uploadDocumentFile($document, $uploadsDir)
    {
        /** @var UploadedFile|$uploadedFile */
        $uploadedFile = $document->getPath();
        $date = new \DateTime();
        $timestamp = $date->format('Ydm-His');

        if ($uploadedFile instanceof UploadedFile) {
            $fileName = $uploadedFile->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);

            $uploadedFile->move($uploadsDir, $timestamp . '_' . $fileName);
            $fileName = $timestamp . '_' . $fileName;

            $document->setPath(DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $fileName);

            return true;
        }

        return false;
    }
}