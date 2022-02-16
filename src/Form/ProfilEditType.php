<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;


class ProfilEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pictureFile',
                VichImageType::class,[
                    'label' => FALSE,
                    'allow_delete' => false ,
                    'download_label' => FALSE ,
                    'image_uri' => true,
                    'required'=>false,
                    'imagine_pattern' => '',

                ]
            )


            ->add('username',TextType::class,
                [
                    'label'=>'Pseudo : ',
                    'attr' => [
                        'class' => 'input',

                    ],

                ])
            ->add('name',TextType::class,
                [
                    'label'=>'Prénom :',
                    'attr' => [
                        'class' => 'input'
                    ],
                ])
            ->add('surname',TextType::class,
                [
                    'label'=>'Nom : ',
                    'attr' => [
                        'class' => 'input'
                    ],
                ])
            ->add('phone',TextType::class,
                [
                    'label'=> 'Téléphone : ',
                    'attr' => [
                        'class' => 'input'
                    ],
                ])
            ->add('email',TextType::class,
                [
                    'label'=> 'Email : ',
                    'attr' => [
                        'class' => 'input'
                    ],
                ])

            ->add('password',RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe doit être identique.',
                'options' => ['attr' => ['class' => 'password-field']],
                'first_options'  => [
                    'label'=> 'Mot de passe : ',
                    'attr' => [
                        'class' => 'input',
                    ]],
                'second_options' => [
                    'label'=> 'Confirmation du mot de passe : ',
                    'attr' => [
                        'class' => 'input'
                    ]

                ],
            ])


          //  ->add('Valider', submitType::class,  [ 'row_attr' => ['class' => 'button is-primary is-fullwidth mb-3'],])
        ;

    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
