<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Professionals;
use Doctrine\ORM\EntityManagerInterface;

class ProfessionalController extends AbstractController
{
    #[Route('/professional', name: 'professional')]
    public function index(): Response
    {
        return $this->render('professional/index.html.twig', [
            'controller_name' => 'ProfessionalController',
        ]);
    }
}
