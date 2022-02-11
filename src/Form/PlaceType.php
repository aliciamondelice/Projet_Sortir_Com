<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Place;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => false,
                'row_attr' => ['class' => 'field'],
                'label_attr' => ['class' => 'label'],
                'attr' => ['class' => 'input'],
            ])
            ->add('street', TextType::class, [
                'label' => 'Rue',
                'required' => false,
                'row_attr' => ['class' => 'field'],
                'label_attr' => ['class' => 'label'],
                'attr' => ['class' => 'input'],
            ])
            ->add('latitude', TextType::class, [
                'label' => 'Latitude',
                'required' => false,
                'row_attr' => ['class' => 'field'],
                'label_attr' => ['class' => 'label'],
                'attr' => ['class' => 'input'],
            ])
            ->add('longitude', TextType::class, [
                'label' => 'Longitude',
                'required' => false,
                'row_attr' => ['class' => 'field'],
                'label_attr' => ['class' => 'label'],
                'attr' => ['class' => 'input'],
            ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'label' => 'Ville',
                'required' => true,
                'row_attr' => ['class' => 'select is-fullwidth'],
                'label_attr' => ['class' => 'is-hidden'],
                'attr' => ['class' => 'input'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Place::class,
        ]);
    }
}
