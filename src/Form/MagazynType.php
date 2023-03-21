<?php

namespace App\Form;

use App\Entity\Magazyn;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MagazynType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nazwa')
            ->add('domyslny', NumberType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Wprowadz wartość!',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Magazyn::class,
        ]);
    }
}
