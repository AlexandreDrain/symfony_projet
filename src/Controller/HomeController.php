<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * Affiche une page HTML
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    public function getGlobals()
    {

        return $this->render('base.html.twig', [
            'session'   => $_SESSION
            ]) ;
    }
}
