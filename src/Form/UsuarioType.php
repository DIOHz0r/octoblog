<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $passRequired = false;
        $usuario = $options['data'];
        $constrains = [];
        if (!$usuario || null === $usuario->getId()) {
            $builder->add('email');
            $constrains = [
                new NotBlank(
                    [
                        'message' => 'Please enter a password',
                    ]
                ),
                new Length(
                    [
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]
                ),
            ];
            $passRequired = true;
        }

        $builder
            ->add('nombre')
            ->add('apellido')
            ->add('plain_password', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'required' => $passRequired,
                'first_options'  => ['label' => 'Nueva clave'],
                'second_options' => ['label' => 'Repetir Clave'],
                'invalid_message' => 'Las claves deben coincidir.',
                'constraints' => $constrains,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
