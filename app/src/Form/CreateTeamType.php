<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Team;
use App\Repository\GameRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CreateTeamType extends AbstractType
{
    private $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }
    
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
                    new Assert\Length(['min' => 3, 'max' => 50]),
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
            ->add('game', EntityType::class, [
                'class' => Game::class,
                'query_builder' => function (GameRepository $r) {
                    $ownerId = $this->token->getToken()->getUser();
                                        
                    return $r->createQueryBuilder('g')
                    ->leftJoin('App\Entity\Team', 't', 'WITH', 'g.id = t.game AND t.owner = :ownerId')
                    ->setParameter('ownerId', $ownerId)
                    ->where('t.game IS NULL');
                },
                'label' => 'Game',
                'label_attr' => ['class' => 'form-label text-light'],
                'placeholder' => 'Choose a game',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'attr' => [
                    'class' => 'form-select text-light bg-dark'
                ],
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
                'label' => 'Create',
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
