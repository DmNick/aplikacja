<?php

namespace App\Controller;

use App\Entity\Artykul;
use App\Form\ArtykulFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArtykulController extends AbstractController
{
    #[Route('/artykul/add', name: 'app_artykul_add')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {

        $artykul = new Artykul();
        $form = $this->createForm(ArtykulFormType::class, $artykul);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $idMagazynu = $this->getUser()->getIdMagazynu();
            $artykul -> setMagazyn($idMagazynu);
            $entityManager->persist($artykul);
            $entityManager->flush();
        }

        return $this->render('artykul/add.html.twig', [
            'controller_name' => 'ArtykulController',
            'artykulForm' => $form->createView(),
            'name' => $artykul -> getNazwa(),
        ]);
    }
}
