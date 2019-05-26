<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lang')
            ->add('question')
            ->add('prop1')
            ->add('prop2')
            ->add('isPropOneCorrect')
            ->add('pointToAdd')
            ->add('pointToSubIfFail')
            ->add('quiz', EntityType::class, array(
                'class' => 'AppBundle\Entity\Quiz',
                'choice_label' => 'title',

                'expanded' => true,
                'multiple' => true
            )) 
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Question'
        ));
    }
}
