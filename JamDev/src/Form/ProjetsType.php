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
            ->add('titre',TextType::class,[
                "required" => false,
                "label" => false,
                "attr" => [
                    "placeholder" => "Entrer le titre du projet"
                ]
            ])
            ->add('lien',UrlType::class,[
                "required" => false,
                "label" => false,
                "attr" => [
                    "placeholder" => "Entrer le lien du projet"
                ]
            ])
            ->add('github',UrlType::class,[
                "required" => false,
                "label" => false,
                "attr" => [
                    "placeholder" => "Entrer le depot git associé"
                ]
            ])
            ->add('description',TextareaType::class,[
                "required" => false,
                "label" => false,
                "attr" => [
                    "placeholder" => "Décrire le projet",
                    "class" => "input__textarea input-empty "
                ]
            ])
            
            //! Image a join dans le controlleur
            
                ->add('image1',FileType::class,[
                    "mapped" => false,
                    "required" => false,
                    "attr" => [
                        "class" => "input__file",
                    ]
                ])
                ->add('image2',FileType::class,[
                    "mapped" => false,
                    "required" => false,
                    "attr" => [
                        "class" => "input__file",
                    ]
                ])
                ->add('image3',FileType::class,[
                    "mapped" => false,
                    "required" => false,
                    "attr" => [
                        "class" => "input__file",
                    ]
                ])
            //! ==============================

            ->add('technologie',EntityType::class,[
                "class"=> Technologie::class,
                // 'entry_type' => Technologie::class,
                "choice_label" => "technologie",
                "attr"=> [
                    "class" => "input__checkbox"
                ],
                "multiple" => true,
                "expanded" => true
            ])
            ->add('categorie',EntityType::class,[
                "class"=> Categorie::class,
                "choice_label" => "categorie",
                "row_attr" => [
                    "class" => "formProjet__part3"
                ],
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
