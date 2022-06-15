<?php
/* 
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Component\HttpFoundation\Request;
 */
namespace App\Controller;
use App\Entity\Produit;
use App\Form\ProductFormType;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;




class ProductController extends AbstractController

{
   
    /**
     * @Route("/Produit/liste", name="product_liste")
     * 
     */
    public function index(ManagerRegistry $doctrine,ProduitRepository $repository,Request $request): Response
    {
        $prod = new Produit();
        $prods=$repository->findAll();   

        //add
        $form =$this->createForm(ProductFormType::class,$prod);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $prod=$form->getData();
            $em=$doctrine->getManager();
            $em->persist($prod);
            $em->flush(); 
            $message = "a été ajouté avec succes"   ;
        }
         
      
        return $this->render('product/liste.html.twig',['prods'=>$prods, 'form'=>$form->createView()]);

        
    }
     
    
     /**
     * @Route("/Produit/liste/edit/{id}", name="product_edit")

     */
    public function edit(Produit $product,ProduitRepository $repository,Request $request, ManagerRegistry $doctrine): Response
    {

        $form =$this->createForm(ProductFormType::class,$product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $repository->add($product, true);

            return $this->redirectToRoute('product_liste', [], Response::HTTP_SEE_OTHER);


        } 
        
        return $this->render('product/edit.html.twig',['form'=>$form->createView(),'product'=>$product]);

 

    }
      /**
     * @Route("Produit/delete/{id}", name="product_delete")

     */
    Public function delete(Produit $product,ManagerRegistry $doctrine): Response{
       
        if($product){
            $manager = $doctrine->getManager();
            $manager->remove($product);
            $manager->flush();
        }
        else{
            $this->addFlash('error', 'category doesnt exist');
        }
        return $this->redirectToRoute('product_liste');
        return $this->render('product/liste.html.twig');


    
    }
 
    

    
}
