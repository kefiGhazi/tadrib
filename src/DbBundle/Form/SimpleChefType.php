<?php

namespace DbBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SimpleChefType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('cin', TextType::class, array(
                'attr' => array('class' => 'form-control','placeholder'=>'رقم بطاقة تعريف وطنية', 'pattern'=>'[0-9]{8}'),  
                'required' => true,
            ))
                ->add('numInscrit', TextType::class, array(
                'attr' => array('class' => 'form-control','placeholder'=>'المعرف الكشفي', 'pattern'=>'[0-9]{10}'),  
                'required' => true,
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DbBundle\Entity\SimpleChef'
        ));
    }




}
