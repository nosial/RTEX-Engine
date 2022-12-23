<?php

    namespace RTEX;

    use LogLib\Log;
    use RTEX\Abstracts\VariableTypes;
    use RTEX\Classes\Utilities;
    use RTEX\Exceptions\Core\UnsupportedVariableType;
    use RTEX\Interfaces\InstructionInterface;
    use RTEX\Objects\Environment;
    use RTEX\Objects\Program;

    class Engine
    {
        /**
         * @var Program
         */
        private $Program;

        /**
         * @var Environment
         */
        private $Environment;

        public function __construct(Program $program)
        {
            $this->Program = $program;
            $this->Environment = new Environment();
        }

        /**
         * Executes the program by running the main script of the program
         *
         * @return void
         * @throws UnsupportedVariableType
         */
        public function run()
        {
            foreach($this->Program->getMain()->getInstructions() as $instruction)
            {
                $this->eval($instruction);
            }
        }

        /**
         * Evaluates the variable or instruction and returns the result
         *
         * @param $input
         * @return mixed
         * @throws UnsupportedVariableType
         * @noinspection PhpMissingReturnTypeInspection
         */
        public function eval($input)
        {
            switch(Utilities::determineType($input))
            {
                case VariableTypes::Instruction:
                    /** @var InstructionInterface $input */
                    return $input->eval($this);

                default:
                    return $input;
            }
        }

        /**
         * @return Program
         */
        public function getProgram(): Program
        {
            return $this->Program;
        }

        /**
         * @param Program $Program
         */
        public function setProgram(Program $Program): void
        {
            $this->Program = $Program;
        }

        /**
         * @return Environment
         */
        public function getEnvironment(): Environment
        {
            return $this->Environment;
        }
    }