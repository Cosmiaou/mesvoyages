<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of VoyagesController
 *
 * @author louis
 */
class VoyagesController extends AbstractController {
    
    #[Route('/voyages', name: 'voyages')]
    public function index() : Response {
        return $this->render("pages/voyages.html.twig");
    }
    
}
