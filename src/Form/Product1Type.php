<?php

// src/Form/Product1Type.php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class Product1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Product Name',
                'required' => true,
                // Use only valid options for TextType
                'attr' => ['placeholder' => 'Enter the product name'],
            ])
            ->add('price', NumberType::class, [
                'label' => 'Price',
                'required' => true,
                'scale' => 2, // This is for NumberType, not widget
                'attr' => ['placeholder' => 'Enter the Price of the Product']
            ])
            ->add('description',TextType::class,[
          'label'=>'description',
          'required'=>true,
          'attr'=>['placeholder'=>'Enter Your Description']
          
    
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
