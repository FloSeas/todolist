<?php

namespace Florale\Bundle\TodolistBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaskType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('dueDate')
            ->add('description')
            ->add('tasklist', 'entity', array(
                    'class' => 'TodolistBundle:Tasklist',
                    'property' => 'name',
                ))
            ->add('state', 'choice', array(
                'choices' => array(
                    0 => 'new',
                    1 => 'in progress',
                    2 => 'finished',
                    3 => 'archived'
                    
                )))
            ->add('actions', 'form_actions', [
                    'buttons' => [
                        'save' => ['type' => 'submit', 'options' => ['label' => 'button.save']],
                        'cancel' => ['type' => 'button', 'options' => ['label' => 'button.cancel']],
                    ]
                ]);    
            
    }
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Florale\Bundle\TodolistBundle\Entity\Task'
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'task';
    }
}
