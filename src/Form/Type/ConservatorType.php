<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

use App\Entity\Users;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConservatorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [ 'attr' => array('class' => 'form-control', 'style' => 'width:100%;' )])
            ->add('emails', TextType::class, [ 'required' => false, 'attr' => array('class' => 'form-control', 'style' => 'width:100%;' )])
            ->add('phone', TextType::class, [ 'required' => false, 'attr' => array('class' => 'form-control', 'style' => 'width:100%;' )])
            ->add('username', TextType::class, [  'attr' => array('class' => 'form-control', 'style' => 'width:100%;' )])
            ->add('pass', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Pola hasła muszą być zgodne',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => false,
                'mapped' => false,
                'first_options'  => ['label' => 'Password', 'attr' => array('class' => 'form-control', 'style' => 'width:100%;' )],
                'second_options' => ['label' => 'Repeat Password','attr' => array('class' => 'form-control', 'style' => 'width:100%;' )],
            ])
            ->add('address', TextType::class, [ 'required'=>false, 'attr' => array('class' => 'form-control', 'style' => 'width:100%;' )])
            ->add('avatar', FileType::class, [
                'attr' => array('class' => 'form-control', 'style' => 'width:100%; min-height:40px;' ),
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '8Mi'
                    ])
                ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}