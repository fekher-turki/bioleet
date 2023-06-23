<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ResetPasswordRequestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Email',
                    'class' => 'form-control text-light bg-dark',
                    'minlength' => '2',
                    'maxlength' => '180',
                    'autocomplete' => 'email'
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Please enter your email',
                    ]),
                ],
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
