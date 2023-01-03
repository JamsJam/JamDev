<?php

namespace App\Form;

use App\Entity\Technologie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TechnologieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('technologie',TextType::class,[
                "label" => false,
                "required" => false,
                "attr" => [
                    "class" => "input__text input--empty"
                ]
            ])
            // ->add('projet')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Technologie::class,
        ]);
    }
}
