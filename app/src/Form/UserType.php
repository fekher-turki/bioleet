<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'First Name',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'First Name',
                    'class' => 'form-control text-light bg-dark',
                    'minlength' => '2',
                    'maxlength' => '30'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 30]),
                ],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Last Name',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Last Name',
                    'class' => 'form-control text-light bg-dark',
                    'minlength' => '2',
                    'maxlength' => '30'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 30]),
                ],
            ])
            ->add('nickname', TextType::class, [
                'label' => 'nickname',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'nickname',
                    'class' => 'form-control text-light bg-dark',
                    'minlength' => '2',
                    'maxlength' => '30'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 3, 'max' => 30]),
                ],
            ])
            ->add('country', CountryType::class, [
                'label' => 'Country',
                'label_attr' => ['class' => 'form-label text-light'],
                'placeholder' => 'Choose a country',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'attr' => [
                    'class' => 'form-select text-light bg-dark'
                ],
            ])
            ->add('languages', LanguageType::class, [
                'label' => 'Language',
                'label_attr' => ['class' => 'form-label text-light'],
                'placeholder' => 'Choose languages',
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'attr' => [
                    'class' => 'form-select text-light bg-dark selectpicker'
                ],
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Select your Gender',
                'label_attr' => ['class' => 'form-label text-light'],
                'placeholder' => 'Select your Gender',
                'choices' => [
                    'Male' => 'male',
                    'Female' => 'female',
                    'other' => 'other',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'attr' => [
                    'class' => 'form-select text-light bg-dark'
                ],
            ])
            ->add('birthday', DateType::class, [
                'label' => 'Enter your Birthday',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Enter your Birthday',
                    'max' => (new \DateTime('-16 years'))->format('Y-m-d'),
                    'class' => 'form-control text-light bg-dark'
                ],
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\LessThanOrEqual('-16 years'),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Save Changes',
                'attr' => [
                    'class' => 'btn btn-danger'
                ],
            ])
            ->add('cancel', ResetType::class, [
                'label' => 'Cancel',
                'attr' => [
                    'class' => 'btn btn-secondary'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
