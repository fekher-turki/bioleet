<?php

namespace App\Form;

use App\Entity\SocialMedia;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class SocialMediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('discord', TextType::class, [
                'label' => 'Discord',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Discord',
                    'class' => 'form-control text-light bg-dark',
                    'minlength' => '7',
                    'maxlength' => '37'
                ],
                'required' => false,
                'constraints' => [
                    new Assert\Length(['min' => 7, 'max' => 37]),
                ],
            ])
            ->add('facebook', UrlType::class, [
                'label' => 'Facebook',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Facebook',
                    'class' => 'form-control text-light bg-dark',
                    'pattern' => 'https://.*',
                ],
                'required' => false
            ])
            ->add('instagram', UrlType::class, [
                'label' => 'Instagram',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Instagram',
                    'class' => 'form-control text-light bg-dark'
                ],
                'required' => false
            ])
            ->add('tiktok', UrlType::class, [
                'label' => 'Tiktok',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Tiktok',
                    'class' => 'form-control text-light bg-dark'
                ],
                'required' => false
            ])
            ->add('twitter', UrlType::class, [
                'label' => 'Twitter',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Twitter',
                    'class' => 'form-control text-light bg-dark'
                ],
                'required' => false
            ])
            ->add('vk', UrlType::class, [
                'label' => 'Vk',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Vk',
                    'class' => 'form-control text-light bg-dark'
                ],
                'required' => false
            ])
            ->add('twitch', UrlType::class, [
                'label' => 'Twitch',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Twitch',
                    'class' => 'form-control text-light bg-dark'
                ],
                'required' => false
            ])
            ->add('youtube', UrlType::class, [
                'label' => 'Youtube',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Youtube',
                    'class' => 'form-control text-light bg-dark'
                ],
                'required' => false
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
            'data_class' => SocialMedia::class,
        ]);
    }
}
