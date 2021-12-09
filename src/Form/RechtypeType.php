<?php

namespace App\Form;

use App\Entity\Rechtype;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechtypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('n',TextType::class, [
        'label'=> false,
        'required'=> false,
        'attr'=> [
            'class'=>'input',
            'placeholder'=> 'Rechercher Activite'
           ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rechtype::class,
            'method' =>  'GET',
            'csrf_protection' => false,
            'activite' => null
        ]);
    }
}
