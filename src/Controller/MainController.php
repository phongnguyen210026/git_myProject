<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use App\Form\UserUpdateType;
use App\Repository\BrandRepository;
use App\Repository\CartRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductDetailRepository;
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
    public function home(Request $req,BrandRepository $repo2, AuthenticationUtils $authenticationUtils, CategoryRepository $repo): Response
    {
        $catMen = $repo->findBy(['category_parent'=>'men']);
        $catWomen = $repo->findBy(['category_parent'=>'women']);
        $brand= $repo2->findAll();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('main/index.html.twig', ['last_username'=>$lastUsername,
        'catMen'=>$catMen, 'catWomen'=>$catWomen, 'brand'=>$brand
        
        ]);
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




    // /**
    //  * @Route("/product{id}", name="showProductWomen")
    //  */
    // public function showProductWomen($id,BrandRepository $repo3, AuthenticationUtils $authenticationUtils, ProductRepository $repo, CategoryRepository $repo2): Response
    // {
    //     $catWomen = $repo2->findBy(['category_parent'=>'women']);
    //     $catMen = $repo2->findBy(['category_parent'=>'men']);
    //     $product =$repo->findBy(['id'=> $id]);
    //     $brand=$repo3->findAll();
    //     $findBrand=$repo3->findBy(['brandid'=>$id]);
    //     $lastUsername = $authenticationUtils->getLastUsername();
    //     return $this->render('main/product.html.twig', [
    //         'last_username'=>$lastUsername, 'showProduct'=>$product, 
    //     'catMen'=>$catMen, 'catWomen'=>$catWomen, 'brand'=>$brand, 'findBrand'=>$findBrand
    //     ]);
    // }




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
    /**
     * @Route("/showDetail/{id}", name="show_detail")
     */
    public function showProductDetail($id, CategoryRepository $repo2, ProductRepository $repo, AuthenticationUtils $authenticationUtils, ProductDetailRepository $repo3): Response
    {
        $showDetail = $repo->findBy(['id'=>$id]);
        $catName = $repo2->getCatName($id);
        $getProductDetail = $repo3->findBy(['id'=>$id]);

        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        $username = $authenticationUtils->getLastUsername();
        return $this->render('main/pDetail.html.twig', ['showDetail'=>$showDetail, 'catMen'=>$catMen, 'catWomen'=>$catWomen,
        'last_username'=>$username, 'catName'=>$catName, 'getProductDetail'=>$getProductDetail
        ]);
    }
    /**
     * @Route("/addCart{id}", name="add_cart")
     */
    public function addCartAction(Request $req, $id, CartRepository $repo, CategoryRepository $repo2, ProductRepository $repo3, ProductDetailRepository $repo4, UserRepository $repo5): Response
    {
        $cart = new Cart();
        $user = $this->getUser();

        $getUserId = $repo5->findOneBy(['id'=>$user]);
        $size = $req->query->get('size');
        $quantity = $req->query->get('quantity');
        $proId = $repo3->find($id);
        settype($size, "string");

        $cart->setUser($getUserId);
        $cart->setSize($size);
        $cart->setProductCount($quantity);
        $cart->setProduct($proId);
        
        $repo->save($cart,true);
        return $this->json('ok');

        // return $this->render('$0.html.twig', []);
        // return new Response("$size, $quantity");
        // return $this->json($cart->getProduct());
    }





}
