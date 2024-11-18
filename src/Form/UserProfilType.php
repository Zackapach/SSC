<?php

namespace App\Form;

use App\Entity\UserProfil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class UserProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', null, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter your first name',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'First name is required']),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'First name must be at least {{ limit }} characters long',
                        'max' => 50,
                        'maxMessage' => 'First name cannot be longer than {{ limit }} characters',
                    ]),
                ],
            ])
            ->add('lastName', null, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter your last name',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Last name is required']),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Last name must be at least {{ limit }} characters long',
                        'max' => 50,
                        'maxMessage' => 'Last name cannot be longer than {{ limit }} characters',
                    ]),
                ],
            ])
            ->add('phone', null, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter your phone number',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Phone number is required']),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Phone number must be at least {{ limit }} digits',
                        'max' => 15,
                        'maxMessage' => 'Phone number cannot be longer than {{ limit }} digits',
                    ]),
                ],
            ])
            ->add('adress', null, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter your address',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Address is required']),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Address must be at least {{ limit }} characters long',
                        'max' => 255,
                        'maxMessage' => 'Address cannot be longer than {{ limit }} characters',
                    ]),
                ],
            ])
            ->add('dateOfBirth', null, [
                'label' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Select your date of birth',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Date of birth is required']),
                ],
            ])
            ->add('bio', null, [
                'label' => false,
                'attr' => [
                    'class' => 'textarea',
                    'placeholder' => 'Write something about yourself',
                ],
                'constraints' => [
                    new Length([
                        'max' => 500,
                        'maxMessage' => 'Bio cannot be longer than {{ limit }} characters',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserProfil::class,
        ]);
    }
}
