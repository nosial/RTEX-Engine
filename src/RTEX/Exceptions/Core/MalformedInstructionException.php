<?php

    namespace RTEX\Exceptions\Core;

    class MalformedInstructionException extends \Exception
    {
        /**
         * MalformedInstructionException constructor.
         *
         * @param string $message
         */
        public function __construct(string $message)
        {
            parent::__construct($message);
        }
    }