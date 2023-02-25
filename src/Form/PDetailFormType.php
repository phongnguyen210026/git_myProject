<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\ProductDetail;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PDetailFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product', EntityType::class, [
                'class'=>Product::class,
                'choice_label'=>'product_name',
                'required'=>true,
                'label'=>'Product'
            ])
            ->add('size', ChoiceType::class,array(
                'choices'=>array('XXL'=>'XXL', 'XL'=>'XL', 'L'=>'L', 'M'=>'M', 'S'=>'S'), 'multiple'=>false,
                'required'=>true,
                'label'=>'Size'
            ))
            ->add('stock', TextType::class,[
                'required'=>true,
                'label'=>'Quantity'
            ])
            ->add('status', ChoiceType::class,array(
                'choices'=>array('Available'=>1, 'Unavailable'=>0), 'multiple'=>false, 'expanded'=>true
            ))
            ->add('save', SubmitType::class, [
                'label'=>'Confirm'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductDetail::class,
        ]);
    }
}
