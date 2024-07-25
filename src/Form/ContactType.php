<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'contact-form-style',
                    'placeholder' => 'Poutine'
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'contact-form-style',
                    'placeholder' => 'Vladir'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'contact-form-style',
                    'placeholder' => 'Vladounet@gmail.com'
                ]
            ])
            ->add('telephone', TelType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'contact-form-style',
                    'placeholder' => '00123456789'
                ]
            ])
            ->add('texte', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'class' => '',
                    'placeholder' => "Salut c'est vla revener en ukraine je vous atomise bande de  "
                ]
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Send',
                'attr' => [
                    'class' => '',

                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
