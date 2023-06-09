<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, ['label' => false])
            ->add('reponses', CollectionType::class, [
                'entry_type'    => ReponseType::class,
                'entry_options' => ['label' => false],
                'allow_add'     => true,
                'by_reference'  => false,
                'label'         => false,
                'prototype'     => true,
            ])
            // ->add('image', FileType::class, [
            //     'label'         =>  'Image', 
            //     'required'      =>  false,
            //     'mapped'        =>  false,
            //     'constraints'   =>  [
            //         new File([
            //             'maxSize'   =>  '1024k',
            //             'mimeTypes' =>  [
            //                 'image/png',
            //                 'image/jpeg',
            //                 'image/jpg',
            //                 'image/gif',
            //             ],
            //             'mimeTypesMessage'  =>  'Merci de télécharger une image valide',
            //         ])
            //     ]
            // ])
            // ->add('imageFile', VichImageType::class, [
            //     'label'             => 'Illustration Vich',
		    //     'required'          => false,
        	// 	'allow_delete'      => true,
        	// 	'download_uri'      => true,
        	// 	'download_label'    => true,
        	// 	'image_uri'         => true,
        	// 	'asset_helper'      => true,
            // ])
            ->add('submit', ButtonType::class, [
                'label' => 'Ajouter une réponse',
                'attr'  => [
                    'class' => 'btn btn-primary add-reponse',
                ],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
