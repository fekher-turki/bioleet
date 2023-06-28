<?php

namespace App\Form;

use App\Entity\Experience;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'label' => 'Date',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'class' => 'form-control text-light bg-dark',
                    'placeholder' => 'Date',
                ],
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'
            ])
            ->add('place', TextType::class, [
                'label' => 'Place',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'class' => 'form-control text-light bg-dark',
                    'placeholder' => 'Place',
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('tournamentName', TextType::class, [
                'label' => 'Tournament Name',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'class' => 'form-control text-light bg-dark',
                    'placeholder' => 'Tournament Name',
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('tournamentLink', TextType::class, [
                'label' => 'Tournament Link',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'class' => 'form-control text-light bg-dark',
                    'placeholder' => 'Tournament Link',
                ],
                'required' => false
            ])
            ->add('tournamentLogo', TextType::class, [
                'label' => 'Tournament Logo',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'class' => 'form-control text-light bg-dark',
                    'placeholder' => 'Tournament Logo',
                ],
                'required' => false
            ])
            ->add('teamName', TextType::class, [
                'label' => 'Team Name',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'class' => 'form-control text-light bg-dark',
                    'placeholder' => 'Team Name',
                ],
            ])
            ->add('teamLogo', TextType::class, [
                'label' => 'Team Logo',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'class' => 'form-control text-light bg-dark',
                    'placeholder' => 'Team Logo',
                ],
                'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit',
                'attr' => [
                    'class' => 'btn btn-danger'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Experience::class,
        ]);
    }
}
