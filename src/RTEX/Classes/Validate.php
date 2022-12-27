<?php

    namespace RTEX\Classes;

    use Exception;

    class Validate
    {
        /**
         * Determines if the input is a supported variable type
         *
         * @param $type
         * @return bool
         */
        public static function supportedVariableType($type): bool
        {
            try
            {
                Utilities::getType($type);
            }
            catch(Exception $e)
            {
                unset($e);
                return false;
            }

            return true;
        }

        /**
         * Validates the input with a regex pattern
         *
         * @param string $input
         * @param string $pattern
         * @return bool
         */
        public static function validateRegex(string $input, string $pattern): bool
        {
            return preg_match($pattern, $input) === 1;
        }
    }