<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
                'label' => 'Titulo',
                'attr' => [
                    'placeholder' => 'Titulo de la tarea',
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descripción',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Descripción breve de la tarea (opcional)',
                ]
            ])
            ->add('dueDate', DateTimeType::class, [
                'label' => 'Fecha y hora límite',
                'widget' => 'single_text', // Muestra un calendario y campo de entrada.
                'required' => false,
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Estado',
                'choices' => array_combine(
                    array_map(fn ($status) => $status->value, TaskStatusEnum::cases()), // Valores de Enum como opciones.
                    TaskStatusEnum::cases() // Usar ENUM como claves.
                ),
                'placeholder' => 'Seleccionar estado',
            ])
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
//            ->add('user', EntityType::class, [
//                'class' => User::class, // Entidad relacionada.
//                'choice_label' => 'username', // Se asume que la entidad User tiene un campo "username".
//                'label' => 'Asignado a',
//                'placeholder' => 'Seleccionar usuario',
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
