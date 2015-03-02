<?php

namespace Florale\Bundle\TodolistBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TasklistType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('color', 'genemu_jquerycolor')
            ->add('tasks', 'collection', array(
                'type' => new TaskType(),
                'allow_add' => true,
                'by_reference' => false,
            ))
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
            'data_class' => 'Florale\Bundle\TodolistBundle\Entity\Tasklist'
        ));
    }
    /**
     * @return string
     */
   public function getName()
    {
        return 'tasklist';
    }
}
