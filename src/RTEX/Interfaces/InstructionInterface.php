<?php

    namespace RTEX\Interfaces;

    use RTEX\Abstracts\InstructionType;
    use RTEX\Engine;

    interface InstructionInterface
    {
        /**
         * Returns the type of instruction
         *
         * @return string
         * @see InstructionType
         */
        public function getType(): string;

        /**
         * Returns an array representation of the object
         *
         * @return array
         */
        public function toArray(): array;

        /**
         * Constructs a new instruction from an array representation
         *
         * @param array $data
         * @return InstructionInterface
         */
        public static function fromArray(array $data): InstructionInterface;

        /**
         * Evaluates the instruction and returns the result of the evaluation
         *
         * @param Engine $engine
         * @return mixed
         */
        public function eval(Engine $engine);
    }