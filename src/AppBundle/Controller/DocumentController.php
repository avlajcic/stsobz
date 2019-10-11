<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Document;
use AppBundle\Form\DocumentType;
use AppBundle\Service\UploadFileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package AppBundle\Controller
 * @Route("/admin/documents", name="document_")
 */
class DocumentController extends Controller
{
    /**
     * @Route("/", name="list")
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(EntityManagerInterface $em)
    {
        $documentes = $em->getRepository('AppBundle:Document')->findAll();

        return $this->render('admin/document/list.html.twig', [
            'documentes' => $documentes,
        ]);
    }

    /**
     * @Route("/create", name="create")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param UploadFileService $uploadFileService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(EntityManagerInterface $em, Request $request, UploadFileService $uploadFileService)
    {
        $document = new Document();
        $form = $this->createForm(DocumentType::class, $document, array(
            'file' => ''
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uploadsDir = $this->get('kernel')->getRootDir() . '/../web/uploads';
            $uploadFileService->uploadDocumentFile($document, $uploadsDir);

            $em->persist($document);
            $em->flush();
            return $this->redirect(
                $this->generateUrl('document_list')
            );
        }

        return $this->render('admin/document/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit")
     * @param Document $document
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Document $document, EntityManagerInterface $em, Request $request, UploadFileService $uploadFileService)
    {
        $currentFile = $document->getPath();
        $filePath = $this->get('kernel')->getRootDir() . '/../web' . $document->getPath();
        if (is_file($filePath)) {
            $document->setPath(new File($filePath));
        } else {
            $document->setPath('');
        }

        $form = $this->createForm(DocumentType::class, $document, array(
            'file' => $currentFile
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uploadsDir = $this->get('kernel')->getRootDir() . '/../web/uploads';

            if ($uploadFileService->uploadDocumentFile($document, $uploadsDir)) {
                if (is_file($this->get('kernel')->getRootDir() . '/../web' . $currentFile)) {
                    unlink($this->get('kernel')->getRootDir() . '/../web'. $currentFile );
                }
            }

            $em->persist($document);
            $em->flush();

            return $this->redirect(
                $this->generateUrl('document_list')
            );
        }

        $document->setPath($currentFile);
        return $this->render('admin/document/create.html.twig', array(
            'form' => $form->createView(),
            'document' => $document
        ));
    }

    /**
     * @Route("/{id}/delete", name="delete")
     * @param Document $document
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Document $document, EntityManagerInterface $em)
    {

        $em->remove($document);
        $em->flush();

        return $this->redirect(
            $this->generateUrl('document_list')
        );

    }
}
