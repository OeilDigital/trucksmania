<?php

namespace App\Form;

use App\Entity\Truck;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class TruckRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name_truck')
            ->add('style')
            ->add('last_name')
            ->add('first_name')
            ->add('phone_number')
            ->add('siret')
        
            
            // ->add('user')
            // ->add('addresses')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Truck::class,
            'cascade_validation' => true,
        ]);
    }
}
