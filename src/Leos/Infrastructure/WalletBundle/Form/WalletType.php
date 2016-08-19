<?php

namespace Leos\Infrastructure\WalletBundle\Form;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Wallet\ValueObject\WalletId;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class WalletType
 *
 * @package Leos\Infrastructure\WalletBundle\Form
 */
class WalletType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('real', CreditType::class, [
                'max_amount' => 10001
            ])
            ->add('bonus', CreditType::class, [
                'max_amount' => 100001
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Wallet::class,
            'csrf_protection' => false,
            'empty_data' => function(FormInterface $form) {

                return new Wallet(
                    new WalletId(),
                    $form->get('real')->getData(),
                    $form->get('bonus')->getData()
                );
            }
        ));
    }
}
