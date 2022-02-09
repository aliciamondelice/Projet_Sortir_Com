<?php

namespace App\Form;

use App\Entity\State;
use App\Entity\Trip;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TripType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('informations')
            ->add('starting_date')
            ->add('ending_date')
            ->add('duration')
            ->add('max_attendees')
            ->add('users')
            ->add('place');

            //->add('state',
            //EntityType::class,
            //["class"=>State::class,
            //"choice_label" =>"libelle",
            //"expanded"=> true,
            //"label"=>"Etats :"])
            //;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trip::class,
        ]);
    }
}
