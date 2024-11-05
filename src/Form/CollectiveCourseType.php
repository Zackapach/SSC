<?php

namespace App\Form;

use App\Entity\Cour;
use App\Entity\Planning;
use App\Entity\Zone;
use App\Enum\DaysOfWeekEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollectiveCourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('heureDebut', null, [
                'widget' => 'single_text',
            ])
            ->add('heureFin', null, [
                'widget' => 'single_text',
            ])
            ->add('daysOfWeek', EnumType::class, [
                'class' => DaysOfWeekEnum::class,
                'multiple' => true
            ])
            ->add('color', ColorType::class)
            ->add('cour', EntityType::class, [
                'class' => Cour::class,
                'choice_label' => 'title',
            ])
            ->add('zone', EntityType::class, [
                'class' => Zone::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Planning::class,
        ]);
    }
}
