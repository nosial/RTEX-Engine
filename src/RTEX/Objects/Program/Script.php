<?php

    namespace RTEX\Objects\Program;

    use RTEX\Classes\Utilities;
    use RTEX\Exceptions\Core\MalformedInstructionException;
    use RTEX\Exceptions\Core\UnsupportedVariableType;
    use RTEX\Interfaces\InstructionInterface;

    class Script
    {
        /**
         * An array of instructions to execute in order
         *
         * @var InstructionInterface[]
         */
        private $Instructions;

        /**
         * Public Constructor
         */
        public function __construct()
        {
            $this->Instructions = [];
        }

        /**
         * Adds an instruction to the script and returns the index of the instruction
         *
         * @param InstructionInterface $instruction
         * @return int
         */
        public function addInstruction(InstructionInterface $instruction): int
        {
            return array_push($this->Instructions, $instruction);
        }

        /**
         * Returns the instruction at the specified index
         *
         * @param int $index
         * @return InstructionInterface
         */
        public function getInstruction(int $index): InstructionInterface
        {
            return $this->Instructions[$index];
        }

        /**
         * Returns the number of instructions in the script
         *
         * @return int
         */
        public function getInstructionCount(): int
        {
            return count($this->Instructions);
        }

        /**
         * Deletes the instruction at the specified index
         *
         * @param int $index
         * @return void
         */
        public function deleteInstruction(int $index): void
        {
            unset($this->Instructions[$index]);
        }

        /**
         * Replaces the instruction at the specified index
         *
         * @param int $index
         * @param InstructionInterface $instruction
         * @return void
         */
        public function replaceInstruction(int $index, InstructionInterface $instruction): void
        {
            $this->Instructions[$index] = $instruction;
        }

        /**
         * Clears all instructions from the script
         *
         * @return void
         */
        public function clear()
        {
            $this->Instructions = [];
        }

        /**
         * Returns an array representation of the object
         *
         * @return array
         */
        public function toArray(): array
        {
            $instructions = [];
            foreach ($this->Instructions as $instruction)
            {
                $instructions[] = $instruction->toArray();
            }

            return $instructions;
        }

        /**
         * Constructs a script from an array representation
         *
         * @param array $data
         * @return Script
         * @throws MalformedInstructionException
         * @throws UnsupportedVariableType
         */
        public static function fromArray(array $data): Script
        {
            $script = new Script();

            foreach ($data as $instruction)
                $script->addInstruction(Utilities::constructInstruction($instruction));

            return $script;
        }

        /**
         * @return array|InstructionInterface[]
         */
        public function getInstructions(): array
        {
            return $this->Instructions;
        }
    }