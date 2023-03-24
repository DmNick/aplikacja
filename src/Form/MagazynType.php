<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Magazyn;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MagazynType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nazwa', TextType::class)
            // ->add('domyslny', NumberType::class, [
            //     'constraints' => [
            //         new NotBlank([
            //             'message' => 'Wprowadz wartość!',
            //         ]),
            //     ],
            // ])
            ->add('users', EntityType::class, [
                //'mapped' => true,
                //'data_class' => User::class,
                // 'constraints' => [
                //     new Type(\User::class),
                // ],
                'label' => 'users',
                'class' => User::class,
                'choice_label' => 'email',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.id', 'ASC');
                },
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Magazyn::class,
        ]);
    }

}
