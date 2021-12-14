<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,[
        'label'=>'title',
        'attr'=>[
            'placeholder'=>'Merci de définir le title',
            'class'=>'form-control']])
            ->add('description',TextareaType::class,[
                'label'=>'description',
                'attr'=>[
                    'placeholder'=>'Merci de définir le description',
                    'class'=>'form-control']])
            ->add('photo', FileType::class,[
                'data_class' => null,
                'attr'=>['placeholder'=>'Merci de définir le description',
                    'class'=>'form-control']

                ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
