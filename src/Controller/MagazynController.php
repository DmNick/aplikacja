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

        if ($form->isSubmitted() && $form->isValid()) {
            $nazwa = $form -> getData() -> getNazwa(); //POPRAWNIE WYŚWIETLENIE NAZWY
            //$nazwa2 = $form["users"] -> getData()[0] -> getEmail(); //POPRAWNIE WYŚWIETLENIE PĘTLI Z EMAILEM
            //return new Response(dump($nazwa2));
            $usersForm = $form -> getData();
            $usersForm2 = $usersForm->getUsers();
            $entityManager->persist($magazyn);
            $entityManager->flush();
            $magazynRepository = $entityManager -> getRepository(Magazyn::class);
            $magazynFind = $magazynRepository->findOneBy(['nazwa' => $nazwa]);

            foreach ($usersForm2 as $item){
                $UserRepository = $entityManager -> getRepository(User::class);
                $userMagazyn = $UserRepository -> findOneBy(['id' => $item->getId()]);
                $userMagazyn -> setIdMagazynu($entityManager->getReference(Magazyn::class, $magazynFind->getId()));
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_magazyn_show', ['completed' => true, 'name' => $magazyn->getNazwa()]);
        }
        
        return $this->render('magazyn/add.html.twig', [
            'controller_name' => 'MagazynController',
            'magazynForm' => $form->createView(),
        ]);
        
    }

    #[Route('/magazyn', name: 'app_magazyn_show')]
    public function show(EntityManagerInterface $entityManager): Response
    {
        
        $html = '';
        $UserRepository = $entityManager -> getRepository(User::class);
        //$userMagazyn = $UserRepository -> findOneBy(['id' => $this->getUser()->getId()]);
        $userMagazyn = $this->getUser();
        $magazynRepository = $entityManager -> getRepository(Magazyn::class);

        // dump(get_class($this->getUser()));
        // die();

        // $magazyny = $magazynRepository->findBy(['magUsers'=>$this->getUser()]);
        

        // $userMagazyn -> addListaMagazynow($entityManager->getReference(Magazyn::class, 2));
        // $entityManager -> flush();
        $magazyny = $magazynRepository->findAll();
        
        //return new Response(dump($userMagazyn->getListaMagazynow()[0]->getNazwa()));
        if($userMagazyn -> getIdMagazynu()){
            $aktywnyMagazyn = $userMagazyn -> getIdMagazynu() -> getId();
            $aktywnyMagazynNazwa = $userMagazyn -> getIdMagazynu() -> getNazwa();
        }

        return $this->render('magazyn/index.html.twig', ['result' => $magazyny, 'aktywny' => $aktywnyMagazyn??null, 'aktywnyNazwa' => $aktywnyMagazynNazwa??"BRAK" ]);
    }

    #[Route('/magazyn/change/{id}', name: 'app_magazyn_change')]
    public function change(EntityManagerInterface $entityManager, int $id): Response
    {
        $postUserRepository = $entityManager -> getRepository(User::class);
        $postOne = $postUserRepository -> findOneBy(['id' => $this->getUser()->getId()]);
        $postOne -> setIdMagazynu($entityManager->getReference(Magazyn::class, $id));
        $entityManager -> flush();

        return $this->redirectToRoute('app_magazyn_show');
    }
}
