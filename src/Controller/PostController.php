<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\Persistence\ManagerRegistry;
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
        $posts = $doctrine->getRepository(Post::class)->findBy([],["id"=> "ASC"]);
        return $this->render('post/index.html.twig', [
            'posts' => 'posts'
        ]);
    }


    /**
     * @Route("/post/{id}/delete", name="delete_post")
     * @Route("/post/{id}/edit", name="edit_post")     * 
     */
    public function delete(ManagerRegistry $doctrine, Post $post): Response
    {
        $id = $post->getTopic()->getId();

        $entityManager = $doctrine->getManager();
        $entityManager->remove($post);
        $entityManager->flush();
        // return $this->redirectToRoute('app_post');
        // }
        return $this->redirectToRoute('show_topic', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/post", name="show_post")
     */
    public function show(Post $post): Response
    {
            return $this->render('post/show.html.twig', [            
            'post' => $post,
        ]);
    }




}
