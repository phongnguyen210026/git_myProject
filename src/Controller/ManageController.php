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
use Doctrine\ORM\EntityManagerInterface;
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
    public function editAction(Request $req, ProductRepository $repo, AuthenticationUtils $authenticationUtils,
    SluggerInterface $slugger, $id, CategoryRepository $repo1): Response
    {
        $pro=$repo->find($id);
        if(!$pro){
            throw $this->createNotFoundException('Product not found');
        }
        $catWomen = $repo1->findBy(['category_parent'=>'women']);
        $catMen = $repo1->findBy(['category_parent'=>'men']);
        $username = $authenticationUtils->getLastUsername();


        $form = $this->createForm(ProductFormType::class, $pro);   

        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){

            if($pro->getImportDate()===null){
                $pro->setImportDate(new \DateTime());
            }
            $imgFile = $form->get('file')->getData();
            if ($imgFile) {
                $newFilename = $this->uploadImage($imgFile,$slugger);
                $pro->setImage($newFilename);
            }
            $repo->save($pro,true);
            return $this->redirectToRoute('show_manage');
        }
        return $this->render("manage/product.html.twig",[ 
            'form' => $form->createView(),
            'last_username'=>$username,
            'catMen'=>$catMen,
            'catWomen'=>$catWomen,
            'product'=>$pro
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
    
    public function deleteAction(EntityManagerInterface $entityManager,$id,ProductRepository $repo): Response
    {
        $p=$repo->find($id);
        if(!$p){
            throw $this->createNotFoundException('Product not found');
        }
        $entityManager->remove($p);
        $entityManager->flush();
        return $this->redirectToRoute('show_manage');
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




//     /**
//  * @Route("/addCat", name="category_insert")
//  * @Route("/editCat/{id}", name="category_edit")
//  */
// public function newOrEdit(Request $req, Category $category = null, CategoryRepository $repo, AuthenticationUtils  $authenticationUtils): Response
// {
//     $username = $authenticationUtils->getLastUsername();
//     $catWomen = $repo->findBy(['category_parent'=>'women']);
//     $catMen = $repo->findBy(['category_parent'=>'men']);
//     // Get all categories for display in the form
//     $categories = $repo->findAll();

//     // If a category is not passed in, create a new one
//     if (!$category) {
//         $category = new Category();
//     }

//     // Create a form for the category
//     $form = $this->createForm(CategoryFormType::class, $category);

//     // Handle the form submission
//     $form->handleRequest($req);
//     if ($form->isSubmitted() && $form->isValid()) {
//         // Save the category
//         $repo->save($category);

//         // Redirect to the category list page
//         return $this->redirectToRoute('show_category');
//     }

//     // Render the category form
//     return $this->render('manage/catForm.html.twig', [
//         'category' => $category,
//         'form' => $form->createView(),
//         'categories' => $categories, 'catWomen'=>$catWomen, 'catMen'=>$catMen
//         ,'last_username'=>$username
//     ]);
// }



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
     * @Route("/editCat/{id}", name="category_edit")
     */
    public function editCatAction(Request $req,$id, CategoryRepository $repo,
    AuthenticationUtils $authenticationUtils): Response
    {
        $cat = $repo->find($id);
        if(!$cat){
            throw $this->createNotFoundException('Category not found');
        }
        $catWomen = $repo->findBy(['category_parent'=>'women']);
        $catMen = $repo->findBy(['category_parent'=>'men']);
        $username = $authenticationUtils->getLastUsername();

        $form=$this->createForm(CategoryFormType::class, $cat);

        $form->handleRequest($req);
        if($form->isSubmitted()&&$form->isValid()){
            $repo->save($cat,true);
        return $this->redirectToRoute('show_category');
       
        }
       return $this->render("manage/catForm.html.twig",[
        'form'=>$form->createView(),
        'last_username'=>$username,
        'catMen'=>$catMen,
        'catWomen'=>$catWomen,
        'category'=>$cat
       ]);
    }
   
    /**
 * @Route("/deleteCat/{id}", name="category_delete")
     */
    public function deleteCat(EntityManagerInterface $entityManager,$id,CategoryRepository $repo): Response
    {
        $cat=$repo->find($id);
        if(!$cat){
            throw $this->createNotFoundException('Category not found');
        }
        $entityManager->remove($cat);
        $entityManager->flush(); //Đồng bộ hóa với cơ sở dữ liệu khi xóa 1 thực thể trước đó
        return $this->redirectToRoute('show_category');
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
     * @Route("/editPDetail/{id}", name="pDetail_edit")
     */
    public function editPDetail(Request $req, $id, ProductDetailRepository $repo,
    AuthenticationUtils $authenticationUtils, CategoryRepository $repo1): Response
    {
        $proDetail = $repo->find($id);
        if(!$proDetail){
            throw $this->createNotFoundException('Product detail not found');
        }
        $catWomen = $repo1->findBy(['category_parent'=>'women']);
        $catMen = $repo1->findBy(['category_parent'=>'men']);
        $username = $authenticationUtils->getLastUsername();

        $form=$this->createForm(PDetailFormType::class,$proDetail);

        $form->handleRequest($req);
        if($form->isSubmitted()&&$form->isValid()){
            $repo->save($proDetail,true);
            return $this->redirectToRoute('productDetail_show');
        }
        return $this->render("manage/pDetailForm.html.twig",[
            'form'=>$form->createView(),
            'last_username'=>$username,
            'catMen'=>$catMen,
            'catWomen'=>$catWomen,
            'pDetail'=>$proDetail
        ]);
    }
    /**
     * @Route("/deletePDetail/{id}", name="pDetail_delete")
     */
    public function deletePDetail(EntityManagerInterface $entityManager, ProductDetailRepository $repo, $id): Response
    {
        $pd=$repo->find($id);
        if(!$pd){
            throw $this->createNotFoundException('Product Detail not found');
        }
        $entityManager->remove($pd);
        $entityManager->flush();
        return $this->redirectToRoute('productDetail_show');
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
    public function AddImage(Request $req,SluggerInterface $slugger ,ProductImageRepository $repo, CategoryRepository $repo2, AuthenticationUtils $authenticationUtils): Response
    {
        $img = new ProductImage();
        $form = $this->createForm(ImageFormType::class, $img);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $imgFile=$form->get('file')->getData();
            if($imgFile){
                $newFilename=$this->uploadImage($imgFile,$slugger);
                $img->setImage($newFilename);
            }
            $repo->save($img, true);
            return $this->redirectToRoute('image_show');
        }
        $username = $authenticationUtils->getLastUsername();
        $catWomen = $repo2->findBy(['category_parent'=>'women']);
        $catMen = $repo2->findBy(['category_parent'=>'men']);
        return $this->render('manage/imageForm.html.twig', ['last_username'=>$username, 'catMen'=>$catMen, 'catWomen'=>$catWomen, 
        'form'=>$form->createView()]);
    }

    /**
     * @Route("/editProImage/{id}", name="pImage_edit")
     */
    public function editProductImage(Request $req, AuthenticationUtils $authenticationUtils,
    ProductImageRepository $repo ,CategoryRepository $repo1, $id,SluggerInterface $slugger): Response
    {
        $pImage=$repo->find($id);
        if(!$pImage){
            throw $this->createNotFoundException('Product Image not found');
        }
    
        $catWomen = $repo1->findBy(['category_parent'=>'women']);
        $catMen = $repo1->findBy(['category_parent'=>'men']);
        $username = $authenticationUtils->getLastUsername();

        $form=$this->createForm(ImageFormType::class, $pImage);

        $form->handleRequest($req);
        if($form->isSubmitted()&&$form->isValid()){
            $imgFile=$form->get('file')->getData();
            if($imgFile){
                $newFilename=$this->uploadImage($imgFile,$slugger);
                $pImage->setImage($newFilename);
            }
            $repo->save($pImage,true);
            return $this->redirectToRoute('image_show');
        }
        return $this->render("manage/imageForm.html.twig",[
            'form'=>$form->createView(),
            'last_username'=>$username,
            'catMen'=>$catMen,
            'catWomen'=>$catWomen,
            'img'=>$pImage
        ]);
    }


/**
 * @Route("deleteImageProduct/{id}", name="productImage_delete")
 */
public function deleteImageProduct(EntityManagerInterface $entityManager, $id, ProductImageRepository $repo): Response
{   
    $pI=$repo->find($id);
    if(!$pI){
        throw $this->createNotFoundException('Product Image not found');
    }
    $entityManager->remove($pI);
    $entityManager->flush();
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


/**
 * @Route("editBrand/{id}", name="brand_edit")
 */
public function editBrand(Request $req, $id, BrandRepository $repo, CategoryRepository $repo1,
AuthenticationUtils $authenticationUtils): Response
{
    $brand=$repo->find($id);
    if(!$brand){
        throw $this->createNotFoundException('Brand not found');
    }
    $catWomen = $repo1->findBy(['category_parent'=>'women']);
    $catMen = $repo1->findBy(['category_parent'=>'men']);
    $username = $authenticationUtils->getLastUsername();

    $form=$this->createForm(BrandFormType::class, $brand);

    $form->handleRequest($req);
    if($form->isSubmitted()&&$form->isValid()){
        $repo->save($brand,true);
        return $this->redirectToRoute('brand_show');
    }
    return $this->render("manage/brandForm.html.twig",[
        'form'=>$form->createView(),
            'last_username'=>$username,
            'catMen'=>$catMen,
            'catWomen'=>$catWomen,
            'brand'=>$brand
    ]);
}

/**
 * @Route("deleteBrand/{id}", name="brand_delete")
 */
public function deleteBrand(EntityManagerInterface $entityManager, $id, BrandRepository $repo): Response
{
    $b=$repo->find($id);
    if(!$b){
        throw $this->createNotFoundException('Brand not found');
    }
    $entityManager->remove($b);
    $entityManager->flush();
    return $this->redirectToRoute('brand_show');
}
    
}

