<?php

namespace App\Form;

use App\Entity\Cour;
use App\Entity\Notification;
use App\Entity\User;
use App\Entity\Zone;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoursPlanningType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('duration')
            ->add('disponible')
            ->add('nombrePlaceDisponible')
            ->add('calendrier', null, [
                'widget' => 'single_text',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('zone', EntityType::class, [
                'class' => Zone::class,
                'choice_label' => 'id',
            ])
            ->add('notifcation', EntityType::class, [
                'class' => Notification::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cour::class,
        ]);
    }
}
