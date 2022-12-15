<?php

namespace App\Controller;


use App\Entity\Topic;
use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TopicController extends AbstractController
{
    /**
     * @Route("/topic", name="app_topic")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $topics = $doctrine->getRepository(Topic::class)->findBy([],["id"=> "ASC"]);
        return $this->render('topic/index.html.twig', [
            'topics' => $topics
        ]);
    }

    /**
     * @Route("/topic", name="add_topic")
     * @Route("/topic/{id}/edit", name="edit_topic")
     */
    public function add(ManagerRegistry $doctrine, Topic $topic = null, Request $request) : Response 
    {

        if(!$topic) {
            $topic = new Topic();
        }

        $form = $this->createForm(TopicType::class, $topic);      
        $form->handleRequest($request);
        //si la données est "sanitize" on l'envoi
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $topic = $form->getData();
            $entityManager = $doctrine->getManager();
            //prepare
            $entityManager->persist($topic);
            //insert into
            $entityManager->flush();

            return $this->redirectToRoute('app_topic');
        }
                   
        //vue pour afficher le formulaire d'ajout ou d'edition
        //vue pour afficher le formulaire d'ajout
        return $this->render('topic/add.html.twig', [
            'formAddtopic' => $form->createView(),
            'edit' =>$topic->getId(),            
        ]);

    }

    /**
     * @Route("/topic/{id}/delete", name="delete_topic")
     */
    public function delete(ManagerRegistry $doctrine, topic $topic): Response
    {
        $id = $topic->getTopic()->getId();

        $entityManager = $doctrine->getManager();
        $entityManager->remove($topic);
        $entityManager->flush();
        // return $this->redirectToRoute('app_topic');
        // }
        return $this->redirectToRoute('show_topic', [
            'id' => $id
        ]);
    }


    /**
     * @Route("/topic/{id}", name="show_topic")
     */
    public function show(topic $topic): Response
    {
            return $this->render('topic/show.html.twig', [            
            'topic' => $topic,
        ]);
    }


}






























    

