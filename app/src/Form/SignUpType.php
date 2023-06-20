<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class SignUpType extends AbstractType
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
            ->add('username', TextType::class, [
                'label' => 'Username',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Username',
                    'class' => 'form-control text-light bg-dark',
                    'minlength' => '2',
                    'maxlength' => '30'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 3, 'max' => 30]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Email',
                    'class' => 'form-control text-light bg-dark',
                    'minlength' => '2',
                    'maxlength' => '180'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min' => 3, 'max' => 180]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Password',
                    'label_attr' => ['class' => 'form-label text-light'],
                    'attr' => [
                        'placeholder' => 'Password',
                        'class' => 'form-control text-light bg-dark'
                    ],
                    'constraints' => [
                        new Assert\NotBlank(),
                        new Assert\Length(['min' => 8]),
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirm Password',
                    'label_attr' => ['class' => 'form-label text-light'],
                    'attr' => [
                        'placeholder' => 'Confirm Password',
                        'class' => 'form-control text-light bg-dark'
                    ],
                    'constraints' => [
                        new Assert\NotBlank(),
                        new Assert\Length(['min' => 8]),
                    ],
                ],
                'invalid_message' => 'The password fields must match.',
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Select your Gender',
                'label_attr' => ['class' => 'form-label text-light'],
                'placeholder' => 'Select your Gender',
                'choices' => [
                    'Male' => 'male',
                    'Female' => 'female',
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
                'label' => 'Sign Up',
                'attr' => [
                    'class' => 'btn btn-secondary'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
