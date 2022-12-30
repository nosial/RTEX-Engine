<?php

    namespace RTEX\Exceptions\Runtime;

    use RTEX\Abstracts\RuntimeExceptionCode;
    use Throwable;

    class UndefinedMethodException extends \Exception
    {
        /**
         * @param string $message
         * @param Throwable|null $previous
         */
        public function __construct(string $message = "", ?Throwable $previous = null)
        {
            parent::__construct($message, RuntimeExceptionCode::UndefinedMethodException, $previous);
        }
    }