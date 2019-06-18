<?php

namespace DbBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use DbBundle\Entity\Jiha;
use DbBundle\Entity\Kesm;
use DbBundle\Entity\AtributType;
use DbBundle\Entity\MarkezTadrib;

class LinkType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('nom', TextType::class, [
                    'attr' => ['class' => 'form-control'],
                    'required' => false,
                ])
                ->add('markez', TextType::class, [
                    'attr' => ['class' => 'form-control'],
                    'required' => false,
                ])
                ->add('dateDeb', DateType::class, [
                    'widget' => 'single_text',
                    'attr' => ['class' => 'form-control daterange-single'],
                    'format' => 'yyyy-MM-dd',
                ])
                ->add('dateFin', DateType::class, [
                    'widget' => 'single_text',
                    'attr' => ['class' => 'form-control daterange-single'],
                    'format' => 'yyyy-MM-dd',
                ])
                ->add('dateDebInscrit', DateType::class, [
                    'widget' => 'single_text',
                    'attr' => ['class' => 'form-control daterange-single'],
                    'format' => 'yyyy-MM-dd',
                ])
                ->add('dateFinInscrit', DateType::class, [
                    'widget' => 'single_text',
                    'attr' => ['class' => 'form-control daterange-single'],
                    'format' => 'yyyy-MM-dd',
                ])
                ->add('jihas', EntityType::class, [
                    "label" => "link.jihas",
                    'class' => Jiha::class,
                    'multiple' => true,
                    'choice_label' => 'name',
                    'attr' => ['class' => 'form-control select2'],
                ])
                ->add('kesms', EntityType::class, [
                    "label" => "link.kesms",
                    'class' => Kesm::class,
                    'multiple' => true,
                    'choice_label' => 'nom',
                    'attr' => ['class' => 'form-control select2'],
                ])
                ->add('mostawaTadribis', EntityType::class, [
                    "label" => "link.mostawaTadribis",
                    'class' => AtributType::class,
                    'multiple' => true,
                    'choice_label' => 'nom',
                    'attr' => ['class' => 'form-control select2'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'DbBundle\Entity\Link'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'dbbundle_link';
    }

}
