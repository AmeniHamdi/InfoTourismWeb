<?php

namespace App\Form;

use App\Entity\Reclamaweb;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamawebclientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class,[
                    'label'=>'Type                                                     ',
                    'choices'  =>array(
                        'Message' => 'Message',
                        'Complaint' => 'Complaint',
                        'Commercial' => 'Commercial'),

                    'attr'=>[
                        'font-weight'=> '500',
                        'margin-bottom'=>'10px',
                        'class'=>'form-control']]
            )


            ->add('firstname', TextType::class,[
                'label'=>'FirstName',
                'attr'=>[

                    'placeholder'=>'Merci de définir le nom',
                    'class'=>'form-control']])
            ->add('lastname', TextType::class,[
                'label'=>'lastname',
                'attr'=>[
                    'placeholder'=>'Merci de définir le Prenom',
                    'class'=>'form-control']])
            ->add('email', TextType::class,[
                'label'=>'email',
                'attr'=>[
                    'placeholder'=>'Merci de définir lemail',
                    'class'=>'form-control']])
            ->add('phonenumber', TextType::class,[
                'label'=>'phonenumber',
                'attr'=>[
                    'placeholder'=>'Merci de définir le numero de portable',
                    'class'=>'form-control']])
            ->add('description', TextareaType::class,[
                'label'=>'description',
                'attr'=>[
                    'placeholder'=>'Ecrit .. !',
                    'class'=>'form-control']])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamaweb::class,
        ]);
    }
}
