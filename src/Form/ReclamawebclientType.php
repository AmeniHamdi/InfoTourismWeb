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
                    'choices' =>array(
                        'Message' => 'Message',
                        'Complaint' => 'Complaint',
                        'Commercial' => 'Commercial'
                        ),
                    'attr'=>[
                        'margin-bottom'=> '18px',
                        'margin-top'=>'13px',
                        'class'=>'add_comment'
                        ]])


            ->add('firstname', TextType::class,[
                'label'=>'FirstName',
                'attr'=>[

                    'placeholder'=>'Merci de définir le nom',
                    'class'=>'add_comment']])
            ->add('lastname', TextType::class,[
                'label'=>'lastname',
                'attr'=>[
                    'placeholder'=>'Merci de définir le Prenom',
                    'class'=>'add_comment']])
            ->add('email', TextType::class,[
                'label'=>'email',
                'attr'=>[
                    'placeholder'=>'Merci de définir lemail',
                    'class'=>'field']])
            ->add('phonenumber', TextType::class,[
                'label'=>'phonenumber',
                'attr'=>[
                    'placeholder'=>'Merci de définir le numero de portable',
                    'class'=>'field']])
            ->add('description', TextareaType::class,[

                'label'=>'description',
                'attr'=>['class'=>'field',
                    'placeholder'=>'Ecrit .. !'
                    ]])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamaweb::class,
        ]);
    }
}
