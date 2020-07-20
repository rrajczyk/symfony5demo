<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

use App\Entity\Events;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [ 'attr' => array('class' => 'form-control', 'style' => 'width:100%;' )])
            ->add('description', null, [ 'attr' => array('class' => 'form-control', 'style' => 'width:100%; min-height:150px;' )])
            ->add('phone', TextType::class, [ 'required' => false, 'attr' => array('class' => 'form-control', 'style' => 'width:100%;' )])
            ->add('priority', null, [ 'attr' => array('class' => 'form-control', 'style' => 'width:100%; min-height:40px;' )])
            ->add('photo1', FileType::class, [
                'attr' => array('class' => 'form-control', 'style' => 'width:100%; min-height:40px;' ),
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '8Mi'
                    ])
                ]
                ])
            //->add('dueDate', DateType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Events::class,
        ]);
    }
}
