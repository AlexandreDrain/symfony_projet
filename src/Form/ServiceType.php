<?php

namespace App\Form;

use App\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', null, [
                'label' => 'Nom de votre service'
            ])
            ->add('ImageFile', FileType::class, [
                'label' => 'Choisir une image'
            ])
            ->add('descriptionService')
            ->add('imageHoraireFile', FileType::class, [
                'label' => 'Veuillez indiqué vos horaires d\'ouverture'
            ])
            ->add('category', null, [
                'label' => 'Catégorie de votre service'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
