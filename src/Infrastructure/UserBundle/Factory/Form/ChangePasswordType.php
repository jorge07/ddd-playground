<?php

namespace Leos\Infrastructure\UserBundle\Factory\Form;


use Leos\Domain\User\Model\User;
use Leos\Infrastructure\CommonBundle\Factory\AbstractFactory;
use Leos\Infrastructure\SecurityBundle\ValueObject\EncodedPassword;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'mapped' => false
            ])
            ->add('newPassword', PasswordType::class, [
                'mapped' => false
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event){
                /** @var User $user */
                $user = $event->getData();

                $oldPassword = $event->getForm()->get('oldPassword')->getData();
                $newPassword = $event->getForm()->get('newPassword')->getData();

                $user->changePassword(
                    new EncodedPassword($oldPassword),
                    new EncodedPassword($newPassword)
                );
            })
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => false,
            'method' => AbstractFactory::UPDATE
        ]);
    }
}
