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
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

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
    public function manageShow(AuthenticationUtils $authenticationUtils, CategoryRepository $repo, BrandRepository $repo2): Response
    {
        $catWomen = $repo->findBy(['category_parent'=>'women']);
        $catMen = $repo->findBy(['category_parent'=>'men']);
        $brand = $repo2->findAll();
        $product = $this->repo->findAll();
        $lastUserName = $authenticationUtils->getLastUsername();
        return $this->render('manage/index.html.twig', ['last_username'=>$lastUserName, 'product'=>$product
        , 'catMen'=>$catMen, 'catWomen'=>$catWomen, 'brand'=>$brand
        ]);
    }
    /**
    * @Route("/add", name="product_insert")
    */
    public function createAction(Request $req, SluggerInterface $slugger, AuthenticationUtils $authenticationUtils, CategoryRepository $repo2, BrandRepository $repo3): Response
    {   
        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        $brand = $repo3->findAll();
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
            'catWomen'=>$catWomen,
            'brand'=>$brand
        ]);
    }

     /**
     * @Route("/edit/{id}", name="product_edit",requirements={"id"="\d+"})
     */
    public function editAction(Request $req, Product $p,
    SluggerInterface $slugger, CategoryRepository $repo2, BrandRepository $repo3, AuthenticationUtils $authenticationUtils): Response
    {
        
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
        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        $brand = $repo3->findAll();
        $username = $authenticationUtils->getLastUsername();
        return $this->render("manage/product.html.twig",[ 
            'form' => $form->createView(),
            'last_username'=>$username,
            'catMen'=>$catMen,
            'catWomen'=>$catWomen,
            'brand'=>$brand
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
     * @Route("/delete/{pro_id}",name="product_delete",requirements={"id"="\d+"})
     * 
     * @Entity("p", expr="repository.find(pro_id)") 
     */
    
    public function deleteAction(Product $p): Response
    {
        $this->repo->remove($p,true);
        return $this->redirectToRoute('show_manage', [], Response::HTTP_SEE_OTHER);
    }

    // Category table

    /**
     * @Route("/category", name="show_category")
     */
    public function categoryShow(AuthenticationUtils $authenticationUtils, CategoryRepository $cat_repo, BrandRepository $repo): Response
    {
        $cat = $cat_repo->findAll();
        $catWomen = $cat_repo->findBy(['category_parent'=>'women']);
        $catMen = $cat_repo->findBy(['category_parent'=>'men']);
        $brand = $repo->findAll();
        $username = $authenticationUtils->getLastUsername();
        return $this->render('manage/category.html.twig', ['last_username'=>$username, 'category'=>$cat,
        'catMen'=>$catMen, 'catWomen'=>$catWomen, 'brand'=>$brand
        ]);
    }
    /**
     * @Route("/addCat", name="category_insert")
     */
    public function addCatAction(Request $req, CategoryRepository $cat_repo, AuthenticationUtils $authenticationUtils, BrandRepository $repo): Response
    {
        $cat = new Category();
        $form = $this->createForm(CategoryFormType::class, $cat);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $cat_repo->save($cat, true);
            return $this->redirectToRoute('show_category');
        }
        $username = $authenticationUtils->getLastUsername();
        $catWomen = $cat_repo->findBy(['category_parent'=>'women']);
        $catMen = $cat_repo->findBy(['category_parent'=>'men']);
        $brand = $repo->findAll();
        return $this->render('manage/catForm.html.twig', ['form'=>$form->createView(), 'last_username'=>$username,
        'catMen'=>$catMen, 'catWomen'=>$catWomen, 'brand'=>$brand
        ]);
    }
    /**
     * @Route("/editCat/{id}", name="category_edit")
     */
    public function editCatAction(Request $req, CategoryRepository $repo, Category $cat, AuthenticationUtils $authenticationUtils, BrandRepository $repo2): Response
    {
        $form = $this->createForm(CategoryFormType::class, $cat);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $repo->save($cat, true);
            return $this->redirectToRoute('show_category');
        }
        $username = $authenticationUtils->getLastUsername();
        $catWomen = $repo->findBy(['category_parent'=>'women']);
        $catMen = $repo->findBy(['category_parent'=>'men']);
        $brand = $repo2->findAll();
        return $this->render('manage/catForm.html.twig', ['form'=>$form->createView(), 'last_username'=>$username,
        'catMen'=>$catMen, 'catWomen'=>$catWomen, 'brand'=>$brand
        ]);
    }
    /**
     * @Route("/deleteCat/{id}", name="category_delete")
     */
    public function deleteCat(Category $cat, CategoryRepository $repo): Response
    {
        $repo->remove($cat, true);
        return $this->redirectToRoute('show_category');
    }

    // Product detail table

    /**
     * @Route("/productDetail", name="productDetail_show")
     */
    public function showProductDetail(AuthenticationUtils $authenticationUtils, CategoryRepository $repo, ProductDetailRepository $repo2, BrandRepository $repo3): Response
    {
        $brand = $repo3->findAll();
        $pDetail = $repo2->showProductDetail();
        $username = $authenticationUtils->getLastUsername();
        $catWomen = $repo->findBy(['category_parent'=>'women']);
        $catMen = $repo->findBy(['category_parent'=>'men']);
        return $this->render('manage/productDetail.html.twig', ['last_username'=>$username, 'catMen'=>$catMen,
        'catWomen'=>$catWomen, 'pDetail'=>$pDetail, 'brand'=>$brand
        ]);
    }
    /**
     * @Route("/addPDetail", name="pDetail_insert")
     */
    public function addProductDetail(Request $req, AuthenticationUtils $authenticationUtils, ProductDetailRepository $repo, CategoryRepository $repo2, BrandRepository $repo3): Response
    {
        $brand = $repo3->findAll();
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
        'last_username'=>$username, 'brand'=>$brand
        ]);
    }
    /**
     * @Route("/editPDetail/{id}", name="pDetail_edit")
     */
    public function editPDetail(Request $req, ProductDetail $pd, ProductDetailRepository $repo, CategoryRepository $repo2, BrandRepository $repo3, AuthenticationUtils $authenticationUtils): Response
    {
        $brand = $repo3->findAll();
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
        'last_username'=>$username, 'brand'=>$brand
        ]);
    }
    /**
     * @Route("/deletePDetail/{id}", name="pDetail_delete")
     */
    public function deletePDetail(ProductDetail $pd, ProductDetailRepository $repo): Response
    {
        $repo->remove($pd, true);
        return $this->redirectToRoute('productDetail_show');
    }

    // Image table
    /**
     * @Route("/image", name="image_show")
     */
    public function showImage(AuthenticationUtils $authenticationUtils, CategoryRepository $repo, ProductImageRepository $repo2, BrandRepository $repo3): Response
    {
        $img = $repo2->showImg();
        $catWomen = $repo->findBy(['category_parent'=>'women']);
        $catMen = $repo->findBy(['category_parent'=>'men']);
        $brand = $repo3->findAll();
        $username = $authenticationUtils->getLastUsername();
        return $this->render('manage/image.html.twig', ['img'=>$img, 'catMen'=>$catMen, 'catWomen'=>$catWomen, 'last_username'=>$username, 'brand'=>$brand]);
    }
    /**
     * @Route("/addImage", name="image_insert")
     */
    public function AddImage(Request $req, SluggerInterface $slugger, ProductImageRepository $repo, CategoryRepository $repo2, AuthenticationUtils $authenticationUtils, BrandRepository $repo3): Response
    {
        $img = new ProductImage();
        $form = $this->createForm(ImageFormType::class, $img);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $imgFile = $form->get('file')->getData();
            if ($imgFile) {
                $newFilename = $this->uploadImage($imgFile,$slugger);
                $img->setImage($newFilename);
            }
            $repo->save($img, true);
            return $this->redirectToRoute('image_show');
        }
        $username = $authenticationUtils->getLastUsername();
        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        $brand = $repo3->findAll();
        return $this->render('manage/imageForm.html.twig', ['last_username'=>$username, 'catMen'=>$catMen, 'catWomen'=>$catWomen, 
        'form'=>$form->createView(), 'brand'=>$brand]);
    }
    /**
     * @Route("/editImg{id}", name="img_edit")
     */
    public function editImage(Request $req, ProductImage $img, SluggerInterface $slugger, ProductImageRepository $repo, CategoryRepository $repo2, AuthenticationUtils $authenticationUtils, BrandRepository $repo3): Response
    {
        $form = $this->createForm(ImageFormType::class, $img);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $imgFile = $form->get('file')->getData();
            if ($imgFile) {
                $newFilename = $this->uploadImage($imgFile,$slugger);
                $img->setImage($newFilename);
            }
            $repo->save($img, true);
            return $this->redirectToRoute('image_show');
        }
        $username = $authenticationUtils->getLastUsername();
        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        $brand = $repo3->findAll();
        return $this->render('manage/imageForm.html.twig', ['last_username'=>$username, 'catMen'=>$catMen, 'catWomen'=>$catWomen, 
        'form'=>$form->createView(), 'brand'=>$brand]);
    }
    /**
     * @Route("/deleteImg{id}", name="img_delete")
     */
    public function deleteImage(ProductImage $img, ProductImageRepository $repo): Response
    {
        $repo->remove($img,true);
        return $this->redirectToRoute('image_show');
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
    public function addBrand(Request $req, SluggerInterface $slugger, BrandRepository $repo, CategoryRepository $repo2, AuthenticationUtils $authenticationUtils, BrandRepository $repo3): Response
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
        $brand = $repo3->findAll();
        $username = $authenticationUtils->getLastUsername();
        return $this->render('manage/brandForm.html.twig', ['form'=>$form->createView(), 'catMen'=>$catMen, 'catWomen'=>$catWomen, 'last_username'=>$username, 'brand'=>$brand]);
    }
    /**
     * @Route("/editBrand/{id}", name="brand_edit")
     */
    public function editBrand(Request $req, SluggerInterface $slugger, BrandRepository $repo, CategoryRepository $repo2, AuthenticationUtils $authenticationUtils,
     Brand $brand): Response
    {
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
        $brand = $repo->findAll();
        $username = $authenticationUtils->getLastUsername();
        return $this->render('manage/brandForm.html.twig', ['form'=>$form->createView(), 'catMen'=>$catMen, 'catWomen'=>$catWomen, 'last_username'=>$username, 'brand'=>$brand]);
    }
    /**
     * @Route("/deleteBrand/{id}", name="brand_delete")
     */
    public function deleteBrand(Brand $brand, BrandRepository $repo): Response
    {
        $repo->remove($brand, true);
        return $this->redirectToRoute('brand_show');
    }
}

