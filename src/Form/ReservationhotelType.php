<?php

namespace App\Form;

use App\Entity\Reservationhotel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationhotelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('datedeb')
            ->add('datefin')
            ->add('nbrplace', ChoiceType::class, array('choices' => [1, 2, 3, 4, 5]))
            ->add('prix', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservationhotel::class,
        ]);
    }
}
