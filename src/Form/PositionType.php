<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Position;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PositionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => "nazwa",
                ]
            )
            ->add(
                'net',
                TextType::class,
                [
                    'label' => "netto",
                ]
            )
            ->add(
                'tax',
                ChoiceType::class,
                [
                    'label' => "podatek",
                    'choices' => [
                        "0%" => 0,
                        "5%" => 5,
                        "8%" => 8,
                        "23%" => 23,
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Position::class
            ]
        );
    }
}
