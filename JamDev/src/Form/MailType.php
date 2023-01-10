<?php

namespace App\Form;

use App\Entity\Mail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Regex;

// use Symfony\Component\Validator\Constraints as Assert;

class MailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'required' => false,
                "attr" => [
                    "placeholder" => "Nom",
                    'class' => "input__text input--empty"
                ]
            ])
            ->add('prenom', TextType::class,[
                'required' => false,
                "attr" => [
                    "placeholder" => "Prénom",
                    'class' => "input__text input--empty"
                ]
            ])
            ->add('mail', EmailType::class,[
                'required' => false,
                "attr" => [
                    "placeholder" => "E-mail",
                    'class' => "input__text",
                    
                ]
            ])
            ->add('telephone', TextType::class,[
                'required'  => false,
                "mapped"   => false,
                "attr"      => [
                    "placeholder" => "n° de telephone",
                    'class' => "input__text",
                    ],
                'constraints' => [
                    new Regex([
                        'pattern'   => '^(?:(?:\+|00)(?:\d){0,3}[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$^',
                        'match'     => true,
                        'message'   => 'Veuillez entrer un numero valide',
                        ])
                    ],
            ])
            ->add('sujet', TextType::class,[
                'required' => false,
                "attr" => [
                    "placeholder" => "Sujet de votre message",
                    'class' => "input__text input--empty",
                    'spellcheck' => 'true'
                ]
            ])
            ->add('message', TextareaType::class,[
                'required' => false,
                "attr" => [
                    "placeholder" => "Entrer votre message",
                    'class' => "input__textarea input--empty",
                    'spellcheck' => 'true'
                ]
            ])
            ->add('envoyer', SubmitType::class,[
                "attr" => [
                    'class' => "bouton bouton--primary"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mail::class,
        ]);
    }
}
