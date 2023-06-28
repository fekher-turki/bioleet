<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Profile;
use App\Repository\GameRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CreateProfileType extends AbstractType
{
    private $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('game', EntityType::class, [
                'class' => Game::class,
                'query_builder' => function (GameRepository $r) {
                    $userId = $this->token->getToken()->getUser();
                                        
                    return $r->createQueryBuilder('g')
                    ->leftJoin('App\Entity\Profile', 'p', 'WITH', 'g.id = p.game AND p.user = :userId')
                    ->setParameter('userId', $userId)
                    ->where('p.game IS NULL');
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
            'data_class' => Profile::class,
        ]);
    }
}
