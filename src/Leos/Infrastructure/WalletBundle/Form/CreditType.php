<?php

namespace Leos\Infrastructure\WalletBundle\Form;

use Leos\Domain\Wallet\ValueObject\Credit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Class CreditType
 *
 * @package Leos\Infrastructure\WalletBundle\Form
 */
class CreditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', IntegerType::class, ['constraints' => [
                new NotBlank(),
                new NotNull(),
                new LessThan(['value' => 10001]),
            ]])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Credit::class,
            'csrf_protection' => false,
            'empty_data' => function(FormInterface $form) {

                return new Credit(
                    (int) $form->get('amount')->getData()
                );
            }
        ));
    }
}
