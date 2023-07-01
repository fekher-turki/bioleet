<?php

namespace App\Form;

use App\Entity\Team;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class EditTeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('teamName', TextType::class, [
                'label' => 'Team Name',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Team Name',
                    'class' => 'form-control text-light bg-dark',
                    'minlength' => '3',
                    'maxlength' => '50'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 3, 'max' => 30]),
                ],
            ])
            ->add('password', TextType::class, [
                'label' => 'Team Password',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Team Password',
                    'class' => 'form-control text-light bg-dark',
                    'minlength' => '3',
                    'maxlength' => '10'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 3, 'max' => 10]),
                ],
            ])
            ->add('overview', TextareaType::class, [
                'label' => 'Overview',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Overview',
                    'class' => 'form-control text-light bg-dark',
                    'style' => 'height: 200px',
                ],
                'required' => false,
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
            ->add('submit', SubmitType::class, [
                'label' => 'Update',
                'attr' => [
                    'class' => 'btn btn-danger'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
