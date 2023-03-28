<?php

namespace App\Form;

use App\Entity\Artykul;
use App\Entity\Przyjecia;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class PrzyjeciaFormType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //dump($options);
        //    exit();
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
            ->add('vat',NumberType::class)
            ->add('cenaNetto', NumberType::class)
            ->add('plik',FileType::class,[
                'mapped'   => true,
                'label'    => 'plik',
                'required' => false,
                'multiple' => true,
                'constraints' => [
                    new Count([
                        'max' => 4,
                        'maxMessage' => 'Maksymalnie 4 pliki'
                    ]),
                    new All([
                        new File([
                            'mimeTypes' => [
                                'application/pdf',
                                'application/x-pdf',
                                'application/xml',
                            ],
                            'mimeTypesMessage' => 'Nieodpowiednie rozszerzenie pliku, tylko PDF/XML',
                        ])
                    ]),
                ],
                'attr' => [
                    'accept' => '.pdf, .xml',
                    'multiple' => 'multiple'
                ],                
            ])
            // ->add('file',FileType::class,[
            //     'data_class' => null,
            //     'label' => 'Files',
            //     'multiple' => true,
            //     'mapped' => false,
            //     'required' => false
            // ])
            //->add('wprowadzil')
            //->add('magazyn')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Przyjecia::class,
            'idmagazyn' => 1
        ]);
    }
}
