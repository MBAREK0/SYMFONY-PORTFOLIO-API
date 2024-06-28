<?php

namespace App\Form;

use App\Entity\Language;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LanguageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class'       => 'form-control relative block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm',
                    'placeholder' => 'Enter The Medium Name',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Medium Name cannot be blank']),
                ],
                'label'      => 'Name',
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
            ])
            ->add('proficiency', ChoiceType::class, [
                'choices' => [
                    'A1 (Beginner)' => 'Beginner',
                    'A2 (Elementary)' => 'Elementary',
                    'B1 (Intermediate)' => 'Intermediate',
                    'B2 (Upper-Intermediate)' => 'Upper-Intermediate',
                    'C1 (Advanced)' => 'Advanced',
                    'C2 (Proficient)' => 'Proficient',
                ],
                'attr' => [
                    'class' => 'form-control relative block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm',
                    'placeholder' => 'Select Proficiency Level',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Proficiency level cannot be blank']),
                ],
                'label' => 'Proficiency Level',
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
            ])
            ->add('submit', SubmitType::class, [
                'attr'  => ['class' => 'w-full md:w-1/2 xl:w-1/4 px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 focus:outline-none transition-colors mb-3'],
                'label' => 'Save',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Language::class,
        ]);
    }
}