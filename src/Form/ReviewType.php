<?php

namespace App\Form;


use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Traversable;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, Traversable | array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre e-mail',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            // ->add('nickname', TextType::class, [
            //     'label' => 'Votre pseudo',
            //     'attr' => [
            //         'class' => 'form-control'
            //     ]
            // ])
            ->add('content', TextType::class, [
                'label' => 'Votre commentaire',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])

            ->add('product', HiddenType::class, [
                'mapped' => false
            ])

            ->add('parent', HiddenType::class, [
                'mapped' => false
            ])
            
            ->add('rateProduct', ChoiceType::class, [
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                ],
                'attr' => [
                    'class' => 'form-select'
                ],
                'label' => 'Noter le produit',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add('send', SubmitType::class, [
                'label' =>'Envoyer',
                'attr' => [
                    'class' => 'mt-3 btn btn-primary'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
            "allow_extra_fields" => true
        ]);
    }

    public static function getExtendedTypes(): iterable
    {
        return [FormType::class];
    }
}
