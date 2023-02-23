<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product_name', TextType::class, [
                'required'=>true,
                'label'=> 'Product name'
            ])
            ->add('import_date', DateType::class, [
                'widget'=>'single_text',
                'required'=>false
            ])
            ->add('description', TextareaType::class, [
                'label'=>'Description',
                'required'=>false
            ])
            ->add('file', FileType::class, [
                'label'=>'Product Image',
                'required'=>false,
                'mapped'=>false
            ])
            ->add('image', HiddenType::class, [
                'required'=> false
            ])
            ->add('save', SubmitType::class, [
                'label'=> 'Confirm'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
