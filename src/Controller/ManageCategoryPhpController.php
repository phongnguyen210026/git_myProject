<?php

namespace App\Controller;
use App\Form\CategoryFormType;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ManageCategoryPhpController extends AbstractController
{
    private CategoryRepository $repo;
    public function __construct(CategoryRepository $repo){
        $this->repo=$repo;
    }

  
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
     * @Route("/editCat/{id}", name="category_edit", requirements={"id"="d+"})
     */
    public function editCatAction(Request $req, Category $cate, CategoryRepository $repo,AuthenticationUtils $authenticationUtils): Response
    {
        $cat = $repo->findAll();
        $catWomen = $repo->findBy(['category_parent'=>'women']);
        $catMen = $repo->findBy(['category_parent'=>'men']);
        $username = $authenticationUtils->getLastUsername();

        $form=$this->createForm(CategoryFormType::class, $cate);

        $form->handleRequest($req);
        if($form->isSubmitted()&&$form->isValid()){
            $cate->setCategoryName();
            $cate->setCategoryParent();
            $cate->setDescription();
            $this->repo->save($cate,true);
        return $this->redirectToRoute('show_category',[],Response::HTTP_SEE_OTHER);
       
        }
       return $this->render("manage/catForm.html.twig",[
            'form'=>$form->createView(),
            'last_username'=>$username,
            'catMen'=>$catMen,
            'catWomen'=>$catWomen,
            'category'=>$cat
       ]);
    }

}
