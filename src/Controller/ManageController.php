<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\CategoryFormType;
use App\Form\ProductFormType;
use App\Repository\CategoryRepository;
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
    /**
     * @Route("/manage", name="show_manage")
     */
    public function manageShow(AuthenticationUtils $authenticationUtils): Response
    {
        $product = $this->repo->findAll();
        $lastUserName = $authenticationUtils->getLastUsername();
        return $this->render('manage/index.html.twig', ['last_username'=>$lastUserName, 'product'=>$product]);
    }
    /**
    * @Route("/add", name="product_insert")
    */
    public function createAction(Request $req, SluggerInterface $slugger, AuthenticationUtils $authenticationUtils): Response
    {   
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
            'last_username'=>$username
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

            if($p->getCreated()===null){
                $p->setCreated(new \DateTime());
            }
            $imgFile = $form->get('file')->getData();
            if ($imgFile) {
                $newFilename = $this->uploadImage($imgFile,$slugger);
                $p->setImage($newFilename);
            }
            $this->repo->save($p,true);
            return $this->redirectToRoute('product_show', [], Response::HTTP_SEE_OTHER);
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
        return $this->redirectToRoute('product_show', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/category", name="show_category")
     */
    public function categoryShow(AuthenticationUtils $authenticationUtils, CategoryRepository $cat_repo): Response
    {
        $cat = $cat_repo->findAll();
        $username = $authenticationUtils->getLastUsername();
        return $this->render('manage/category.html.twig', ['last_username'=>$username, 'category'=>$cat]);
    }
    /**
     * @Route("/addCat", name="category_insert")
     */
    public function FunctionName(Request $req, CategoryRepository $cat_repo, AuthenticationUtils $authenticationUtils): Response
    {
        $cat = new Category();
        $form = $this->createForm(CategoryFormType::class, $cat);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $cat_repo->save($cat, true);
            return $this->redirectToRoute('show_category');
        }
        $username = $authenticationUtils->getLastUsername();
        return $this->render('manage/catForm.html.twig', ['form'=>$form->createView(), 'last_username'=>$username]);
    }
}

