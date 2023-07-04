<?php

namespace App\Form;

use App\Entity\Setup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class SetupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cpu', TextType::class, [
                'label' => 'CPU',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'CPU',
                    'class' => 'form-control text-light bg-dark',
                    'minlength' => '2',
                    'maxlength' => '100'
                ],
                'required' => false,
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100]),
                ],
            ])
            ->add('gpu', TextType::class, [
                'label' => 'GPU',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'GPU',
                    'class' => 'form-control text-light bg-dark',
                    'minlength' => '2',
                    'maxlength' => '100'
                ],
                'required' => false,
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100]),
                ],
            ])
            ->add('ram', TextType::class, [
                'label' => 'RAM',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'RAM',
                    'class' => 'form-control text-light bg-dark',
                    'minlength' => '2',
                    'maxlength' => '100'
                ],
                'required' => false,
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100]),
                ],
            ])
            ->add('disk', TextType::class, [
                'label' => 'Disk',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Disk',
                    'class' => 'form-control text-light bg-dark',
                    'minlength' => '2',
                    'maxlength' => '100'
                ],
                'required' => false,
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100]),
                ],
            ])
            ->add('monitor', TextType::class, [
                'label' => 'Monitor',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Monitor',
                    'class' => 'form-control text-light bg-dark',
                    'minlength' => '2',
                    'maxlength' => '100'
                ],
                'required' => false,
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100]),
                ],
            ])
            ->add('mouse', TextType::class, [
                'label' => 'Mouse',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Mouse',
                    'class' => 'form-control text-light bg-dark',
                    'minlength' => '2',
                    'maxlength' => '100'
                ],
                'required' => false,
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100]),
                ],
            ])
            ->add('keyboard', TextType::class, [
                'label' => 'Keyboard',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Keyboard',
                    'class' => 'form-control text-light bg-dark',
                    'minlength' => '2',
                    'maxlength' => '100'
                ],
                'required' => false,
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100]),
                ],
            ])
            ->add('mousepad', TextType::class, [
                'label' => 'Mousepad',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Mousepad',
                    'class' => 'form-control text-light bg-dark',
                    'minlength' => '2',
                    'maxlength' => '100'
                ],
                'required' => false,
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100]),
                ],
            ])
            ->add('headphone', TextType::class, [
                'label' => 'Headphone',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Headphone',
                    'class' => 'form-control text-light bg-dark',
                    'minlength' => '2',
                    'maxlength' => '100'
                ],
                'required' => false,
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100]),
                ],
            ])
            ->add('microphone', TextType::class, [
                'label' => 'Microphone',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Microphone',
                    'class' => 'form-control text-light bg-dark',
                    'minlength' => '2',
                    'maxlength' => '100'
                ],
                'required' => false,
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100]),
                ],
            ])
            ->add('console', TextType::class, [
                'label' => 'Console',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Console',
                    'class' => 'form-control text-light bg-dark',
                    'minlength' => '2',
                    'maxlength' => '100'
                ],
                'required' => false,
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100]),
                ],
            ])
            ->add('controller', TextType::class, [
                'label' => 'Controller',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Controller',
                    'class' => 'form-control text-light bg-dark',
                    'minlength' => '2',
                    'maxlength' => '100'
                ],
                'required' => false,
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100]),
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
            'data_class' => Setup::class,
        ]);
    }
}
