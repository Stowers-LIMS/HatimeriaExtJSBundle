<?php

namespace Hatimeria\ExtJSBundle\Validation;

use Symfony\Component\Form\FormError;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Form\Form;

class FormResponse extends ValidationResponse
{
    private $form;
    
    /**
     * New error list
     *
     * @param mixed $mixed form or errors array
     */
    public function __construct(Form $form)
    {
        $this->form = $form;
    }
    
    public function getFormatted($errors = null)
    {
        // @todo children recursion
        $list = array();
        
        foreach($this->form->getChildren() as $field) {
            if (!$field->hasErrors()) continue;
            $messages = array();
            foreach($field->getErrors() as $error) {
                $messages[] = $error->getMessageTemplate();
            }
            
            $list[$field->getName()] = $messages;
        }
        
        return $list;
    }    
    
    public function isValid()
    {
        return $this->form->isValid();
    }
}