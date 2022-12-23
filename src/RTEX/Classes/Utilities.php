<?php

    namespace RTEX\Classes;

    use RTEX\Abstracts\InstructionType;
    use RTEX\Abstracts\VariableTypes;
    use RTEX\Exceptions\Core\MalformedInstructionException;
    use RTEX\Exceptions\Core\UnsupportedVariableType;
    use RTEX\Interfaces\InstructionInterface;
    use RTEX\Objects\Program\Instructions\GetVariable;
    use RTEX\Objects\Program\Instructions\SetVariable;

    class Utilities
    {
        /**
         * Determines the type of variable, throws an exception if the type is not supported
         *
         * @param $input
         * @return string
         * @throws UnsupportedVariableType
         */
        public static function determineType($input): string
        {
            if ($input instanceof InstructionInterface)
                return VariableTypes::Instruction;
            if (is_string($input))
                return VariableTypes::String;
            if (is_int($input))
                return VariableTypes::Integer;
            if (is_float($input))
                return VariableTypes::Float;
            if (is_bool($input))
                return VariableTypes::Boolean;
            if (is_null($input))
                return VariableTypes::Null;

            throw new UnsupportedVariableType(gettype($input));
        }

        /**
         * Returns a supported variable type to an array representation
         *
         * @param $input
         * @return array|mixed
         * @throws UnsupportedVariableType
         */
        public static function toArray($input)
        {
            return match (self::determineType($input))
            {
                VariableTypes::Instruction => $input->toArray(),
                default => $input,
            };
        }

        /**
         * Constructs an instruction from an array representation
         *
         * @param array $array
         * @return InstructionInterface
         * @throws MalformedInstructionException
         * @throws UnsupportedVariableType
         */
        public static function constructInstruction(array $array): InstructionInterface
        {
            if(!isset($array['type']))
                throw new MalformedInstructionException(sprintf('Instruction type not specified'));
            if(!isset($array['_']))
                throw new MalformedInstructionException(sprintf('Instruction data not specified'));

            switch($array['type'])
            {
                case InstructionType::GetVariable:
                    return GetVariable::fromArray($array['_']);
                case InstructionType::SetVariable:
                    return SetVariable::fromArray($array['_']);
                default:
                    throw new MalformedInstructionException(sprintf('Instruction type "%s" not supported', $array['type']));
            }
        }
    }