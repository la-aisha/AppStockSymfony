<?php

namespace App\Controller;
use App\Form\RolesFormType;

 use App\Entity\Roles;
 use App\Repository\RolesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleController extends AbstractController
{
    /**
     * @Route("/Role/liste", name="role_liste")
     */
    public function index(ManagerRegistry $doctrine, RolesRepository $repository,Request $request): Response
    {
        $role = new Roles();
        $roles=$repository->findAll();   

        //add
        $form =$this->createForm(RolesFormType::class,$role);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $role=$form->getData();
            $em=$doctrine->getManager();
            $em->persist($role);
            $em->flush(); 
            $message = "a été ajouté avec succes"   ;
        }
         
      
        return $this->render('role/liste.html.twig',['roles'=>$roles, 'form'=>$form->createView()]);
    }
    
     /**
     * @Route("/Role/liste/edit/{id}", name="role_edit")

     */
    public function edit(Roles $role,RolesRepository $repository,Request $request, ManagerRegistry $doctrine): Response
    {

        $form =$this->createForm(RolesFormType::class,$role);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $repository->add($role, true);

            return $this->redirectToRoute('role_liste', [], Response::HTTP_SEE_OTHER);


        } 
        
        return $this->render('role/edit.html.twig',['form'=>$form->createView(),'role'=>$role]);

 

    }
       /**
     * @Route("Role/delete/{id}", name="role_delete")

     */
    Public function delete(roles $role,ManagerRegistry $doctrine): Response{
       
        if($role){
            $manager = $doctrine->getManager();
            $manager->remove($role);
            $manager->flush();
        }
        else{
            $this->addFlash('error', 'category doesnt exist');
        }
        return $this->redirectToRoute('role_liste');
        return $this->render('role/liste.html.twig');


    
    }
}
