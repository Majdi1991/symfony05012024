<?php
// src/Form/ReservationFormType.php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\SportActivity; 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ReservationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('activity', EntityType::class, [
                'class' => SportActivity::class,
                'choice_label' => 'name', // Assuming 'name' is the field to display
            ])
            ->add('reservationDateTime')
            // Add other fields if necessary
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
