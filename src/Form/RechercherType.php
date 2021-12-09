<?php

namespace App\Form;

use App\Entity\Rechercher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('D',TextType::class, [
                'label'=> false,
                'required'=> false,
                'attr'=> [
                    'class'=>'input',
                'placeholder'=> 'Rechercher Destination'
                    ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rechercher::class,
            'method' =>  'GET',
            'csrf_protection' => false,
            'destination' => null
        ]);
    }
}
