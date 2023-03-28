<?php

namespace App\Controller;

use App\Entity\Wydania;
use App\Form\WydaniaFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WydaniaController extends AbstractController
{
    #[Route('/wydania', name: 'app_wydania')]
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {
        $CHECKidMagazynu = $this->getUser()->getIdMagazynu();
        if(!$CHECKidMagazynu){
            return $this->redirectToRoute('app_magazyn_show',['brakmagazynu'=>true]);
        }
        $isNull = $this->getUser()->getIdMagazynu()->getArtykuls()[0]??null;
        if(null===$isNull){
            return $this->redirectToRoute('app_artykul',['brak'=>true]);
        }

        $wydania = new Wydania;
        $form = $this -> createForm(WydaniaFormType::class,$wydania,['idmagazyn'=>$this->getUser()->getIdMagazynu()->getId()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { 
            

            $idMagazynu = $this->getUser()->getIdMagazynu();
            $idUser = $this->getUser();

            $wydanaIlosc = $form->getData()->getIlosc();
            $staraIlosc =  $wydania->getArtykul()->getIlosc();
            $ilosc = $staraIlosc-$wydanaIlosc;
            if($ilosc<0){
                return $this->render('wydania/index.html.twig', [
                    'brak' => 'true',
                    'wydano' => $wydanaIlosc,
                    'jednostka_miary' => $wydania->getArtykul()->getjednostkaMiary(),
                    'stan' => $staraIlosc,
                    'wydaniaForm' => $form->createView(),
                ]);
            }

            $wydania->setWydal($idUser);
            $wydania->setMagazyn($idMagazynu);
            $wydania->getArtykul()->setIlosc($ilosc);
            // dump($wydania);
            // die();
            $entityManager->persist($wydania);
            $entityManager->flush();

            return $this->render('wydania/index.html.twig', [
                'done' => 'true',
                'wydano' => $wydanaIlosc,
                'jednostka_miary' => $wydania->getArtykul()->getjednostkaMiary(),
                'stan' => $ilosc,
                'wydaniaForm' => $form->createView(),
            ]);
        }

        return $this->render('wydania/index.html.twig', [
            'controller_name' => 'WydaniaController',
            'wydaniaForm' => $form->createView(),
        ]);
    }
}
