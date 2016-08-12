<?php

namespace Leos\Infrastructure\Common\Exception\Form;

use Symfony\Component\Form\FormInterface;

/**
 * Class FormException
 * @package Leos\Infrastructure\Common\Exception\Form
 */
class FormException extends \Exception
{
    /**
     * @var FormInterface
     */
    private $form;

    /**
     * FormException constructor.
     * @param FormInterface $form
     */
    public function __construct(FormInterface $form)
    {
        parent::__construct("Form Error", 0);

        $this->form = $form;
    }

    /**
     * @return FormInterface
     */
    public function getForm(): FormInterface
    {
        return $this->form;
    }
}
