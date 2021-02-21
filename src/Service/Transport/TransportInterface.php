<?php

namespace VRag\NotifierBundle\Service\Transport;

interface TransportInterface
{
    /**
     * @param $package
     * @param array $errors
     * @return bool
     */
    public function deliver($package, &$errors = []): bool;

    /**
     * @return array
     */
    public function getErrors(): array;
}
