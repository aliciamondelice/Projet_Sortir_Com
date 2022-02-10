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
                'required' => true,
                'row_attr' => ['class' => 'field'],
                'label_attr' => ['class' => 'label'],
                'attr' => ['class' => 'input'],
            ])
            ->add('street', TextType::class, [
                'label' => 'Rue',
                'required' => true,
                'row_attr' => ['class' => 'field'],
                'label_attr' => ['class' => 'label'],
                'attr' => ['class' => 'input'],
            ])
            ->add('latitude', TextType::class, [
                'label' => 'Latitude',
                'required' => true,
                'row_attr' => ['class' => 'field'],
                'label_attr' => ['class' => 'label'],
                'attr' => ['class' => 'input'],
            ])
            ->add('longitude', TextType::class, [
                'label' => 'Longitude',
                'required' => true,
                'row_attr' => ['class' => 'field'],
                'label_attr' => ['class' => 'label'],
                'attr' => ['class' => 'input'],
            ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'label' => 'Ville',
                'required' => true,
                'row_attr' => ['class' => 'field'],
                'label_attr' => ['class' => 'label'],
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
