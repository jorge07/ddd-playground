<?php

namespace Leos\Infrastructure\CommonBundle\Exception\Form;

use Symfony\Component\Form\FormInterface;

class FormException extends \Exception
{
    /**
     * @var FormInterface
     */
    private $form;

    public function __construct(FormInterface $form)
    {
        parent::__construct("Form Error", 0);

        $this->form = $form;
    }

    public function getForm(): FormInterface
    {
        return $this->form;
    }
}
