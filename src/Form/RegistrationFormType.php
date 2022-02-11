<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username',TextType::class,array( 'label' => FALSE,
            'attr' => array(
            'placeholder' => 'Pseudo'

             )))
            ->add('name',TextType::class,array( 'label' => FALSE,
                'attr' => array(
                    'placeholder' => 'Prénom'
                )))
            ->add('surname',TextType::class,array( 'label' => FALSE,
                'attr' => array(
                    'placeholder' => 'Nom'
                )))
            ->add('phone',TextType::class,array( 'label' => FALSE,
                'attr' => array(
                    'placeholder' => 'Téléphone'
                )))
            ->add('email',TextType::class,array( 'label' => FALSE,
                'attr' => array(
                    'placeholder' => 'Email'
                )))
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'constraints' => [new Length(['min' => 8])],
                'first_options'  => ['label'  => FALSE,
                    'attr' => array(
                        'placeholder' => 'Mot de passe'
                    )],
                'second_options' => [ 'label' => FALSE,
                    'attr' => array(
                        'placeholder' => 'Retaper le mot de passe'
                    )],
            ])
            ->add('site', EntityType::class,[
                'class' => Site::class,
                'placeholder' => 'Site',
                'choice_label' => "name",


                "label"=>FALSE

            ])

       // array('required' => false)
            ->add('pictureFile',
                VichImageType::class,
                [
                    'image_uri' => true,
                    'required'=>false,
                    'label'=>FALSE,






                ]
            );

        ;
        /* ->add('plainPassword', PasswordType::class, [
              // instead of being set onto the object directly,
              // this is read and encoded in the controller
              'mapped' => false,
              'attr' => ['autocomplete' => 'new-password'],
              'constraints' => [
                  new NotBlank([
                      'message' => 'Please enter a password',
                  ]),
                  new Length([
                      'min' => 6,
                      'minMessage' => 'Your password should be at least {{ limit }} characters',
                      // max length allowed by Symfony for security reasons
                      'max' => 4096,
                  ]),
              ],
          ])

         */
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
