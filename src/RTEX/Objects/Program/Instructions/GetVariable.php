<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace RTEX\Objects\Program\Instructions;

    use RTEX\Abstracts\InstructionType;
    use RTEX\Classes\InstructionBuilder;
    use RTEX\Classes\Utilities;
    use RTEX\Engine;
    use RTEX\Exceptions\Core\MalformedInstructionException;
    use RTEX\Exceptions\Core\UnsupportedVariableType;
    use RTEX\Interfaces\InstructionInterface;

    class GetVariable implements InstructionInterface
    {
        /**
         * The name of the variable to select
         *
         * @var mixed
         */
        private $Variable;

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
         * @noinspection PhpMissingReturnTypeInspection
         * @noinspection PhpUnused
         */
        public function getVariable()
        {
            return $this->Variable;
        }

        /**
         * @param mixed $variable
         * @throws MalformedInstructionException
         * @throws UnsupportedVariableType
         * @noinspection PhpMissingParamTypeInspection
         */
        public function setVariable($variable): void
        {
            $this->Variable = InstructionBuilder::fromRaw($variable);
        }

        /**
         * @inheritDoc
         * @throws UnsupportedVariableType
         */
        public function eval(Engine $engine)
        {
            return $engine->getEnvironment()->getRuntimeVariable(
                $engine->eval($this->Variable)
            );
        }

        /**
         * Returns an array representation of the object
         *
         * @return array
         * @throws UnsupportedVariableType
         */
        public function toArray(): array
        {
            return InstructionBuilder::toRaw(self::getType(), [
                'variable' => $this->Variable
            ]);
        }

        /**
         * Constructs a new GetVariable instruction from an array representation
         *
         * @param array $data
         * @return InstructionInterface
         * @throws MalformedInstructionException
         * @throws UnsupportedVariableType
         */
        public static function fromArray(array $data): InstructionInterface
        {
            $instruction = new self();
            $instruction->setVariable($data['variable'] ?? null);

            return $instruction;
        }

        /**
         * @inheritDoc
         * @throws UnsupportedVariableType
         */
        public function __toString(): string
        {
            return sprintf(
                self::getType() . ' (variable: %s)',
                Utilities::entityToString($this->Variable)
            );
        }
    }