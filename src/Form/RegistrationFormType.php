<?php

namespace App\Form;

use App\Entity\Account;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('email')
            ->add('name')
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],]);

        // $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
        //             $form = $event->getForm();
        //             $password = $form->get('password')->getData();
        
        //             if (strlen($password) < 6) {
        //                 $form->get('password')->addError(new FormError('Your password should be at least 6 characters long.'));
        //             }
        //         });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Account::class,
            'constraints' => [
                new Callback(function ($data, ExecutionContextInterface $context) {
                    if (!$data['agreeTerms']) {
                        $context->buildViolation('You must agree to the terms.')->atPath('agreeTerms')->addViolation();
                    }
                }),
            ],
        ]);
    }
}
