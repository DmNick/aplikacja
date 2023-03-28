<?php

namespace App\Controller;

use App\Entity\Przyjecia;
use App\Form\PrzyjeciaFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrzyjeciaController extends AbstractController
{
    #[Route('/przyjecia', name: 'app_przyjecia')]
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {
        //return new Response(dump($this->getUser()->getIdMagazynu()->getId()));
        $CHECKidMagazynu = $this->getUser()->getIdMagazynu();
        if(!$CHECKidMagazynu){
            return $this->redirectToRoute('app_magazyn_show',['brakmagazynu'=>true]);
        }
        $isNull = $this->getUser()->getIdMagazynu()->getArtykuls()[0]??null;
        if(null===$isNull){
            return $this->redirectToRoute('app_artykul',['brak'=>true]);
        }
        $przyjecia = new Przyjecia;
        $form = $this -> createForm(PrzyjeciaFormType::class,$przyjecia,['idmagazyn'=>$this->getUser()->getIdMagazynu()->getId()]);
        $form->handleRequest($request);
        //$form->submit($request->request->get($form->getName()));
        
        if ($form->isSubmitted() && $form->isValid()) {

            //$uploads_directory = $this->getParameter('uploads_directory');
            //$files2 = $form['file']->getData();
            //dump($przyjecia);
            //die();
            
            $files = $_POST['przyjecia_form']['plik'];
            if($files[0]){
            if(count($files)>4){
                //dump("maks 4 pliki");
                //die();
                return $this->render('przyjecia/index.html.twig', [
                    'maxFiles' => true,
                    'przyjeciaForm' => $form->createView(),
                ]);
            }

            $newFiles = [];
                foreach ($files as $file){
                    $accept = ["pdf", "xml"];
                    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                   
                    if (in_array($ext, $accept)) {
                        $newFiles[] = $file;
                    }
                    else {
                        return $this->render('przyjecia/index.html.twig', [
                            'wrongExt' => true,
                            'file' => $file,
                            'przyjeciaForm' => $form->createView(),
                        ]);
                    }
                    //$file->upload();
                    
                    //$entityManager->persist($przyjecia);
                    //$entityManager->flush();
                    
                }
                // dump($ext);
                // die();

                $form->getData()->setPlik($newFiles);
           // $form->getData()->addPlik(["dodatkowy plik.html"]);
            }

            $idMagazynu = $this->getUser()->getIdMagazynu();
            $idUser = $this->getUser();
            $nowaIlosc = $form->getData()->getIlosc();
            //$artykul = 
            $staraIlosc =  $przyjecia->getArtykul()->getIlosc();
            $ilosc = $staraIlosc+$nowaIlosc;
            //return new Response(var_dump($nowaIlosc));

            $przyjecia->setWprowadzil($idUser);
            $przyjecia->setMagazyn($idMagazynu);
            $przyjecia->getArtykul()->setIlosc($ilosc);


            $file = $form->getData();
            //dump($form['plik']->getData());
            //dump($_POST['przyjecia_form']);
            //dump($file);
            //die();

            $entityManager->persist($przyjecia);
            $entityManager->flush();

            return $this->render('przyjecia/index.html.twig', [
                'done' => true,
                'przyjeto' => $nowaIlosc,
                'jednostka_miary' => $przyjecia->getArtykul()->getjednostkaMiary(),
                'stan' => $ilosc,
                'przyjeciaForm' => $form->createView(),
            ]);
            
        }

        return $this->render('przyjecia/index.html.twig', [
            'controller_name' => 'PrzyjeciaController',
            'przyjeciaForm' => $form->createView(),
        ]);
    }
}
