<?php

    namespace RTEX\Interfaces;

    use RTEX\Engine;

    interface MethodInterface
    {
        /**
         * Invokes the method with the given parameters and returns the result
         * of the invocation
         *
         * @param Engine $engine
         * @param array $parameters
         * @return mixed|void
         */
        public static function invoke(Engine $engine, array $parameters);
    }