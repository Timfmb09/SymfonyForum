<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="app_post")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $posts = $doctrine->getRepository(Post::class)->findBy([],["id"=> "DESC"]);
        return $this->render('post/index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/post/add", name="add_post")
     * @Route("/post/{id}/edit", name="edit_post")
     */
    public function add(ManagerRegistry $doctrine, Post $post = null, Request $request) : Response 
    {

        if(!$post) {
            $post = new Post();
        }

        $form = $this->createForm(PostType::class, $post);      
        $form->handleRequest($request);
        //si la données est "sanitize" on l'envoi
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $post = $form->getData();          
            $entityManager = $doctrine->getManager();
            //prepare
            $entityManager->persist($post);
            //insert into
            $entityManager->flush();

            return $this->redirectToRoute('app_post');
        }
                   
        //vue pour afficher le formulaire d'ajout ou d'edition
        //vue pour afficher le formulaire d'ajout
        return $this->render('post/add.html.twig', [
            'formAddPost' => $form->createView(),
            'edit' =>$post->getId(),
            
        ]);

    }


    /**
     * @Route("/post/{id}/delete", name="delete_post")
     */
    public function delete(ManagerRegistry $doctrine, Post $post): Response
    {
        $firstPost = $post->getTopic()->getPost() [0]->getId();
        if($post->getMember()->getId() ==$this->getUser()->getId() && $firstPost !=$post->getId())
    
       {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($post);
        $entityManager->flush();
       }

        $id = $post->getTopic()->getId();
        return $this->redirectToRoute('show_topic', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/post/{id}", name="show_post")
     */
    public function show(Post $post): Response
    {
            return $this->render('post/show.html.twig', [            
            'post' => $post,
           
        ]);
    }




}
