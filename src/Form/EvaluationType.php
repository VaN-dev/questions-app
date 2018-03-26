<?php

namespace App\Form;

use App\Entity\Evaluation;
use App\Entity\Question;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvaluationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('candidate')
            ->add('questions', null, [
                'expanded' => true,
            ])
//            ->add('questions', EntityType::class, [
//                'class' => Question::class,
//                'mapped' => false,
//                'multiple' => true,
//                'expanded' => true,
//            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Evaluation::class,
        ));
    }
}
