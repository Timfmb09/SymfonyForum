<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="app_category")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $categories = $doctrine->getRepository(Category::class)->findBy([],["id" => "ASC"]);
        return $this->render('category/index.html.twig', [            
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/category", name="add_category")
     * @Route("/category/{id}/edit", name="edit_category")
     */
    public function add(ManagerRegistry $doctrine, Category $category = null, Request $request) : Response 
    {

        if(!$category) {
            $category = new Category();
        }

        $form = $this->createForm(CategoryType::class, $category);      
        $form->handleRequest($request);
        //si la données est "sanitize" on l'envoi
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $category = $form->getData();
            $entityManager = $doctrine->getManager();
            //prepare
            $entityManager->persist($category);
            //insert into
            $entityManager->flush();

            return $this->redirectToRoute('app_category');
        }
                   
        //vue pour afficher le formulaire d'ajout ou d'edition
        //vue pour afficher le formulaire d'ajout
        return $this->render('category/add.html.twig', [
            'formAddCategory' => $form->createView(),
            'edit' =>$category->getId(),
            'formAddCategory' => $form->createView()
        ]);

    }

    /**
     * @Route("/category/{id}/delete", name="delete_category")
     */
    public function delete(ManagerRegistry $doctrine, Category $category): Response
    {
        $id = $category->getTopic()->getId();

        $entityManager = $doctrine->getManager();
        $entityManager->remove($category);
        $entityManager->flush();
        // return $this->redirectToRoute('app_category');
        // }
        return $this->redirectToRoute('show_category', [
            'id' => $id
        ]);
    }


    /**
     * @Route("/category/{id}", name="show_category")
     */
    public function show(Category $category): Response
    {
            return $this->render('category/show.html.twig', [            
            'category' => $category,
        ]);
    }


}

