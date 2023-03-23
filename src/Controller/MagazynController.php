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

        $magazyn = new Magazyn();
        $form = $this->createForm(MagazynType::class, $magazyn);
        $form->handleRequest($request);
        
        // if ($request){
        // var_dump("test");die();
        // }

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password

            
                $nazwa = $form -> getData() -> getNazwa(); //POPRAWNIE WYŚWIETLENIE NAZWY
                $idMagazynu = $form->getData()->getId();
                //return new Response(var_dump($idMagazynu)??null);
                //$users = $form -> getData() -> getUsers() -> getValues();
                $usersForm = $form -> getData();
                $usersForm2 = $usersForm->getUsers();
                
                
                $users = $_POST['magazyn']['users']??'';
                //$key = [];
                
                //return new Response(var_dump($key)??null);
                //$request->request->get('users');
                //$usersId = $users -> getId();

                //$html = $form -> getNazwa();
                // $html = 'pusto';
                if (isset($users) && !empty($users)){
                //  $html = '';
                    // foreach($users as $key => $item){
                    //     //$html .= $key." => ".$item."<br>";
                    //     $form -> getData() -> addUser($entityManager->getReference(User::class, $item));
                    // }

                    // $UserRepository = $entityManager -> getRepository(User::class);
                    // foreach ($UserRepository->findById($users) as $obj => $item) {
                    //     $obj->setIdMagazynu(array_search($entityManager->getReference(Magazyn::class, $item)->getId(), $users));
                    // }
                    
                }
                //$form -> getData() -> addUser($entityManager->getReference(User::class, '1'));
                // $html = '';
                // $person = $entityManager->getRepository(User::class)->findAll($users);
                // foreach($person as $key => $item){
                //     $html .= $key.' => '.$item."<br>";
                // }
                // $html='';
                //$data = json_decode($form->getData(), true);
                //$form2 = $users->createForm(UserCollectionType::class, ['users' => $users]);
                //$form2->handleRequest($request);
                //return new Response( print_r($html));
                //return new Response( print_r($html));
                //return new Response( print_r($users(7) -> getKeys()));
            
            

            //return new Response( var_dump($formOne)??null);
            //$magazyn->setDomyslny('0');
            //$form -> getData() -> addUser($entityManager->getReference(User::class, 1));
            //$key = [];
            foreach ($usersForm2 as $item){
                $key = $item->getId();
                //$form -> getData() -> addUser($entityManager->getReference(User::class, $key));
                // $person = $entityManager->getRepository(User::class)->findOneBy(['id' => $key]);
                // $form -> getData() -> addUser($person);
                // $entityManager->flush();
                $persons = $entityManager->getRepository(User::class)->findBy(['id'=>$key]);
                $form -> getData() -> addUser($entityManager->getReference(User::class, 1));

            }
            $form -> getData() -> addUser($entityManager->getReference(User::class, 1));
            $entityManager->persist($magazyn);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_magazyn_show');//, ['completed' => true, 'name' => $magazyn->getNazwa()]);
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
