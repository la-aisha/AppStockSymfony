<?php

namespace App\Controller;

 use App\Entity\User;
 use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class UserController extends AbstractController
{
    /**
     * @Route("/User/Liste", name="user_liste")
     */
    public function index(UserRepository $repository,ManagerRegistry $doctrine,Request $request): Response
    {
        $user = new User();
        $users=$repository->findAll();   

      /*   private $passwordHasher;

        public function __construct(UserPasswordHasherInterface $passwordHasher)
        {
            $this->passwordHasher = $passwordHasher;
        }
 */

        $form=$this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user=$form->getData();
            $em=$doctrine->getManager();
            $em->persist($user);
            $em->flush(); 
            $message = "a été ajouté avec succes"   ;
        }

        return $this->render('user/liste.html.twig',['users'=>$users, 'form'=>$form->createView()]);
    }
     /**
     * @Route("User/liste/edit/{id}", name="user_edit")

     */
    public function edit(User $user,userRepository $repository,Request $request, ManagerRegistry $doctrine): Response
    {

        $form =$this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $repository->add($user, true);

            return $this->redirectToRoute('user_liste', [], Response::HTTP_SEE_OTHER);


        } 
        
        return $this->render('user/edit.html.twig',['form'=>$form->createView(),'user'=>$user]);

 

    }
    
     /**
     * @Route("User/delete/{id}", name="user_delete")

     */
    Public function delete(User $user,ManagerRegistry $doctrine): Response{
       
        if($user){
            $manager = $doctrine->getManager();
            $manager->remove($user);
            $manager->flush();
        }
        else{
            $this->addFlash('error', 'user doesnt exist');
        }
        return $this->redirectToRoute('user_liste');
        return $this->render('user/liste.html.twig');


    
}


}
