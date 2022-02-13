<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Place;
use App\Entity\Site;
use App\Entity\State;
use App\Entity\Trip;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\NotBlank;

class TripType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            /*->add('organizer', EntityType::class, [
                'class' => User::class,
                "choice_label" => "name",
                "expanded" => true,
                "label" => "Organisateur :",
                'row_attr' => ['class' => 'field'],
                'label_attr' => ['class' => 'label'],
                'attr' => ['class' => 'input'],
            ])*/
            ->add('name', TextType::class, [
                'label' => 'Nom de la sortie',
                'required' => true,
                'row_attr' => ['class' => 'field'],
                'label_attr' => ['class' => 'label'],
                'attr' => ['class' => 'input'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un nom',
                    ]),
                ],
            ])
            ->add('starting_date', DateTimeType::class, [
                'label' => 'Date et heure de la sortie',
                'required' => true,
                'row_attr' => ['class' => 'field'],
                'label_attr' => ['class' => 'label'],
                'attr' => ['class' => 'form-date'],
            ])
            ->add('ending_date', DateType::class, [
                'label' => 'Date limite d\'inscription',
                'required' => true,
                'row_attr' => ['class' => 'field'],
                'label_attr' => ['class' => 'label'],
                'attr' => ['class' => 'form-date'],
            ])
            ->add('duration', NumberType::class, [
                'label' => 'Durée (en minutes)',
                'required' => true,
                'row_attr' => ['class' => 'field'],
                'label_attr' => ['class' => 'label'],
                'attr' => ['class' => 'input'],
            ])
            ->add('max_attendees', NumberType::class, [
                'label' => 'Nombre maximum de places',
                'required' => true,
                'row_attr' => ['class' => 'field'],
                'label_attr' => ['class' => 'label'],
                'attr' => ['class' => 'input'],
            ])
            ->add('informations', TextareaType::class, [
                'label' => 'Description',
                'required' => true,
                'row_attr' => ['class' => 'field'],
                'label_attr' => ['class' => 'label'],
                'attr' => ['class' => 'textarea'],
            ])
            ->add('place', EntityType::class, [
                'class' => Place::class,
                'choice_label' => 'city',
            ])
            ->add('place', EntityType::class, [
                'class' => Place::class,
                'required' => false,
                'label' => 'Lieu',
                'choice_label' => 'name',
                'row_attr' => ['class' => 'select is-fullwidth'],
                'label_attr' => ['class' => 'is-hidden'],
                'attr' => ['class' => 'input'],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => ['class' => 'button color-text-green is-fullwidth has-text-white mb-2']
            ])
            ->add('saveAndAdd', SubmitType::class, [
                'label' => 'Publier la sortie',
                'attr' => ['class' => 'button is-success is-fullwidth mb-2']
            ]);
            /*->add('state', EntityType::class, [
                "class" => State::class,
                "choice_label" => "libelle",
                "expanded" => true,
                "label" => "Etats :"]);*/

            /*->add('site', EntityType::class, [
                "class" => Site::class,
                "choice_label" => "name",
                "expanded" => true,
                "label" => "Site :"
            ]);*/
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trip::class,
        ]);
    }
}
