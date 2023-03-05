<?php

    namespace RTEX\Classes;

    use RTEX\Abstracts\VariableType;
    use RTEX\Exceptions\Runtime\TypeException;
    use RTEX\Interfaces\InstructionInterface;

    class Utilities
    {
        /**
         * Determines the type of variable, throws an exception if the type is not supported
         *
         * @param $input
         * @param bool $return_unknown
         * @return string
         * @throws TypeException
         */
        public static function getType($input, bool $return_unknown=false): string
        {
            if ($input instanceof InstructionInterface)
                return VariableType::Instruction;
            if (is_string($input))
                return VariableType::String;
            if (is_int($input))
                return VariableType::Integer;
            if (is_float($input))
                return VariableType::Float;
            if (is_double($input))
                return VariableType::Double;
            if (is_bool($input))
                return VariableType::Boolean;
            if (is_array($input))
                return VariableType::Array;
            if (is_null($input))
                return VariableType::Null;
            if ($return_unknown)
                return VariableType::Unknown;

            throw new TypeException(gettype($input));
        }

        /**
         * Returns a supported variable type to an array representation
         * or a single value if it's not an array or an instruction
         *
         * @param $input
         * @return array|mixed
         */
        public static function toArray($input): mixed
        {
            if($input instanceof InstructionInterface)
                return $input->toArray();

            if(is_array($input))
            {
                $output = [];
                foreach($input as $key => $value)
                    $output[$key] = self::toArray($value);
                return $output;
            }

            return $input;
        }

        /**
         * Returns a string representation of a variable type
         * or an instruction type if it's an instruction
         *
         * This cannot be used as a method of serialization
         *
         * @param $input
         * @return string
         */
        public static function entityToString($input): string
        {
            /** @var InstructionInterface $input */
            if($input instanceof InstructionInterface)
                return (string)$input;

            if(is_array($input))
            {
                $output = [];
                foreach($input as $key => $value)
                    $output[$key] = self::entityToString($value);
                return json_encode($output, JSON_UNESCAPED_SLASHES);
            }

            if(is_string($input))
                return "'$input'";
            if(is_int($input))
                return 'int(' . $input . ')';
            if(is_float($input))
                return 'float(' . $input . ')';
            if(is_double($input))
                return 'double(' . $input . ')';
            if(is_bool($input))
                return $input ? 'True' : 'False';
            if(is_null($input))
                return 'NULL';

            return 'Unknown';
        }

    }