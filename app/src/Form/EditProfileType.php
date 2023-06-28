<?php

namespace App\Form;

use App\Entity\GameRole;
use App\Entity\Profile;
use App\Repository\GameRoleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ingameName', TextType::class, [
                'label' => 'Ingame Name',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Ingame Name',
                    'class' => 'form-control text-light bg-dark',
                    'minlength' => '2',
                    'maxlength' => '30'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 3, 'max' => 30]),
                ],
            ])
            ->add('bio', TextareaType::class, [
                'label' => 'Bio',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Bio',
                    'class' => 'form-control text-light bg-dark',
                    'style' => 'height: 200px',
                ],
                'required' => false,
            ])
            ->add('gameRole', EntityType::class, [
                'class' => GameRole::class,
                'query_builder' => function (GameRoleRepository $r) use ($options) {
                    $profileId = $options['data']->getId();
                    $gameCode = $options['data']->getGame()->getCode();
                    return $r->createQueryBuilder('gr')
                    ->join('gr.games', 'g')
                    ->join('g.profiles', 'p')
                    ->where('p.id = :profileId')
                    ->andWhere('g.code = :gameCode')
                    ->setParameter('profileId', $profileId)
                    ->setParameter('gameCode', $gameCode);
                },
                'choice_label' => 'name',
                'multiple' => true,
                'label' => 'Game Role',
                'label_attr' => ['class' => 'form-label text-light'],
                'placeholder' => 'Choose a game role',
                'attr' => [
                    'class' => 'form-select text-light bg-dark selectpicker'
                ],
                'required' => false,
            ])
            ->add('montage', TextType::class, [
                'label' => 'Montage Video',
                'label_attr' => ['class' => 'form-label text-light'],
                'attr' => [
                    'placeholder' => 'Montage Video',
                    'class' => 'form-control text-light bg-dark'
                ],
                'required' => false,
                'constraints' => [
                    new Assert\Url(),
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Update',
                'attr' => [
                    'class' => 'btn btn-danger'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
