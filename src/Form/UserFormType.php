<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, ['attr' => array('class' => 'form-control')])
            ->add('password', PasswordType::class, ['attr' => array('class' => 'form-control')])
            ->add('role',EntityType::class, [
                    'class' => Role::class,
                    'attr' => array('class' => 'form-select mb-3')])
            ->add('userApp')
            ->add('isVerified', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Zweryfikowany' => '1',
                    'Niezweryfikowany' => '0',
                ],
                'attr' => array('class' => 'form-select mb-3')])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
