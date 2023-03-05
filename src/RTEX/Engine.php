<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace RTEX;

    use Exception;
    use LogLib\Log;
    use RTEX\Exceptions\EvaluationException;
    use RTEX\Interfaces\InstructionInterface;
    use RTEX\Objects\Engine\Environment;
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
         * @throws EvaluationException
         */
        public function run(): void
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
         * @throws EvaluationException
         */
        public function eval($input): mixed
        {
            try
            {
                if($input instanceof InstructionInterface)
                {
                    Log::debug('net.nosial.rtex', $input);
                    return $input->eval($this);
                }
            }
            catch(Exception $e)
            {
                throw new EvaluationException($e->getMessage(), $e->getCode(), $e);
            }

            return $input;
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

        /**
         * Calls the method
         *
         * @param string $namespace
         * @param string $method
         * @param array $arguments
         * @return mixed
         */
        public function callMethod(string $namespace, string $method, array $arguments)
        {
            // TODO: Implement callMethod() method.
            return null;
        }
    }