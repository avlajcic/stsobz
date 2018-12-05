<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package AppBundle\Controller
 * @Route("/admin", name="admin_")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, EntityManagerInterface $em)
    {
        // replace this example code with whatever you need
        return $this->render('admin/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
