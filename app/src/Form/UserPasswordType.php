<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Password',
                'label_attr' => [
                    'class' => 'form-label text-light'
                ],
                'attr' => [
                    'placeholder' => 'Password',
                    'class' => 'form-control text-light bg-dark'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'New Password',
                    'label_attr' => [
                        'class' => 'form-label text-light'
                    ],
                    'attr' => [
                        'placeholder' => 'New Password',
                        'class' => 'form-control text-light bg-dark'
                    ],
                    'constraints' => [
                        new Assert\NotBlank(),
                        new Assert\Length(['min' => 8]),
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirm New Password',
                    'label_attr' => [
                        'class' => 'form-label text-light'
                    ],
                    'attr' => [
                        'placeholder' => 'Confirm New Password',
                        'class' => 'form-control text-light bg-dark'
                    ],
                    'constraints' => [
                        new Assert\NotBlank()
                    ]
                ],
                'invalid_message' => 'New Password not matching.'
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
            // 'data_class' => User::class,
        ]);
    }
}
