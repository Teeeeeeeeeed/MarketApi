<?php

namespace App\Form;

use App\Entity\Item;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Enter the Name here']
                ]
            )
            ->add('price',IntegerType::class,[
                'attr'=>[
                    'placeholder'=>'Enter Price Here'
                ]
            ])
            ->add('id',IntegerType::class,[
                'attr'=>[
                    'placeholder'=>'Enter ID here'
                ]
            ])
            ->add('description',TextareaType::class,[
                'attr'=>[
                    'placeholder'=>'Enter Description here'
                ]
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
