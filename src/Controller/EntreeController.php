<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Entree;
use App\Form\EntreeType;
use App\Repository\EntreeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EntreeformType;



class EntreeController extends AbstractController
{
    /**
     * @Route("/Entree/liste", name="entree_liste")
     */
    public function index(ManagerRegistry $doctrine,EntreeRepository $repository,Request $request): Response
    {
    //fetch Entree    
        $entree= new Entree();
        $entrees=$repository->findAll();   

        //add
        $form =$this->createForm(EntreeformType::class,$entree);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entree=$form->getData();
            $em=$doctrine->getManager();
            $em->persist($entree);
            $em->flush(); 
        }
    
 
        return $this->render('entree/liste.html.twig',['entrees'=>$entrees, 'form'=>$form->createView()]);

    }
   
    /**
     * @Route("Entree/liste/edit/{id}", name="entree_edit")

    */
    public function edit(Entree $entree,EntreeRepository $repository,Request $request, ManagerRegistry $doctrine): Response
    {

        $form =$this->createForm(EntreeformType::class,$entree);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $repository->add($entree, true);

            return $this->redirectToRoute('entree_liste', [], Response::HTTP_SEE_OTHER);


        } 
        
        return $this->render('entree/edit.html.twig',['form'=>$form->createView(),'entree'=>$entree]);

 

    }
    
     /**
     * @Route("entree/delete/{id}", name="entree_delete")

     */
    Public function delete(entree $entree,ManagerRegistry $doctrine): Response{
       
        if($entree){
            $manager = $doctrine->getManager();
            $manager->remove($entree);
            $manager->flush();
        }
        else{
            $this->addFlash('error', 'entree doesnt exist');
        }
        return $this->redirectToRoute('entree_liste');
        return $this->render('entree/liste.html.twig');
    }


}

