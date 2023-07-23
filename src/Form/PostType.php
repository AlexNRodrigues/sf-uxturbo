<?php

namespace App\Form;

use App\Entity\Posts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\UX\Dropzone\Form\DropzoneType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', DropzoneType::class, [
                'attr' => [
                    'placeholder' => 'Drag and drop a file or click to browse',
                ],
            ])
            // ->add('imageFile', VichImageType::class, [
            //     'delete_label' => 'Remove file',
            //     'label' => 'Post cover',
            //     'label_attr' => [
            //         'class' => 'for-label mt-4'
            //     ],
            //     'required' => false
            // ])
            ->add('title', TextType::class, [
                'label' => 'Title',
                'constraints' => [
                    // new Assert\Length(['min' => 2, 'max' => 255]),
                    // new Assert\NotBlank()
                ]
            ])
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'Draft' => 'Draft',
                    'published' => 'Published',
                    'trash' => 'Trash',
                ],
            ])
            ->add('text', TextareaType::class, [
                'label' => 'Text',
                'constraints' => [
                    // new Assert\NotBlank()
                ]
            ])
            // ->add('publicationAt', DateType::class, [
            //     'widget' => 'choice',
            //     'input'  => 'datetime_immutable'
            // ])
            ->add('add', SubmitType::class, [
                'label' => 'Save'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
        ]);
    }
}
