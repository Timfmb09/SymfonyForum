<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TopicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
            'attr' => ['class'=> 'form-control', 'placeholder'=> 'Valide']
    ])

            ->add('dateTopic', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])

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
