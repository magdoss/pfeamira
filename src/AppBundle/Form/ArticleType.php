<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('jsonConfig', TextareaType::class)
            ->add('libelle')
            ->add('keyword')
            ->add('description')
            ->add('isActive')
            ->add('dateCreation')
            ->add('dateDebut')
            ->add('dateFin')
            ->add('price')
            ->add('shortCode', EntityType::class, array(
                'class' => 'AppBundle\Entity\ShortCode',
                'choice_label' => 'code',
                'placeholder' => 'Please choose',
                'empty_data' => null,
                'required' => false

            ))
            ->add('files', FileType::class, array(
                'multiple' => true,
                'required' => false
            ));
//        $builder->get('jsonConfig')->addModelTransformer(new CallbackTransformer(
//            function ($jsonConfig) {
////                dump($jsonConfig);die;
//                // transform the array to a string
//                return json_decode($jsonConfig,true);
//            }, function ($jsonConfig) {
//            // transform the array to a string
//            return json_encode($jsonConfig);
//        }));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Article'
        ));
    }
}
