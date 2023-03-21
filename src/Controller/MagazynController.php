<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Magazyn;
use App\Form\MagazynType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MagazynController extends AbstractController
{
    #[Route('/magazyn/add', name: 'app_magazyn')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {

        $magazyn = new Magazyn();
        $form = $this->createForm(MagazynType::class, $magazyn);
        $form->handleRequest($request);

        // if ($request){
        // var_dump("test");die();
        // }

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            //$magazyn->setDomyslny('0');


            $entityManager->persist($magazyn);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_magazyn_show', ['completed' => true, 'name' => $magazyn->getNazwa()]);
        }
        if (isset($_GET['completed'])) {
            return $this->render('magazyn/index.html.twig', ['get' => $_GET, 'magazynForm' => $form->createView()]);
        } else {
            return $this->render('magazyn/add.html.twig', [
                'controller_name' => 'MagazynController',
                'magazynForm' => $form->createView(),
            ]);
        }
    }

    #[Route('/magazyn', name: 'app_magazyn_show')]
    public function show(EntityManagerInterface $entityManager): Response
    {
        $postRepository = $entityManager -> getRepository(Magazyn::class);
        $magazyny = $postRepository->findAll();
        $html = '';
        //$html = var_dump($magazyny);
        // foreach($magazyny as $result){
        //     $html .= $result->getNazwa() . '<br>';
        // }

        // return new Response($html);

        return $this->render('magazyn/index.html.twig', ['result' => $magazyny]);
    }

    #[Route('/magazyn/change/{id}', name: 'app_magazyn_change')]
    public function change(EntityManagerInterface $entityManager, int $id, UserInterface $user = null): Response
    {
        $getUser = $this -> getUser();
        $userId = $user->getId()??null;
        // $postUserRepository =  $entityManager -> getRepository(User::class);
        // $postOne = $postUserRepository -> findOneBy(['id'=>$this -> getUser() -> getId()]);
        // $postOne -> setMagazyn(['nazwa' => 'GŁÓWNY']);
        // $entityManager->persist($postTwo);
        //$entityManager -> flush();
        //$user = $entityManager->getRepository(User::class)->findAll();
        
        //$html = $id;
        return new Response( var_dump($getUser)?? null);
    }
}
