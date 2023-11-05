<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\VeloType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\AjoutVélo;
use App\Entity\Velo;
use Doctrine\ORM\EntityManagerInterface;


class BaseController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('base/index.html.twig', [
        ]);
    }
    #[Route('/AjoutVélo', name: 'app_AjoutVélo')]
    public function AjoutVélo(Request $request, EntityManagerInterface $em): Response
    {
        $AjoutVélo = new Velo();
        $form = $this->createForm(VeloType::class, $AjoutVélo);

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $em->persist($AjoutVélo);
                $em->flush();
                $this->addFlash('notice','Message envoyé');
                return $this->redirectToRoute('app_AjoutVélo');         
            }
        }
           
        return $this->render('base/AjoutVélo.html.twig', [
            'form' => $form->createView()
        ]);
    }
}