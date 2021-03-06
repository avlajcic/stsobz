<?php

namespace AppBundle\Controller;

use AppBundle\Entity\GameMatch;
use AppBundle\Form\GameMatchType;
use AppBundle\Service\UploadFileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package AppBundle\Controller
 * @Route("/admin/game-matches", name="gameMatch_")
 */
class GameMatchController extends Controller
{
    /**
     * @Route("/", name="list")
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(EntityManagerInterface $em)
    {
        $gameMatches = $em->getRepository('AppBundle:GameMatch')->findAll();

        return $this->render('admin/gameMatch/list.html.twig', [
            'gameMatches' => $gameMatches,
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
        $gameMatch = new GameMatch();
        $form = $this->createForm(GameMatchType::class, $gameMatch, array(
            'file' => ''
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uploadsDir = $this->get('kernel')->getRootDir() . '/../web/uploads';
            $uploadFileService->uploadGameMatchFile($gameMatch, $uploadsDir);

            $em->persist($gameMatch);
            $em->flush();
            return $this->redirect(
                $this->generateUrl('gameMatch_list')
            );
        }

        return $this->render('admin/gameMatch/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit")
     * @param GameMatch $gameMatch
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param UploadFileService $uploadFileService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(GameMatch $gameMatch, EntityManagerInterface $em, Request $request, UploadFileService $uploadFileService)
    {
        $currentFile = $gameMatch->getFile();
        $filePath = $this->get('kernel')->getRootDir() . '/../web' . $gameMatch->getFile();
        if (is_file($filePath)) {
            $gameMatch->setFile(new File($filePath));
        } else {
            $gameMatch->setFile('');
        }

        $form = $this->createForm(GameMatchType::class, $gameMatch, array(
            'file' => $currentFile
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uploadsDir = $this->get('kernel')->getRootDir() . '/../web/uploads';

            if ($uploadFileService->uploadGameMatchFile($gameMatch, $uploadsDir)) {
                if (is_file($this->get('kernel')->getRootDir() . '/../web' . $currentFile)) {
                    unlink($this->get('kernel')->getRootDir() . '/../web'. $currentFile );
                }
            }

            $em->persist($gameMatch);
            $em->flush();

            return $this->redirect(
                $this->generateUrl('gameMatch_list')
            );
        }

        $gameMatch->setFile($currentFile);
        return $this->render('admin/gameMatch/create.html.twig', array(
            'form' => $form->createView(),
            'gameMatch' => $gameMatch
        ));
    }

    /**
     * @Route("/{id}/delete", name="delete")
     * @param GameMatch $gameMatch
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(GameMatch $gameMatch, EntityManagerInterface $em)
    {

        $em->remove($gameMatch);
        $em->flush();

        return $this->redirect(
            $this->generateUrl('gameMatch_list')
        );

    }
}
