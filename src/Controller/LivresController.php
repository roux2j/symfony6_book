<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Form\LivreType;
use App\Repository\LivresRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LivresController extends AbstractController
{
    #[Route('/', name: 'app_livres')]
    public function index(LivresRepository $livresRepository): Response
    {
        $livre = $livresRepository->findAll();

        return $this->render('livres/index.html.twig', compact('livre'));
    }

    #[Route('/livre/create', name: 'livre.create', methods: ['GET','POST'])]
    public function create(Request $request, LivresRepository $livresRepository): Response
    {
        $livre = new Livres();

        $form = $this->createForm(LivreType::class, $livre);

        $form->handleRequest($request);

        if ($form->issubmitted() && $form->isValid()) 
        {
            $livresRepository->add($livre,true);
            $this->addFlash("success", "le livre a été ajouté avec succes");
            return $this->redirectToRoute('app_livres');
        }

        return $this->renderForm('livres/create.html.twig', [
            "livres_create_form"=>$form
        ]);
    }

    #[Route('/livre/edit/{id<\d+>}', name: 'livre.edit', methods: ['GET','POST'])]
    public function edit(Livres $livre, Request $request, LivresRepository $livresRepository) : Response
    {
        $form = $this->createForm(LivreType::class, $livre);

        $form->handleRequest($request);

        if ($form->issubmitted() && $form->isValid()) 
        {
            $livresRepository->add($livre,true);
            $this->addFlash("success", "le livre a été modifié avec succes");
            return $this->redirectToRoute('app_livres');
        }

        // return $this->render('livres/edit.html.twig',[
        //     "livre_edit_form"=>$form->createView()

            
        // ]);

        return $this->renderForm('livres/edit.html.twig', [
            "livres_edit_form"=>$form
        ]);
    }

    #[Route('/livre/delete/{id<\d+>}', name: 'livre.delete', methods: ['POST'])]
    public function delete(Livres $livre, Request $request, LivresRepository $livresRepository) : Response
    {
        if ($this->isCsrfTokenValid('delete' . $livre -> getId(), $request->request->get('_token'))) 
        {
            $livresRepository->remove($livre, true);
            $this->addFlash('success', $livre -> getNom() . "a été retiré de la liste");
        }

        return $this->redirectToRoute('app_livres');
    }

    

}
