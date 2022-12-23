<?php

    namespace RTEX\Exceptions\Core;

    use Exception;

    class UnsupportedVariableType extends Exception
    {
        public function __construct($type)
        {
            parent::__construct("Unsupported variable type: $type");
        }
    }