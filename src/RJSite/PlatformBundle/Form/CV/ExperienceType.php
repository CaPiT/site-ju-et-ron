<?php

namespace RJSite\PlatformBundle\Form\CV;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ExperienceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('company', TextType::class, array('required' => false))
            ->add('location', TextType::class, array('required' => false))
            ->add('content', TextareaType::class)
            ->add('link', TextType::class, array('required' => false))
            ->add('start_at', DateType::class, array('required' => false))
            ->add('end_date', DateType::class, array('required' => false))
//             ->add('section')
            ->add('save', SubmitType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RJSite\PlatformBundle\Entity\CV\Experience'
        ));
    }
}
