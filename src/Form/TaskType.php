<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Validator\Constraints as Assert;
use App\Enum\TaskStatusEnum;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Task title',
                'attr' => [
                    'placeholder' => 'Task title',
                    'class' => 'block w-full mt-1 px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500',
                    'minLength' => 3,
                ],
                'row_attr' => [
                    'class' => 'mb-4 w-full flex flex-col',
                ],
                'constraints' => [
                    new Assert\Length([
                        'min' => 3,
                        'minMessage' => 'The title must be at least {{ limit }} characters long',
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Task description (optional)',
                    'rows' => 4,
                    'class' => 'block w-full mt-1 px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500',
                ],
                'row_attr' => [
                    'class' => 'mb-4 w-full flex flex-col',
                ],
            ])
            ->add('dueDate', DateTimeType::class, [
                'label' => 'Deadline',
                'widget' => 'single_text',
                'required' => false,
                'attr' => [
                    'class' => 'block w-full mt-1 px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500',
                ],
                'row_attr' => [
                    'class' => 'mb-4 w-full flex flex-col',
                ],
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Status',
                'choices' => array_combine(
                    array_map(fn ($status) => $status->value, TaskStatusEnum::cases()),
                    TaskStatusEnum::cases()
                ),
                'placeholder' => 'Select status',
                'attr' => [
                    'class' => 'block w-full mt-1 px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500',
                ],
                'row_attr' => [
                    'class' => 'mb-4 w-full flex flex-col',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
