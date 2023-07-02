<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, [
                'label' => 'Full Name',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Full Name',
                    'class' => 'form-control text-light bg-dark',
                    'minlength' => '2',
                    'maxlength' => '60'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 3, 'max' => 60]),
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
                    new Assert\NotBlank()
                ],
            ])
            ->add('subject', TextType::class, [
                'label' => 'Subject',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Subject',
                    'class' => 'form-control text-light bg-dark',
                    'minlength' => '4',
                    'maxlength' => '255'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 4, 'max' => 255]),
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Message',
                    'class' => 'form-control text-light bg-dark',
                    'style' => 'height: 200px',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit',
                'attr' => [
                    'class' => 'btn btn-orange btn-lg'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
