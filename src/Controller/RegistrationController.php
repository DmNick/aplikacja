<?php

namespace App\Controller;

use App\Entity\Magazyn;
use App\Entity\User;
use App\Form\AddUserFormType;
use App\Form\RegistrationFormType;
use App\Form\UserEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
         }
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            //return new Response( var_dump($form)??null);
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            if($form->get('addAdmin')->getData() == '1'){
                $user->setRoles(["ROLE_ADMIN"]);
            }
            //$user->setIdMagazynu($entityManager->getReference(Magazyn::class, 1));
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            
        ]);
    }

    #[Route('/user/add', name: 'app_adduser')]
    public function adduser(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {

        $user = new User();
        $form = $this->createForm(AddUserFormType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            //return new Response( var_dump($form->getData()->getIdMagazynu()->getId())??null);
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            if($form->get('addAdmin')->getData() == '1'){
                $user->setRoles(["ROLE_ADMIN"]);
            }
            $user -> setIdMagazynu($form->getData()->getIdMagazynu());
            //$user->setIdMagazynu($entityManager->getReference(Magazyn::class, 1));
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            //return $this->redirectToRoute('app_login');
            return $this->render('registration/add.html.twig', [
                'registrationForm' => $form->createView(),
                'name' => $user->getEmail(),
            ]);
        }

        return $this->render('registration/add.html.twig', [
            'registrationForm' => $form->createView(),
            
        ]);
    }


    #[Route('/user', name: 'app_user')]
    public function user(EntityManagerInterface $entityManager): Response
    {
        $userRepository = $entityManager -> getRepository(User::class);
        $users = $userRepository->findAll();

        return $this->render('registration/user.html.twig', ['result' => $users]);
    }


    #[Route('/user/edit/{id}', name: 'app_edituser')]
    public function edituser(Request $request, EntityManagerInterface $entityManager, User $user, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        //$userRepository = $entityManager -> getRepository(User::class);
        //$user = $userRepository->findOneBy(['id'=> $id]);

        $form = $this->createForm(UserEditFormType::class,$user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('plainPassword')->getData()){
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
            }

            if($form->get('addAdmin')->getData() == '1'){
                $user->setRoles(["ROLE_ADMIN"]);
            }
            else {
                $user->setRoles([]);
            }

            if($form->getData()->getIdMagazynu()){
                $user -> setIdMagazynu($form->getData()->getIdMagazynu());
            }

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user', ['name' => $user->getEmail()]);

        }

        return $this->render('registration/edit.html.twig', [
            'result' => $user,
            'role' => $user->getRoles()[0],
            'UserEditFormForm' => $form->createView(),]);
    }
}
