<?php

namespace App\Form;

use App\Entity\Enigma;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnigmaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => ['class' => 'form-control']
            ])
            ->add('instruction', TextareaType::class, [
                'label' => 'Instructions',
                'required' => false,
                'attr' => ['class' => 'form-control', 'rows' => 5]
            ])
            ->add('secretCode', TextType::class, [
                'label' => 'Code secret',
                'attr' => ['class' => 'form-control']
            ])
            ->add('order', IntegerType::class, [
                'label' => 'Ordre',
                'attr' => ['class' => 'form-control', 'min' => 1]
            ])
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'label',
                'label' => 'Type d\'énigme',
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Enigma::class,
        ]);
    }
}
