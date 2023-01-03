<?php

namespace App\Form;

use App\Entity\Projets;
use App\Entity\Categorie;
use App\Entity\Technologie;
use Doctrine\DBAL\Types\JsonType;
use Doctrine\DBAL\Types\ArrayType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProjetsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',TextType::class,[])
            ->add('lien',UrlType::class,[])
            ->add('image1',FileType::class,[
                "mapped" => false
            ])
            ->add('image2',FileType::class,[
                "mapped" => false
            ])
            ->add('image3',FileType::class,[
                "mapped" => false
            ])
            ->add('description',TextareaType::class,[])
            ->add('technologies',EntityType::class,[
                "class"=> Technologie::class,
                "choice_label" => "technologie",
                "multiple" => true,
                "expanded" => true
            ])
            ->add('categorie',EntityType::class,[
                "class"=> Categorie::class,
                "choice_label" => "categorie",
                "multiple" => false,
                "expanded" => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projets::class,
        ]);
    }
}
