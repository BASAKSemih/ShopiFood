<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Category;
use App\Entity\Menu;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('price', MoneyType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control'
                ],
                'divisor' => 100
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('category', EntityType::class, [
                'placeholder' => 'Séléctionner la catégorie du plat',
                'class' => Category::class,
                'label' => false,
                'multiple' => false,
                'choice_label' => function (Category $category) {
                        return $category->getName();
                },
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'btn btn-lg btn-primary mt-2',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
