<?php

namespace DbBundle\Form;

use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TawsimsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('moisChara', ChoiceType::class, array('choices'  => $this->getMonth(), 'attr' => ['class' => 'form-control']))
                ->add('yearChara', ChoiceType::class, array('choices'  => $this->getYears(), 'attr' => ['class' => 'form-control']))
                ->add('lieuxChara', TextType::class, ['attr' => ['class' => 'form-control']])
                ->add('chefChara', TextType::class, ['attr' => ['class' => 'form-control']])
                ->add('chefUnite', ChoiceType::class, array('choices' => [true =>'نعم', false => 'لا'], 'attr' => ['class' => 'form-control']))
                ->add('uniteName', TextType::class, ['attr' => ['class' => 'form-control']])
                ->add('camping', ChoiceType::class, array('choices' => [true =>'نعم', false => 'لا'], 'attr' => ['class' => 'form-control']))
                ->add('moisCamping', ChoiceType::class, array('choices'  => $this->getMonth(), 'attr' => ['class' => 'form-control']))
                ->add('yearCamping', ChoiceType::class, array('choices'  => $this->getYears(), 'attr' => ['class' => 'form-control']))
                ->add('idJiha', 'entity', array('class' => 'DbBundle:Jiha','property' => 'name', 'attr' => ['class' => 'form-control']));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DbBundle\Entity\Tawsims'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dbbundle_tawsims';
    }

    private function getYears()
    {
        $years = [];
        $date = new DateTime();
        $curentYear = (int)$date->format("Y");
        for ($i = $curentYear ; $i >= '1900'; $i--){
            $years[$i] = $i;
        }
        return $years;
    }

    private function getMonth()
    {
        return [
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
            'ديسمبر' => 'ديسمبر'
        ];
    }
}
