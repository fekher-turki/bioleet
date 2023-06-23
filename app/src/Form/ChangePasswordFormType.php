<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
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
                        new Assert\Length([
                            'min' => 6,
                            'minMessage' => 'Your password should be at least {{ limit }} characters',
                            'max' => 100,
                        ]),
                    ]
                ],
                'second_options' => [
                    'label' => 'Repeat Password',
                    'label_attr' => [
                        'class' => 'form-label text-light'
                    ],
                    'attr' => [
                        'placeholder' => 'Repeat Password',
                        'class' => 'form-control text-light bg-dark'
                    ],
                    'constraints' => [
                        new Assert\NotBlank()
                    ]
                ],
                'invalid_message' => 'New Password not matching.'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Reset password',
                'attr' => [
                    'class' => 'btn btn-secondary'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
