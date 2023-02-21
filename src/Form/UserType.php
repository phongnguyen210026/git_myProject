<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('first_name', TextType::class, array(
                'required'=>true,
                'attr'=>array('placeholder'=>'Enter your first name')
            ))
            ->add('last_name', TextType::class, array(
                'required'=>true,
                'attr'=>array('placeholder'=>'Enter your last name')
            ))
            ->add('email', EmailType::class, array(
                'required'=>true,
                'attr'=>array('placeholder'=>'Enter your email')
            ))
            ->add('password', PasswordType::class, array(
                'required'=>true,
                'attr'=>array('placeholder'=>'Enter your password')
            ))
            ->add('save', SubmitType::class, ['label'=>'CREATE'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
