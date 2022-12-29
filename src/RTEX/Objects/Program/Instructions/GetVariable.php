<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace RTEX\Objects\Program\Instructions;

    use RTEX\Abstracts\InstructionType;
    use RTEX\Classes\InstructionBuilder;
    use RTEX\Classes\Utilities;
    use RTEX\Engine;
    use RTEX\Exceptions\EvaluationException;
    use RTEX\Exceptions\InstructionException;
    use RTEX\Exceptions\Runtime\NameException;
    use RTEX\Exceptions\Runtime\TypeException;
    use RTEX\Interfaces\InstructionInterface;

    class GetVariable implements InstructionInterface
    {
        /**
         * The name of the variable to select
         *
         * @var mixed
         */
        private $VariableName;

        /**
         * Returns the type of instruction
         *
         * @return string
         * @see InstructionType
         */
        public function getType(): string
        {
            return InstructionType::GetVariable;
        }

        /**
         * Returns
         *
         * @return mixed
         * @noinspection PhpUnused
         */
        public function getVariableName(): mixed
        {
            return $this->VariableName;
        }

        /**
         * @param mixed $variable
         * @throws InstructionException
         * @noinspection PhpMissingParamTypeInspection
         */
        public function setVariableName($variable): void
        {
            $this->VariableName = InstructionBuilder::fromRaw($variable);
        }

        /**
         * @param Engine $engine
         * @return mixed
         * @throws EvaluationException
         * @throws NameException
         * @throws TypeException
         */
        public function eval(Engine $engine): mixed
        {
            $variable = $engine->eval($this->VariableName);

            if(!is_string($variable))
                throw new TypeException(sprintf('Expected string, got %s', Utilities::getType($variable)));

            if (!$engine->getEnvironment()->variableExists($variable))
                throw new NameException("Variable '$variable' is not defined");
            
            return $engine->getEnvironment()->getRuntimeVariable(
                $engine->eval($this->VariableName)
            );
        }

        /**
         * Returns an array representation of the object
         *
         * @return array
         */
        public function toArray(): array
        {
            return InstructionBuilder::toRaw(self::getType(), [
                'name' => $this->VariableName
            ]);
        }

        /**
         * Constructs a new GetVariable instruction from an array representation
         *
         * @param array $data
         * @return InstructionInterface
         * @throws InstructionException
         */
        public static function fromArray(array $data): InstructionInterface
        {
            $instruction = new self();
            $instruction->setVariableName($data['name'] ?? null);

            return $instruction;
        }

        /**
         * @inheritDoc
         */
        public function __toString(): string
        {
            return sprintf(
                self::getType() . ' (name: %s)',
                Utilities::entityToString($this->VariableName)
            );
        }
    }