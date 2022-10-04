<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Invoice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'buyer',
                TextType::class,
                [
                    'label' => "nabywca",
                ]
            )
            ->add(
                'supplier',
                TextType::class,
                [
                    'label' => "dostawca"
                ]
            )
            ->add(
                'currency',
                ChoiceType::class,
                [
                    'label' => "waluta",
                    'choices' => [
                        "PLN" => "PLN",
                        "EUR" => "EUR",
                        "USD" => "USD",
                    ],
                ]

            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Invoice::class,
            ]
        );
    }
}
