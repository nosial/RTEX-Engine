<?php

    namespace RTEX\Exceptions\Core;

    class UnsupportedInstructionException extends \Exception
    {
        /**
         * UnsupportedInstructionException constructor.
         *
         * @param string $message
         */
        public function __construct(string $message)
        {
            parent::__construct($message);
        }
    }