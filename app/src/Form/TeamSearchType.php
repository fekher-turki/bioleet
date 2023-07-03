<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class TeamSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('teamName', TextType::class, [
            'label' => 'Search..',
            'label_attr' => ['class' => 'form-label text-light'],
            'attr' => [
                'placeholder' => 'Search..',
                'class' => 'form-control text-light bg-dark',
                'minlength' => '3',
            ],
            'constraints' => [
                new Assert\Length(['min' => 3]),
            ],
            'required' => false
        ])
        ->add('country', CountryType::class, [
            'label' => 'Country',
            'label_attr' => ['class' => 'form-label text-light'],
            'placeholder' => 'Choose a country',
            'attr' => [
                'class' => 'form-select text-light bg-dark'
            ],
            'required' => false
        ])
        ->add('game', EntityType::class, [
            'class' => Game::class,
            'label' => 'Game',
            'label_attr' => ['class' => 'form-label text-light'],
            'placeholder' => 'Choose a game',
            'attr' => [
                'class' => 'form-select text-light bg-dark'
            ],
            'required' => false
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Search',
            'attr' => [
                'class' => 'btn btn-danger btn-lg'
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
