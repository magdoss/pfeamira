<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            ->add('keyword')
            ->add('description')
            ->add('isActive')
            ->add('dateCreation')
            ->add('dateDebut')
            ->add('dateFin')
            ->add('price')
            ->add('type',  ChoiceType::class, [
                    'choices'  => [
                        'quiz' => 'quiz',
                        'emission' => 'emission',
                        'abonnement' => 'abonnement',
                    ]]
 
            )
            ->add('shortCode', EntityType::class, array(
                'class' => 'AppBundle\Entity\ShortCode',
                'choice_label' => 'code',
                'placeholder' => 'Please choose',
                'empty_data' => null,
                'required' => false
 
            )) 
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Service'
        ));
    }
}
