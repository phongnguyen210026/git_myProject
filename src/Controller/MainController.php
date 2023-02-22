<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserUpdateType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MainController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function home(Request $req, AuthenticationUtils $authenticationUtils): Response
    {
        $user = new User();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('main/index.html.twig', ['last_username'=>$lastUsername]);
    }
    /**
     * @Route("/account", name="app_account")
     */
    public function account(Request $req, AuthenticationUtils $authenticationUtils, UserRepository $repo): Response
    {
        $user = $this->getUser();
        // $data[]=[
            
        //     'name'=>$user->getFirstName(),
        //     'email'=>$user->getEmail()
        // ];
        // return $this->json($data[0]);  

        $form = $this->createForm(UserUpdateType::class, $user);
        $form->handleRequest($req);
        $lastUsername = $authenticationUtils->getLastUsername();
        if($form->isSubmitted() && $form->isValid()){
            $repo->save($user,true);
            $this->addFlash(
               'success',
               'Your information was updated'
            );
            // return $this->render('main/account.html.twig', ['last_username'=>$lastUsername, 'userForm'=>$form->createView()]);
        }
        return $this->render('main/account.html.twig', ['last_username'=>$lastUsername, 'userForm'=>$form->createView()]);
    }
    /**
     * @Route("/product", name="app_product")
     */
    public function showProduct(AuthenticationUtils $authenticationUtils): Response
    {
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('main/product.html.twig', ['last_username'=>$lastUsername]);
    }
}
