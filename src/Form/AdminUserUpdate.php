<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\UserProfil;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AdminUserUpdate extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('roles', ChoiceType::class, [
            'choices'  => [
                'Utilisateur' => "ROLE_USER",
                'Coach' => "ROLE_COACH",
                'Administrateur' => "ROLE_ADMIN",                   
            ],
            'expanded' => true,
            'multiple' => true, // If you want to allow multiple role selections
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
