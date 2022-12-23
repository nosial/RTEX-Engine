<?php

    namespace RTEX\Classes;

    use Exception;
    use RTEX\Abstracts\VariableTypes;
    use RTEX\Interfaces\InstructionInterface;

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
                Utilities::determineType($type);
            }
            catch(Exception $e)
            {
                unset($e);
                return false;
            }

            return true;
        }
    }