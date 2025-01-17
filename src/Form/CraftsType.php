<?php

namespace App\Form;

use App\Entity\Crafts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CraftsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('createdAt')
            ->add('picture', FileType::class, [
                'label' => 'Picture (Image file)',
                'mapped' => false,
                'required' => false,
            ])
            ->add('video', FileType::class, [
                'label' => 'Video (Video file)',
                'mapped' => false,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Crafts::class,
        ]);
    }
}
