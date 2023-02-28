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
use App\Repository\ProductImageRepository;
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
    public function home(Request $req, AuthenticationUtils $authenticationUtils, CategoryRepository $repo, BrandRepository $repo2, ProductRepository $repo3): Response
    {
        $findTrend = $repo3->findTrending();
        $catMen = $repo->findBy(['category_parent'=>'men']);
        $catWomen = $repo->findBy(['category_parent'=>'women']);
        $brand = $repo2->findAll();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('main/index.html.twig', ['last_username'=>$lastUsername, 'catMen'=>$catMen, 'catWomen'=>$catWomen, 'brand'=>$brand, 'findTrend'=>$findTrend]);
    }
    /**
     * @Route("/account", name="app_account")
     */
    public function account(Request $req, AuthenticationUtils $authenticationUtils, UserRepository $repo, CategoryRepository $repo2, BrandRepository $repo3): Response
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
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $brand = $repo3->findAll();
        return $this->render('main/account.html.twig', ['last_username'=>$lastUsername, 'userForm'=>$form->createView(), 'catMen'=>$catMen, 'catWomen'=>$catWomen, 'brand'=>$brand]);
    }
    /**
     * @Route("/orderHistory", name="app_history")
     */
    public function showHistory(AuthenticationUtils $authenticationUtils, CategoryRepository $repo, BrandRepository $repo2, OrderDetailRepository $repo3): Response
    {
        $user = $this->getUser();
        $data[]=[
            'id'=>$user->getId()
        ];
        $historyProduct = $repo3->findProductHistory($data[0]['id']);
        $catMen = $repo->findBy(['category_parent'=>'men']);
        $catWomen = $repo->findBy(['category_parent'=>'women']);
        $brand = $repo2->findAll();
        $username = $authenticationUtils->getLastUsername();
        return $this->render('main/history.html.twig', ['last_username'=>$username, 'catMen'=>$catMen, 'catWomen'=>$catWomen, 'brand'=>$brand, 'history'=>$historyProduct]);
        // return $this->json($historyProduct);
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
    public function showproductBrand(AuthenticationUtils $authenticationUtils, $brand_id, ProductRepository $repo, CategoryRepository $repo2, BrandRepository $repo3): Response
    {
        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        $username = $authenticationUtils->getLastUsername();
        $brand = $repo3->findAll();
        $brand2 = $repo3->findBy(['id'=>$brand_id]);

        $findProductBrand = $repo->findProductByBrand($brand_id);
        return $this->render('main/productBrand.html.twig', ['last_username'=>$username, 
        'catMen'=>$catMen, 'catWomen'=>$catWomen, 'brand'=>$brand, 'productBrand'=>$findProductBrand, 'findBrand'=>$brand2]);
        // return $this->json($findProductBrand);
    }
    /**
     * @Route("/productBrandMen/{brand_id}", name="app_product_brand_men")
     */
    public function showProductByBrandMen(AuthenticationUtils $authenticationUtils, $brand_id, ProductRepository $repo, CategoryRepository $repo2, BrandRepository $repo3): Response
    {
        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        $findProduct = $repo->findProductByBrandMen($brand_id);
        $brand = $repo3->findAll();
        $findBrand = $repo3->findBy(['id'=>$brand_id]);
        $username = $authenticationUtils->getLastUsername();
        return $this->render('main/productBrandMen.html.twig', ['last_username'=>$username, 'showProductBrand'=>$findProduct, 
        'catMen'=>$catMen, 'catWomen'=>$catWomen, 'findBrand'=>$findBrand, 'brand'=>$brand]);
        // return $this->json($findProduct);
    }
    /**
     * @Route("/productBrandWomen/{brand_id}", name="app_product_brand_women")
     */
    public function showProductByBrandWomen(AuthenticationUtils $authenticationUtils, $brand_id, ProductRepository $repo, CategoryRepository $repo2, BrandRepository $repo3): Response
    {
        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        $findProduct = $repo->findProductByBrandWomen($brand_id);
        $brand = $repo3->findAll();
        $findBrand = $repo3->findBy(['id'=>$brand_id]);
        $username = $authenticationUtils->getLastUsername();
        return $this->render('main/productBrandWomen.html.twig', ['last_username'=>$username, 'showProductBrand'=>$findProduct, 
        'catMen'=>$catMen, 'catWomen'=>$catWomen, 'findBrand'=>$findBrand, 'brand'=>$brand]);
        // return $this->json($findProduct);
    }
    /**
     * @Route("/search", name="app_search")
     */
    public function searchAction(Request $req, ProductRepository $repo, CategoryRepository $repo2, AuthenticationUtils $authenticationUtils, BrandRepository $repo3): Response
    {
        $param = $req->request->get('search-content');
        $searchResult = $repo->searchProduct($param);
        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        $username = $authenticationUtils->getLastUsername();
        $brand = $repo3->findAll();
        return $this->render('main/search.html.twig', ['last_username'=>$username, 'result'=>$searchResult
        , 'catMen'=>$catMen, 'catWomen'=>$catWomen, 'content'=>$param, 'brand'=>$brand
        ]);
    }
    /**
     * @Route("/showDetail/{id}", name="show_detail")
     */
    public function showProductDetail($id, CategoryRepository $repo2, ProductRepository $repo, AuthenticationUtils $authenticationUtils, ProductDetailRepository $repo3, BrandRepository $repo4, ProductImageRepository $repo5): Response
    {
        $showDetail = $repo->findBy(['id'=>$id]);
        $catName = $repo2->getCatName($id);
        $getProductDetail = $repo3->findBy(['id'=>$id]);
        $getSize = $repo3->findSize($id);
        $getImg = $repo5->findBy(['product'=>$id]);

        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        $username = $authenticationUtils->getLastUsername();
        $brand = $repo4->findAll();
        return $this->render('main/pDetail.html.twig', ['showDetail'=>$showDetail, 'catMen'=>$catMen, 'catWomen'=>$catWomen,
        'last_username'=>$username, 'catName'=>$catName, 'getProductDetail'=>$getProductDetail, 'brand'=>$brand, 'message'=>0,
        'getSize'=>$getSize, 'getImg'=>$getImg
        ]);
        // return $this->json($getImg);
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
        $getSize = $repo4->findSize($id);
        if($size == "Select Size"){
            return $this->render('main/pDetail.html.twig', ['message'=>'Please choose your size', 'catMen'=>$catMen, 'catWomen'=>$catWomen
            , 'brand'=>$brand, 'last_username'=>$username, 'showDetail'=>$showDetail, 'catName'=>$catName, 'getProductDetail'=>$getProductDetail,
            'getSize'=>$getSize
            ]);
        }
        $checkCart = $repo->checkProductInCart($data[0]['id'], (int)$id, $size);
        if($checkCart == []){
            $cart->setUser($getUserId);
            $cart->setSize($size);
            $cart->setProductCount($quantity);
            $cart->setProduct($proId);

            $repo->save($cart,true);
            return $this->redirectToRoute('app_home');
        }else{
            // $qty_update_value = $checkCart[0]['product_count'] + $quantity;
            // return $this->json($qty_update_value);
            return $this->redirectToRoute('cart_update', ['cart_id'=>$checkCart[0]['id'], 'qty'=>$quantity]);
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
        $user = $this->getUser();
        $data[]=[
            'id'=>$user->getId()
        ];
        $cart = $repo3->findProductInCart($data[0]['id']);
        $cart2 = $repo3->findPrice();
        $cart3 = $repo3->countProductInCart($data[0]['id']);
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
        'cart'=>$cart, 'subtotal'=>$subtotal, 'total'=>$total, 'count'=>$cart3[0]['count'], 'message'=>'']);
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
    public function addOrder(Request $req, OrderRepository $repo, OrderDetailRepository $repo2, UserRepository $repo3, CartRepository $repo4, 
    ProductRepository $repo5, AuthenticationUtils $authenticationUtils, CategoryRepository $repo6, BrandRepository $repo7): Response
    {   
        $order = new Order();
        $user = $this->getUser();
        $data[]=[
            'id'=>$user->getId()
        ];
        $getUserId = $repo3->findOneBy(['id'=>$user]);
        $total = $req->query->get('total');
        $subtotal = $req->query->get('subtotal');
        $address = $req->query->get('address');
        // $date = new \DateTime();
        $date= new DateTime("", new DateTimeZone("Asia/Ho_Chi_Minh"));
        // $date = $datetime->format('d-m-y h:i:s');

        $cart = $repo4->findProductInCart($data[0]['id']);
        $cart2 = $repo4->countProductInCart($data[0]['id']);
        $username = $authenticationUtils->getLastUsername();
        $catWomen = $repo6->findBy(['category_parent'=>'women']);
        $catMen = $repo6->findBy(['category_parent'=>'men']);
        $brand = $repo7->findAll();
        if($subtotal == $total || $address == ""){
            return $this->render('main/cart.html.twig', ['last_username'=>$username, 'catMen'=>$catMen, 'catWomen'=>$catWomen, 'brand'=>$brand, 
        'cart'=>$cart, 'subtotal'=>$subtotal, 'total'=>$total, 'count'=>$cart2[0]['count'], 'message'=>'Please make sure you have selected your delivery method and filled in your address']);
        }
        else{
            $order->setSum((float)$total);
            $order->setDate($date);
            $order->setAddress($address);
            $order->setUsers($getUserId);
            $repo->save($order, true);
            // return $this->json('ok');
    
            // $oid = $repo->findOrderId($date);
            $id = $order->getId($date);
            $oid = $repo->findOneBy(['id'=>$id]);
            $number = $repo4->countProductInCart($data[0]['id']);
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
            $repo4->deleteCart($data[0]['id']);
            return $this->redirectToRoute('app_bill');
        }
        
        // return $this->json($address);
    }
    /**
     * @Route("/bill", name="app_bill")
     */
    public function showBill(OrderDetailRepository $repo, OrderRepository $repo2): Response
    {
        $user = $this->getUser();
        $data[]=[
            'id'=>$user->getId(),
            'first_name'=>$user->getFirstName(),
            'last_name'=>$user->getLastName(),
        ];
        $uid=$data[0]['id'];
        $uFirstName = $data[0]['first_name'];
        $uLastName = $data[0]['last_name'];
        $datetime = new DateTime("", new DateTimeZone("Asia/Ho_Chi_Minh"));
        $date = $datetime->format('Y-m-d H:i:s');
        $findDate = $repo2->findDate($date);
        $detail = $repo->showDetail($date);
        $itemNumber = $repo->countItemOrder($date);
        $countItem = $itemNumber[0]['count'];
        return $this->render('main/bill.html.twig', ['user'=>$date, 'detail'=>$detail, 'findDate'=>$findDate, 
        'uid'=>$uid, 'uFirstName'=>$uFirstName, 'uLastName'=>$uLastName, 'numItem'=>$countItem
        ]);
        // return $this->json($countItem);
    }

    /**
     * @Route("/men", name="app_men")
     */
    public function showMen(ProductRepository $repo, CategoryRepository $repo2, BrandRepository $repo3, AuthenticationUtils $authenticationUtils): Response
    {
        $findMen = $repo->findProductMen();
        $username = $authenticationUtils->getLastUsername();
        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        $brand = $repo3->findAll();
        // return $this->json($findMen);
        return $this->render('main/shopMen.html.twig', ['findMen'=>$findMen, 'last_username'=>$username, 'catMen'=>$catMen, 'catWomen'=>$catWomen, 'brand'=>$brand]);
    }
    /**
     * @Route("/women", name="app_women")
     */
    public function FunctionName(ProductRepository $repo, CategoryRepository $repo2, BrandRepository $repo3, AuthenticationUtils $authenticationUtils): Response
    {
        $findWomen = $repo->findProductWomen();
        $username = $authenticationUtils->getLastUsername();
        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        $brand = $repo3->findAll();
        // return $this->json($findMen);
        return $this->render('main/shopWomen.html.twig', ['findWomen'=>$findWomen, 'last_username'=>$username, 'catMen'=>$catMen, 'catWomen'=>$catWomen, 'brand'=>$brand]);
    }
    /**
     * @Route("/trend", name="app_trend")
     */
    public function showTrending(ProductRepository $repo, CategoryRepository $repo2, BrandRepository $repo3, AuthenticationUtils $authenticationUtils): Response
    {
        $findTrend = $repo->findTrending();
        $username = $authenticationUtils->getLastUsername();
        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        $brand = $repo3->findAll();
        return $this->render('main/index.html.twig', ['last_username'=>$username, 'catMen'=>$catMen, 'catWomen'=>$catWomen, 'brand'=>$brand, 'findTrend'=>$findTrend]);
    }
    /**
     * @Route("/showTrend", name="show_trend")
     */
    public function showTrendDetail(ProductRepository $repo, CategoryRepository $repo2, BrandRepository $repo3, AuthenticationUtils $authenticationUtils): Response
    {
        $findTrend = $repo->findTrendDetail();
        $username = $authenticationUtils->getLastUsername();
        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        $brand = $repo3->findAll();
        return $this->render('main/shopTrending.html.twig', ['last_username'=>$username, 'catMen'=>$catMen, 'catWomen'=>$catWomen, 'brand'=>$brand, 'findTrend'=>$findTrend]);
    }
}
