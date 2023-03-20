<?php

namespace App\Controller;

use App\Entity\Magazyn;
use App\Form\MagazynType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MagazynController extends AbstractController
{
    #[Route('/magazyn', name: 'app_magazyn')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $magazyn = new Magazyn();
        $form = $this->createForm(MagazynType::class, $magazyn);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            //$magazyn->setDomyslny('0');

            $entityManager->persist($magazyn);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_magazyn',['completed' => 'success', 'name' => $magazyn -> getNazwa()]);
        }

        return $this->render('magazyn/index.html.twig', [
            'controller_name' => 'MagazynController',
            'magazynForm' => $form->createView(),
        ]);
    }
}
