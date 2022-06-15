<?php

namespace App\Controller;


use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SortieformType;


class SortieController extends AbstractController
{
     /**
     * @Route("/Sortie/liste", name="sortie_liste")
     */
    public function index(ManagerRegistry $doctrine,SortieRepository $repository,Request $request): Response
    {
    //fetch sortie    
        $sortie= new sortie();
        $sorties=$repository->findAll();   

        //add
        $form =$this->createForm(sortieformType::class,$sortie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $sortie=$form->getData();
            $em=$doctrine->getManager();
            $em->persist($sortie);
            $em->flush(); 
        }
    
 
        return $this->render('sortie/liste.html.twig',['sorties'=>$sorties, 'form'=>$form->createView()]);

    }
   
    /**
     * @Route("sortie/liste/edit/{id}", name="sortie_edit")

    */
    public function edit(sortie $sortie,sortieRepository $repository,Request $request, ManagerRegistry $doctrine): Response
    {

        $form =$this->createForm(sortieformType::class,$sortie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $repository->add($sortie, true);

            return $this->redirectToRoute('sortie_liste', [], Response::HTTP_SEE_OTHER);


        } 
        
        return $this->render('sortie/edit.html.twig',['form'=>$form->createView(),'sortie'=>$sortie]);

 

    }
    
     /**
     * @Route("Sortie/delete/{id}", name="sortie_delete")

     */
    Public function delete(sortie $sortie,ManagerRegistry $doctrine): Response{
       
        if($sortie){
            $manager = $doctrine->getManager();
            $manager->remove($sortie);
            $manager->flush();
        }
        else{
            $this->addFlash('error', 'sortie doesnt exist');
        }
        return $this->redirectToRoute('sortie_liste');
        return $this->render('sortie/liste.html.twig');
    }

}
