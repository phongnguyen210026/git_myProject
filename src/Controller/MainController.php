<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\User;
use App\Form\UserUpdateType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
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
    public function home(Request $req, AuthenticationUtils $authenticationUtils, CategoryRepository $repo): Response
    {
        $catMen = $repo->findBy(['category_parent'=>'men']);
        $catWomen = $repo->findBy(['category_parent'=>'women']);
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('main/index.html.twig', ['last_username'=>$lastUsername, 'catMen'=>$catMen, 'catWomen'=>$catWomen]);
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
            return $this->redirectToRoute('app_account');
        }
        return $this->render('main/account.html.twig', ['last_username'=>$lastUsername, 'userForm'=>$form->createView()]);
    }
    /**
     * @Route("/product/{cat_id}", name="app_product")
     */
    public function showProduct(AuthenticationUtils $authenticationUtils, $cat_id, ProductRepository $repo, CategoryRepository $repo2): Response
    {
        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        $findProduct = $repo->findBy(['cat'=>$cat_id]);
        $findCat = $repo2->findBy(['id'=>$cat_id]);
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('main/product.html.twig', ['last_username'=>$lastUsername, 'showProduct'=>$findProduct, 
        'catMen'=>$catMen, 'catWomen'=>$catWomen, 'findCat'=>$findCat
        ]);
    }

    /**
     * @Route("/detail/{id}", name="app_detail")
     */
    public function showDetail(AuthenticationUtils $authenticationUtils, $id,CategoryRepository $repo2): Response
    {
        return $this->render('$0.html.twig', []);
    }




    /**
     * @Route("/search", name="app_search")
     */
    public function searchAction(Request $req, ProductRepository $repo, CategoryRepository $repo2, AuthenticationUtils $authenticationUtils): Response
    {
        $param = $req->request->get('search-content');
        $searchResult = $repo->searchProduct($param);
        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        $username = $authenticationUtils->getLastUsername();
        return $this->render('main/search.html.twig', ['last_username'=>$username, 'result'=>$searchResult
        , 'catMen'=>$catMen, 'catWomen'=>$catWomen, 'content'=>$param
        ]);
    }
}
