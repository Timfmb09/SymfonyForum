<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Topic;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('message', TextType::class, [
                'attr' => ['class'=> 'form-control', 'placeholder'=> 'Valide']
            ])

            ->add('datePost', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])

            ->add('topic', EntityType::class, [
                'class'=> Topic::class,
                'choice_label'=> 'title', 
                'placeholder' => 'Selection du topic/sujet',
                'attr' => ['class' => 'form-control']
            ])
            
            // ->add('user', EntityType::class, [
            //     'class'=> User::class,
            //     'choice_label'=> 'id', 
            //     'placeholder' => 'Selection du user',
            //     'attr' => ['class' => 'form-control']
            // ])

        
            ->add('submit', SubmitType::class, [
                'label' => 'Confirmer',
                'attr' => ['class' => 'btn']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
