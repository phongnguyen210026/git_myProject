<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Category;
use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Entity\Product;
use App\Entity\User;
use App\Form\UserUpdateType;
use App\Repository\BrandRepository;
use App\Repository\CartRepository;
use App\Repository\CategoryRepository;
use App\Repository\OrderDetailRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductDetailRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\Validator\Constraints\DateTime as ConstraintsDateTime;

class MainController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function home(Request $req, AuthenticationUtils $authenticationUtils, CategoryRepository $repo, BrandRepository $repo2): Response
    {
        $catMen = $repo->findBy(['category_parent'=>'men']);
        $catWomen = $repo->findBy(['category_parent'=>'women']);
        $brand = $repo2->findAll();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('main/index.html.twig', ['last_username'=>$lastUsername, 'catMen'=>$catMen, 'catWomen'=>$catWomen, 'brand'=>$brand]);
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
    public function showProduct(AuthenticationUtils $authenticationUtils, $cat_id, ProductRepository $repo, CategoryRepository $repo2, BrandRepository $repo3): Response
    {
        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        $findProduct = $repo->findBy(['cat'=>$cat_id]);
        $findCat = $repo2->findBy(['id'=>$cat_id]);
        $brand = $repo3->findAll();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('main/product.html.twig', ['last_username'=>$lastUsername, 'showProduct'=>$findProduct, 
        'catMen'=>$catMen, 'catWomen'=>$catWomen, 'findCat'=>$findCat, 'brand'=>$brand
        ]);
    }
    /**
     * @Route("/productBrand/{brand_id}", name="app_product_brand")
     */
    public function showProductByBrand(AuthenticationUtils $authenticationUtils, $brand_id, ProductRepository $repo, CategoryRepository $repo2, BrandRepository $repo3): Response
    {
        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        $findProduct = $repo->findBy(['id'=>$brand_id]);
        $brand = $repo3->findAll();
        $findBrand = $repo3->findBy(['id'=>$brand_id]);
        $username = $authenticationUtils->getLastUsername();
        return $this->render('main/productBrand.html.twig', ['last_username'=>$username, 'showProductBrand'=>$findProduct, 
        'catMen'=>$catMen, 'catWomen'=>$catWomen, 'findBrand'=>$findBrand, 'brand'=>$brand]);
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
    /**
     * @Route("/showDetail/{id}", name="show_detail")
     */
    public function showProductDetail($id, CategoryRepository $repo2, ProductRepository $repo, AuthenticationUtils $authenticationUtils, ProductDetailRepository $repo3, BrandRepository $repo4): Response
    {
        $showDetail = $repo->findBy(['id'=>$id]);
        $catName = $repo2->getCatName($id);
        $getProductDetail = $repo3->findBy(['id'=>$id]);

        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        $username = $authenticationUtils->getLastUsername();
        $brand = $repo4->findAll();
        return $this->render('main/pDetail.html.twig', ['showDetail'=>$showDetail, 'catMen'=>$catMen, 'catWomen'=>$catWomen,
        'last_username'=>$username, 'catName'=>$catName, 'getProductDetail'=>$getProductDetail, 'brand'=>$brand, 'message'=>0
        ]);
    }
    /**
     * @Route("/addCart{id}", name="add_cart")
     */
    public function addCartAction(Request $req, $id, CartRepository $repo, CategoryRepository $repo2, ProductRepository $repo3, ProductDetailRepository $repo4, UserRepository $repo5, AuthenticationUtils $authenticationUtils, BrandRepository $repo6): Response
    {
        $cart = new Cart();
        $user = $this->getUser();
        $data[]=[
          'id'=>$user->getId()
        ];

        $getUserId = $repo5->findOneBy(['id'=>$user]);
        $size = $req->query->get('size');
        $quantity = $req->query->get('quantity');
        $proId = $repo3->find($id);
        settype($size, "string");
        
        $username = $authenticationUtils->getLastUsername();
        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        $brand = $repo6->findAll();
        $showDetail = $repo3->findBy(['id'=>$id]);
        $catName = $repo2->getCatName($id);
        $getProductDetail = $repo4->findBy(['id'=>$id]);
        if($size == "Select Size"){
            return $this->render('main/pDetail.html.twig', ['message'=>'Please choose your size', 'catMen'=>$catMen, 'catWomen'=>$catWomen
            , 'brand'=>$brand, 'last_username'=>$username, 'showDetail'=>$showDetail, 'catName'=>$catName, 'getProductDetail'=>$getProductDetail
            ]);
        }

        $checkCart = $repo->checkProductInCart($data[0]['id'], (int)$id);
        if($checkCart == []){
            $cart->setUser($getUserId);
            $cart->setSize($size);
            $cart->setProductCount($quantity);
            $cart->setProduct($proId);

            $repo->save($cart,true);
            return $this->redirectToRoute('app_home');
        }else{
            $qty_update_value = $checkCart[0]['product_count'] + $quantity;
            // return $this->json($qty_update_value);
            return $this->redirectToRoute('cart_update', ['cart_id'=>$checkCart[0]['id'], 'qty'=>$qty_update_value]);
        }
        // return $this->render('$0.html.twig', []);
        // return new Response("$size, $quantity");
        // return $this->json($cart->getProduct());
    }
    /**
     * @Route("/editCart/{qty}/{cart_id}", name="cart_update")
     * 
     * @Entity("cart", expr="repository.find(cart_id)")   
     */
    public function editCart(Cart $cart, CartRepository $repo, $qty): Response
    {
        $cart->setProductCount($qty);
        $repo->save($cart,true);
        return $this->redirectToRoute('app_home');
    }
    /**
     * @Route("/cart", name="app_cart")
     */
    public function showCart(Request $req, AuthenticationUtils $authenticationUtils, CategoryRepository $repo, BrandRepository $repo2, CartRepository $repo3): Response
    {
        $cart = $repo3->findProductInCart();
        $cart2 = $repo3->findPrice();
        $cart3 = $repo3->countProductInCart();
        $deliveryMoney = $req->query->get('delivery-money');
        $subtotal = 0;
        for($i=0;$i<count($cart2);$i++){
            $subtotal += $cart2[$i]['total'];
        }
        $total = $subtotal + $deliveryMoney;
        $username = $authenticationUtils->getLastUsername();
        $catWomen = $repo->findBy(['category_parent'=>'women']);
        $catMen = $repo->findBy(['category_parent'=>'men']);
        $brand = $repo2->findAll();
        return $this->render('main/cart.html.twig', ['last_username'=>$username, 'catMen'=>$catMen, 'catWomen'=>$catWomen, 'brand'=>$brand, 
        'cart'=>$cart, 'subtotal'=>$subtotal, 'total'=>$total, 'count'=>$cart3[0]['count']]);
        // return $this->json($cart);
    }
    // In cart
    /**
     * @Route("/updateQty/{id}", name="edit_qty")
     */
    public function editQty(CartRepository $repo, Cart $cart, Request $req): Response
    {
        $quantity = $req->query->get('qty');
        $cart->setProductCount($quantity);
        $repo->save($cart, true);
        return $this->redirectToRoute('app_cart');
    }
    /**
     * @Route("/removeCart/{id}", name="remove_product")
     */
    public function removeCart(Request $req, CartRepository $repo, Cart $cart): Response
    {
        $repo->remove($cart, true);
        return $this->redirectToRoute('app_cart');
    }
    /**
     * @Route("/addOrder", name="order_orderDetail")
     */
    public function addOrder(Request $req, OrderRepository $repo, OrderDetailRepository $repo2, UserRepository $repo3, CartRepository $repo4, ProductRepository $repo5): Response
    {   
        $order = new Order();
        $user = $this->getUser();
        $data[]=[
            'id'=>$user->getId()
        ];
        $getUserId = $repo3->findOneBy(['id'=>$user]);
        $total = $req->query->get('total');
        $address = $req->query->get('address');
        // $date = new \DateTime();
        $date= new DateTime("", new DateTimeZone("Asia/Ho_Chi_Minh"));
        // $date = $datetime->format('d-m-y h:i:s');
        
        $order->setSum((float)$total);
        $order->setDate($date);
        $order->setAddress($address);
        $order->setUsers($getUserId);
        $repo->save($order, true);
        // return $this->json('ok');

        // $oid = $repo->findOrderId($date);
        $id = $order->getId($date);
        $oid = $repo->findOneBy(['id'=>$id]);
        $number = $repo4->countProductInCart();
        $inCart = $repo4->findCartByUId($data[0]['id']);
        // $product_id = $repo5->findOneBy(['id'=>$inCart[0]['product']]);
        $num = $number[0]['count'];

        for($i=0;$i<$num;$i++){
            $oDetail = new OrderDetail();
            $product_id = $repo5->findOneBy(['id'=>$inCart[$i]['product']]);
            $oDetail->setProductQuantity($inCart[$i]['product_count']);
            $oDetail->setOd($oid);
            $oDetail->setProducts($product_id);
            $repo2->save($oDetail, true);
        }
        return $this->redirectToRoute('app_bill');
    }
    /**
     * @Route("/bill", name="app_bill")
     */
    public function showBill(OrderDetailRepository $repo, OrderRepository $repo2): Response
    {
        $user = $this->getUser();
        $datetime= new DateTime("", new DateTimeZone("Asia/Ho_Chi_Minh"));
        $date = $datetime->format('Y-m-d H:i:s');
        $findDate = $repo2->findDate($date);
        $detail = $repo->showDetail($date);
        // return $this->render('main/bill.html.twig', ['user'=>$user, 'detail'=>$detail, 'findDate'=>$findDate]);
        return $this->json($detail);
    }
}
