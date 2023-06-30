<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Region;
use App\Entity\Departement;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Prénom',
                ],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Nom',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Email',
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'attr' => [
                    'placeholder' => 'Mot de passe',
                ],
            ])
            ->add('region', EntityType::class, [
                'label' => 'Région',
                'class' => Region::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisir une région',
                'mapped' => false,
            ])
            ->add('departement', ChoiceType::class, [
                'label' => 'Département',
                'placeholder' => 'Choisir un département',
                'choices' => [],
                'mapped' => false,
            ])
        ;

        $builder->get('region')->addEventListener(
            FormEvents::POST_SUBMIT,
            function(FormEvent $event) {
                $form = $event->getForm();
                $form->getParent()->add('departement', EntityType::class, [
                    'label' => 'Département',
                    'class' => Departement::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Choisir un département',
                    'choices' => $form->getData()->getDepartements(),
                ]);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
