<?php

namespace DbBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ChefJihaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
                ->add('prenom')
                ->add('cin')
                ->add('inscrit')
                ->add('dateNaissance', DateType::class, array('widget' => 'single_text'))
                ->add('fawej')
                ->add('etude')
                ->add('travail')
                ->add('tel')
               ->add('lastDirasa', ChoiceType::class, array('choices'  => array(
                                                    'بدون تدريب' => 'بدون تدريب',
                                                    'ابتدائية' => 'ابتدائية',
                                                    'تمهيدية' => 'تمهيدية',
                                                    'شارة خشبية' => 'شارة خشبية',
                                                    'مساعد قائد تدريب' => 'مساعد قائد تدريب',
                                                    'قائد تدريب' => 'قائد تدريب',)))
               ->add('sex', ChoiceType::class, array('choices'  => array(
                                                    '1' => 'ذكر',
                                                    '2' => 'أنثى',)))
                ->add('idKesm', 'entity', array('class' => 'DbBundle:Kesm','property' => 'nom',))
                ->add('idJiha', 'entity', array('class' => 'DbBundle:Jiha','property' => 'name',));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DbBundle\Entity\Chef'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dbbundle_chef';
    }


}
