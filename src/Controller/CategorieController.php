<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryEditType;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;




class CategorieController extends AbstractController
{
    /**
     * @Route("Categorie/liste", name="categorie_liste" )
     */
    public function index(CategoryRepository $repository,Request $request, ManagerRegistry $doctrine): Response
    {
        //fetch category    
        $cat = new Category();
        $cats=$repository->findAll();   

        //add
        $form =$this->createForm(CategoryFormType::class,$cat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cat=$form->getData();
            $em=$doctrine->getManager();
            $em->persist($cat);
            $em->flush(); 
            $message = "a été ajouté avec succes"   ;
        }
         
        
        return $this->render('categorie/liste.html.twig',['cats'=>$cats, 'form'=>$form->createView()]);

        
         
    }   
    
    
    
     /**
     * @Route("Categorie/liste/edit/{id}", name="category_edit")

     */
    public function edit(Category $category,CategoryRepository $repository,Request $request, ManagerRegistry $doctrine): Response
    {

        $form =$this->createForm(CategoryFormType::class,$category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $repository->add($category, true);

            return $this->redirectToRoute('categorie_liste', [], Response::HTTP_SEE_OTHER);


        } 
        
        return $this->render('categorie/edit.html.twig',['form'=>$form->createView(),'category'=>$category]);

 

    }
 
     /**
     * @Route("Categorie/delete/{id}", name="category_delete")

     */
    Public function delete(Category $category,ManagerRegistry $doctrine): Response{
       
        if($category){
            $manager = $doctrine->getManager();
            $manager->remove($category);
            $manager->flush();
        }
        else{
            $this->addFlash('error', 'category doesnt exist');
        }
        return $this->redirectToRoute('categorie_liste');
        return $this->render('categorie/liste.html.twig');


    
}

    


}
    
     

