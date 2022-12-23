<?php

    namespace RTEX\Classes;

    use RTEX\Exceptions\Core\UnsupportedVariableType;
    use RTEX\Interfaces\InstructionInterface;
    use RTEX\Objects\Program\Instructions\GetVariable;
    use RTEX\Objects\Program\Instructions\SetVariable;

    class InstructionBuilder
    {
        /**
         * Constructs a new get variable instruction
         *
         * @param $name
         * @return InstructionInterface
         * @throws UnsupportedVariableType
         */
        public static function getVariable($name): InstructionInterface
        {
            $instruction = new GetVariable();
            $instruction->setVariable($name);

            return $instruction;
        }

        /**
         * Constructs a new set variable instruction
         *
         * @param $name
         * @param $value
         * @return InstructionInterface
         * @throws UnsupportedVariableType
         */
        public static function setVariable($name, $value): InstructionInterface
        {
            $instruction = new SetVariable();
            $instruction->setVariable($name);
            $instruction->setValue($value);

            return $instruction;
        }
    }