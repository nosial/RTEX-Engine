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
         * @return mixed|void
         */
        public function eval(Engine $engine);

        /**
         * Returns a string representation of the instruction for debugging purposes
         * this is not the same as the array representation, and is not intended to be
         * used for serialization
         *
         * @return string
         */
        public function __toString(): string;
    }