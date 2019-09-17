<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('falseRoles', ChoiceType::class, [
                'choices' => [
                    'Garagiste' => 'ROLE_GARAGISTE',
                    'Client' => 'ROLE_CLIENT',
                ],
                'multiple' => false,
                'expanded' => true,
                'mapped' => false,
                'label' => 'Qui êtes-vous ?'
            ])
            ->add('userName', null, [
                'label' => 'Nom  :',
                'attr' => [
                    'autofocus' => 'autofocus'
                ]
            ])
            ->add('email', null, [
                'label' => 'Adresse mail :'
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => 'Mot de passe :',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer une mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au minimum {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
