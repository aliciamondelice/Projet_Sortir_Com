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
            ->add('username',TextType::class,
                ['label' => FALSE,
                'attr' => ['placeholder' => 'Pseudo',
                    'class' => 'input'
                ],
             ])
            ->add('name',TextType::class,
                ['label' => FALSE,
                'attr' => ['placeholder' => 'Prenom',
                    'class' => 'input'
                ],
            ])
            ->add('surname',TextType::class,
                ['label' => FALSE,
                    'attr' => ['placeholder' => 'nom',
                        'class' => 'input'
                    ],
                ])
            ->add('phone',TextType::class,
                ['label' => FALSE,
                    'attr' => ['placeholder' => 'Téléphone',
                        'class' => 'input'
                    ],
                ])
            ->add('email',TextType::class,
                ['label' => FALSE,
                    'attr' => ['placeholder' => 'Email',
                        'class' => 'input'
                    ],
                ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe doit être identique.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => [
                    'label'=>false,
                    'attr' => ['placeholder' => 'Mot de passe',
                        'class' => 'input',
                    ]],
                'second_options' => [
                    'label'=>false,
                    'attr' => ['placeholder' => 'Confirmer votre mot de passe',
                        'class' => 'input'
                    ]

                ],
            ])


            ->add('site', EntityType::class,[
                'class' => Site::class,
                'placeholder' => 'Site',
                'choice_label' => "name",
                'row_attr' => ['class' => 'select is-fullwidth'],
                'label_attr' => ['class' => 'is-hidden'],
                'attr' => ['class' => 'input'],
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
