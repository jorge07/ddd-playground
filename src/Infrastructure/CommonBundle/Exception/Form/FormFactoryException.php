<?php

namespace Leos\Infrastructure\CommonBundle\Exception\Form;

/**
 * Class FormFactoryException
 *
 * @package Leos\Infrastructure\CommonBundle\Exception\Form
 */
class FormFactoryException extends \LogicException
{
    /**
     * FormFactoryException constructor.
     */
    public function __construct()
    {
        parent::__construct("form.factory.exception.form_class_required", 5005);
    }
}
