<?php

namespace VRag\NotifierBundle\Service;

trait ErrorsTrait
{
    protected $errors = [];

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param $errors
     * @return $this
     */
    public function addErrors($errors)
    {
        $this->errors = array_merge($this->errors, (array) $errors);

        return $this;
    }
}
