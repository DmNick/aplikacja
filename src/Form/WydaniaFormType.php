<?php

namespace App\Form;

use App\Entity\Artykul;
use App\Entity\Wydania;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class WydaniaFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('artykul', EntityType::class,[
            'label' => 'Wybierz artykuł',
            'class' => Artykul::class,
            'choice_label' => 'nazwa',
            //'attr' => ['class' => 'selectpicker'],
            'multiple' => false,
            'expanded' => false,
            'required' => true,
            'query_builder' => function (EntityRepository $er) use ($options){
                return $er->createQueryBuilder('u')
                    ->where('u.magazyn = :idmagazyn')
                    ->setParameter('idmagazyn', $options['idmagazyn'])
                    ->orderBy('u.id', 'ASC');
            },
        ])
            ->add('ilosc',NumberType::class)
            // ->add('wydal')
            // ->add('magazyn')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wydania::class,
            'idmagazyn' => 1
        ]);
    }
}
