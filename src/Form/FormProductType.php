<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FormProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product_name')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Boisson' => 'boisson',
                    'Sandwich' => 'sandwich',
                    'Kebab' => 'kebab',
                    'Spécialité' => 'spécialité',
                    'Menu' => 'menu',
                ],
            ])
            ->add('price')
            ->add('description')
            // ->add('truck')
            // ->add('orders')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
