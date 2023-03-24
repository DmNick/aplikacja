<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Magazyn;
use App\Form\MagazynType;
use App\Form\UserCollectionType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;
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
        $request->request->get('nazwa');
        $magazyn = new Magazyn();
        $form = $this->createForm(MagazynType::class, $magazyn);
        $form->handleRequest($request);
        
        // if ($request){
        // var_dump("test");die();
        // }

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            //return new Response(dump($form -> getData() -> getUsers()[2] -> getId()));
            $nazwa = $form -> getData() -> getNazwa(); //POPRAWNIE WYŚWIETLENIE NAZWY
            $idMagazynu = $form->getData()->getId();
            //return new Response(var_dump($idMagazynu)??null);
            //$users = $form -> getData() -> getUsers() -> getValues();
            $usersForm = $form -> getData();
            $usersForm2 = $usersForm->getUsers();
            $entityManager->persist($magazyn);
            $entityManager->flush();
            //return new Response(var_dump($request->getData())??null);
            $html = '';
            foreach ($usersForm2 as $item){
                //$key[] = $item->getId();
                $key[] = $item;
                //$magazyn -> addUser($item);
                //$key[] = $item;
                foreach($key as $value => $e){
                    //$html .= $value." => ".$e."<br>";
                    $form -> getData() -> addUser($e);
                    
                }
                
            }
            
            //return new Response(dump($html));
            //$magazyn -> addUser($entityManager->getReference(User::class, $form -> getData() -> getUsers()[2] -> getId()));
            $form -> getData() -> addUser($entityManager->getReference(User::class, 1));
            //$form -> getData() -> addUser($entityManager->getReference(User::class, 3));
            //$form -> getData() -> addUser($entityManager->getReference(User::class, 22));
            //return var_dump($magazyn);
            
            $entityManager->flush();
            // do anything else you need here, like send an email

            //return $this->redirectToRoute('app_magazyn_show');//, ['completed' => true, 'name' => $magazyn->getNazwa()]);
        }
        
        return $this->render('magazyn/add.html.twig', [
            'controller_name' => 'MagazynController',
            'magazynForm' => $form->createView(),
        ]);
        
    }

    #[Route('/magazyn', name: 'app_magazyn_show')]
    public function show(EntityManagerInterface $entityManager): Response
    {
        $magazynRepository = $entityManager -> getRepository(Magazyn::class);
        $magazyny = $magazynRepository->findAll();
        $html = '';
        $UserRepository = $entityManager -> getRepository(User::class);
        $userMagazyn = $UserRepository -> findOneBy(['id' => $this->getUser()->getId()]);
        if($userMagazyn -> getIdMagazynu()){
            $aktywnyMagazyn = $userMagazyn -> getIdMagazynu() -> getId();
            $aktywnyMagazynNazwa = $userMagazyn -> getIdMagazynu() -> getNazwa();
        }
        //return new Response( var_dump($this -> json([$aktywnyMagazyn -> getId()]))??null );
        //return new Response(var_dump($this->getUser()->getIdMagazynu())??null);
        return $this->render('magazyn/index.html.twig', ['result' => $magazyny, 'aktywny' => $aktywnyMagazyn??null, 'aktywnyNazwa' => $aktywnyMagazynNazwa??"BRAK" ]);
    }

    #[Route('/magazyn/change/{id}', name: 'app_magazyn_change')]
    public function change(EntityManagerInterface $entityManager, int $id): Response
    {
        $postUserRepository = $entityManager -> getRepository(User::class);
        $postOne = $postUserRepository -> findOneBy(['id' => $this->getUser()->getId()]);
        $postOne -> setIdMagazynu($entityManager->getReference(Magazyn::class, $id));
        $entityManager -> flush();
        //$user = $entityManager->getRepository(User::class)->findAll();
        
        //return new Response($this -> json(['user'=>$postTwo]));
        //return new Response(var_dump($postOne -> getIdMagazynu($entityManager->getReference(User::class, $postOne)))??null);
        return $this->redirectToRoute('app_magazyn_show');
    }
}
