<?php

namespace App\Form;

use App\Entity\Circuit;
use App\Entity\Etape;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtapeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $circuits=$options['circuits_list'];
        $builder
            ->add('numeroEtape', IntegerType::class)
            ->add('villeEtape', TextType::class)
            ->add('nombreJours', IntegerType::class)
            ->add('circuit', ChoiceType::class, [
                'choices' => $circuits,
                'choice_label' => function($circuit,$key,$value){
                    /** @var Circuit $circuit */
                    return $circuit->getDescription();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etape::class,
        ]);
        $resolver->setRequired('circuits_list');
    }
}
