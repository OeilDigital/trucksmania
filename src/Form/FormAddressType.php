<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;


class FormAddressType extends AbstractType
{
    const Lundi = 'Mon' ;
    const Mardi = 'Tue';
    const Mercredi = 'Wed';
    const Jeudi = 'Thu';
    const Vendredi = 'Fri';
    const Samedi = 'Sat';
    const Dimanche = 'Sun';


    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('street_number')
            ->add('street_name')
            ->add('post_code')
            ->add('city')
            ->add('additional_address')
            // ->add('days_of_presence', CheckboxType::class)
            ->add('days_of_presence', ChoiceType::class,[
                'attr' => [
                    'required' => true,
                ],
                'choices'  => [
                    'Lundi' => self::Lundi,
                    'Mardi' => self::Mardi,
                    'Mercredi' => self::Mercredi,
                    'Jeudi' => self::Jeudi,
                    'Vendredi' => self::Vendredi,
                    'Samedi' => self::Samedi,
                    'Dimanche' => self::Dimanche
                    ],
                'expanded'  => true,
                'multiple'  => true,
            ])
            // ->add('gps')
            // ->add('truck')
            // ->add('customers')
        ;

        // $formModifier = function(FormInterface $form, Address $address = null){};
        // $builder->get('days_of_presence')->AddEventListener(
        //     FormEvents::PRE_SUBMIT,
        //     function(FormEvent $event) use ($formModifier){
        //         // $days_of_presence = $event->getForm()->getData();
        //         $days_of_presence = $event->getForm()->setData(implode("-",$form.days_of_presence));
        //         dd($days_of_presence);
        //     }
        // );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
