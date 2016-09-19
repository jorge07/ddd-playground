<?php

namespace Leos\Infrastructure\UserBundle\Form;

use Leos\Domain\User\Model\User;
use Leos\Domain\User\ValueObject\UserId;

use Leos\Infrastructure\SecurityBundle\ValueObject\EncodedPassword;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Class RegisterType
 *
 * @package Leos\Infrastructure\UserBundle\Form
 */
class RegisterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'user.exception.email.not_blank'
                    ]),
                    new NotNull([
                        'message' => 'user.exception.null.not_null'
                    ]),
                    new Email([
                        'message' => 'user.exception.email.not_valid'
                    ])
                ]
            ])
            ->add('username', TextType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'user.exception.username.not_blank'
                    ]),
                    new NotNull([
                        'message' => 'user.exception.username.not_null'
                    ])
                ]
            ])
            ->add('password', PasswordType::class, [
                'mapped' => false
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => false,
            'empty_data' => function (FormInterface $form) {

                return new User(
                    $form->get('username')->getViewData(),
                    $form->get('email')->getViewData(),
                    new EncodedPassword($form->get('password')->getViewData())
                );
            }
        ]);
    }
}
