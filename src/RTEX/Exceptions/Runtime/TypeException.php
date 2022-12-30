<?php

    namespace RTEX\Exceptions\Runtime;

    use RTEX\Abstracts\RuntimeExceptionCode;
    use Throwable;

    class TypeException extends \Exception
    {
        /**
         * @param string $message
         * @param Throwable|null $previous
         */
        public function __construct(string $message = "", ?Throwable $previous = null)
        {
            parent::__construct($message, RuntimeExceptionCode::TypeException, $previous);
        }
    }