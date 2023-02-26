<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\ProductDetail;
use App\Entity\ProductImage;
use App\Form\BrandFormType;
use App\Form\CategoryFormType;
use App\Form\ImageFormType;
use App\Form\PDetailFormType;
use App\Form\ProductFormType;
use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductDetailRepository;
use App\Repository\ProductImageRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\String\Slugger\SluggerInterface;

class ManageController extends AbstractController
{
    private ProductRepository $repo;
    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
    }

    // Product table

    /**
     * @Route("/manage", name="show_manage")
     */
    public function manageShow(AuthenticationUtils $authenticationUtils, CategoryRepository $repo): Response
    {
        $catWomen = $repo->findBy(['category_parent'=>'women']);
        $catMen = $repo->findBy(['category_parent'=>'men']);
        $product = $this->repo->findAll();
        $lastUserName = $authenticationUtils->getLastUsername();
        return $this->render('manage/index.html.twig', ['last_username'=>$lastUserName, 'product'=>$product
        , 'catMen'=>$catMen, 'catWomen'=>$catWomen
        ]);
    }
    /**
    * @Route("/add", name="product_insert")
    */
    public function createAction(Request $req, SluggerInterface $slugger, AuthenticationUtils $authenticationUtils, CategoryRepository $repo): Response
    {   
        $catWomen = $repo->findBy(['category_parent'=>'women']);
        $catMen = $repo->findBy(['category_parent'=>'men']);
        $p = new Product();
        $form = $this->createForm(ProductFormType::class, $p);

        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            if($p->getImportDate()===null){
                $p->setImportDate(new \DateTime());
            }
            $imgFile = $form->get('file')->getData();
            if ($imgFile) {
                $newFilename = $this->uploadImage($imgFile,$slugger);
                $p->setImage($newFilename);
            }
            $this->repo->save($p,true);
            return $this->redirectToRoute('show_manage', [], Response::HTTP_SEE_OTHER);
        }
        $username = $authenticationUtils->getLastUsername();
        return $this->render("manage/product.html.twig",[
            'form' => $form->createView(),
            'last_username'=>$username,
            'catMen'=>$catMen,
            'catWomen'=>$catWomen
        ]);
    }

     /**
     * @Route("/edit/{id}", name="product_edit",requirements={"id"="\d+"})
     */
    public function editAction(Request $req, Product $p,
    SluggerInterface $slugger): Response
    {
        
        $form = $this->createForm(ProductType::class, $p);   

        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){

            if($p->getImportDate()===null){
                $p->setImportDate(new \DateTime());
            }
            $imgFile = $form->get('file')->getData();
            if ($imgFile) {
                $newFilename = $this->uploadImage($imgFile,$slugger);
                $p->setImage($newFilename);
            }
            $this->repo->save($p,true);
            return $this->redirectToRoute('show_manage', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render("product/form.html.twig",[ 
            'form' => $form->createView()
        ]);
    }

    public function uploadImage($imgFile, SluggerInterface $slugger): ?string{
        $originalFilename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$imgFile->guessExtension();
        try {
            $imgFile->move(
                $this->getParameter('image_dir'),
                $newFilename
            );
        } catch (FileException $e) {
            echo $e;
        }
        return $newFilename;
    }

    /**
     * @Route("/delete/{id}",name="product_delete",requirements={"id"="\d+"})
     */
    
    public function deleteAction(Request $request, Product $p): Response
    {
        $this->repo->remove($p,true);
        return $this->redirectToRoute(' ', [], Response::HTTP_SEE_OTHER);
    }

    // Category table

    /**
     * @Route("/category", name="show_category")
     */
    public function categoryShow(AuthenticationUtils $authenticationUtils, CategoryRepository $cat_repo): Response
    {
        $cat = $cat_repo->findAll();
        $catWomen = $cat_repo->findBy(['category_parent'=>'women']);
        $catMen = $cat_repo->findBy(['category_parent'=>'men']);
        $username = $authenticationUtils->getLastUsername();
        return $this->render('manage/category.html.twig', ['last_username'=>$username, 'category'=>$cat,
        'catMen'=>$catMen, 'catWomen'=>$catWomen
        ]);
    }
    /**
     * @Route("/addCat", name="category_insert")
     */
    public function addCatAction(Request $req, CategoryRepository $cat_repo, AuthenticationUtils $authenticationUtils): Response
    {
        $catWomen = $cat_repo->findBy(['category_parent'=>'women']);
        $catMen = $cat_repo->findBy(['category_parent'=>'men']);
        $cat = new Category();
        $form = $this->createForm(CategoryFormType::class, $cat);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $cat_repo->save($cat, true);
            return $this->redirectToRoute('show_category');
        }
        $username = $authenticationUtils->getLastUsername();
        return $this->render('manage/catForm.html.twig', ['form'=>$form->createView(), 'last_username'=>$username
        , 'catWomen'=>$catWomen, 'catMen'=>$catMen]);
    }
    /**
     * @Route("/editCat", name="category_edit")
     */
    public function editCatAction(): Response
    {
        return $this->render('$0.html.twig', []);
    }
    /**
     * @Route("/deleteCat", name="category_delete")
     */
    public function deleteCat(): Response
    {
        return $this->render('$0.html.twig', []);
    }

    // Product detail table

    /**
     * @Route("/productDetail", name="productDetail_show")
     */
    public function showProductDetail(AuthenticationUtils $authenticationUtils, CategoryRepository $repo, ProductDetailRepository $repo2): Response
    {
        $pDetail = $repo2->showProductDetail();
        $username = $authenticationUtils->getLastUsername();
        $catWomen = $repo->findBy(['category_parent'=>'women']);
        $catMen = $repo->findBy(['category_parent'=>'men']);
        return $this->render('manage/productDetail.html.twig', ['last_username'=>$username, 'catMen'=>$catMen,
        'catWomen'=>$catWomen, 'pDetail'=>$pDetail
        ]);
    }
    /**
     * @Route("/addPDetail", name="pDetail_insert")
     */
    public function addProductDetail(Request $req, AuthenticationUtils $authenticationUtils, ProductDetailRepository $repo, CategoryRepository $repo2): Response
    {
        $pd = new ProductDetail();
        $form = $this->createForm(PDetailFormType::class, $pd);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $repo->save($pd, true);
            return $this->redirectToRoute('productDetail_show');
        }
        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        $username = $authenticationUtils->getLastUsername();
        return $this->render('manage/pDetailForm.html.twig', ['form'=>$form->createView(), 'catMen'=>$catMen, 'catWomen'=>$catWomen,
        'last_username'=>$username
        ]);
    }
    /**
     * @Route("/editPDetail", name="pDetail_edit")
     */
    public function editPDetail(): Response
    {
        return $this->render('$0.html.twig', []);
    }
    /**
     * @Route("/deletePDetail", name="pDetail_delete")
     */
    public function deletePDetail(): Response
    {
        return $this->render('$0.html.twig', []);
    }

    // Image table
    /**
     * @Route("/image", name="image_show")
     */
    public function showImage(AuthenticationUtils $authenticationUtils, CategoryRepository $repo, ProductImageRepository $repo2): Response
    {
        $img = $repo2->showImg();
        $catWomen = $repo->findBy(['category_parent'=>'women']);
        $catMen = $repo->findBy(['category_parent'=>'men']);
        $username = $authenticationUtils->getLastUsername();
        return $this->render('manage/image.html.twig', ['img'=>$img, 'catMen'=>$catMen, 'catWomen'=>$catWomen, 'last_username'=>$username]);
    }
    /**
     * @Route("/addImage", name="image_insert")
     */
    public function AddImage(Request $req, ProductImageRepository $repo, CategoryRepository $repo2, AuthenticationUtils $authenticationUtils): Response
    {
        $img = new ProductImage();
        $form = $this->createForm(ImageFormType::class, $img);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $repo->save($img, true);
            return $this->redirectToRoute('image_show');
        }
        $username = $authenticationUtils->getLastUsername();
        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        return $this->render('manage/imageForm.html.twig', ['last_username'=>$username, 'catMen'=>$catMen, 'catWomen'=>$catWomen, 
        'form'=>$form->createView()]);
    }

    // Brand table

    /**
     * @Route("/brand", name="brand_show")
     */
    public function showBrand(CategoryRepository $repo, BrandRepository $repo2, AuthenticationUtils $authenticationUtils): Response
    {
        $brand = $repo2->findAll();
        $catWomen = $repo->findBy(['category_parent'=>'women']);
        $catMen = $repo->findBy(['category_parent'=>'men']);
        $username = $authenticationUtils->getLastUsername();
        return $this->render('manage/brand.html.twig', ['brand'=>$brand, 'catMen'=>$catMen, 'catWomen'=>$catWomen, 'last_username'=>$username]);
    }
    /**
     * @Route("/addBrand", name="brand_insert")
     */
    public function addBrand(Request $req, SluggerInterface $slugger, BrandRepository $repo, CategoryRepository $repo2, AuthenticationUtils $authenticationUtils): Response
    {
        $brand = new Brand();
        $form = $this->createForm(BrandFormType::class, $brand);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $imgFile = $form->get('file')->getData();
            if ($imgFile) {
                $newFilename = $this->uploadImage($imgFile,$slugger);
                $brand->setImage($newFilename);
            }
            $repo->save($brand, true);
            return $this->redirectToRoute('brand_show');
        }
        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        $username = $authenticationUtils->getLastUsername();
        return $this->render('manage/brandForm.html.twig', ['form'=>$form->createView(), 'catMen'=>$catMen, 'catWomen'=>$catWomen, 'last_username'=>$username]);
    }





    
}

