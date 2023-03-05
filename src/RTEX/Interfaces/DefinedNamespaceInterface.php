<?php

    namespace RTEX\Interfaces;

    interface DefinedNamespaceInterface
    {
        /**
         * Returns an array of available methods with their names as keys
         * and their class names as values (e.g. ['clear' => ClearMethod::class])
         *
         * @return MethodInterface[]
         */
        public static function getMethods(): array;

        /**
         * Returns the name of the namespace (e.g. 'console')
         *
         * @return string
         */
        public static function getName(): string;
    }