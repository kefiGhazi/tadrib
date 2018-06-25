<?php

namespace DbBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class InscritType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
                ->add('prenom')
                ->add('dateNaissance', DateType::class, array('widget' => 'single_text'))
                ->add('niveau')
                ->add('sex',ChoiceType::class, array('choices'  => array(
                                                    '1' => 'ذكر',
                                                    '2' => 'أنثى',)))
                ->add('travail')
                ->add('tel')
                ->add('email')
                ->add('adress')
                ->add('chefLastDirassa')
                ->add('lieuxLastDirassa')
                ->add('moisLastDirassa',ChoiceType::class, array('choices'  => array(
                                                    'جانفي' => 'جانفي',
                                                    'فيفري' => 'فيفري',
                                                    'مارس' => 'مارس',
                                                    'أفريل' => 'أفريل',
                                                    'ماي' => 'ماي',
                                                    'جوان' => 'جوان',
                                                    'جويلية' => 'جويلية',
                                                    'أوت' => 'أوت',
                                                    'سبتمبر' => 'سبتمبر',
                                                    'أكتوبر' => 'أكتوبر',
                                                    'نوفمبر' => 'نوفمبر',
                                                    'ديسمبر' => 'ديسمبر',
                                                    )))
                ->add('yearLastDirassa','integer')
                ->add('cin')
                ->add('numeroInscrit')
                ->add('imageCinFace',FileType::class, array('label' => 'Image (jpg file)', 'required'    => false))
                ->add('imageCinPile',FileType::class, array('label' => 'Image (jpg file)', 'required'    => false))
                ->add('fawj', null,array('required'   => false))
                ->add('wehda',null,array('required'    => false))
                ->add('idJiha', 'entity', array('class' => 'DbBundle:Jiha','property' => 'name',));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DbBundle\Entity\Inscrit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dbbundle_inscrit';
    }


}
