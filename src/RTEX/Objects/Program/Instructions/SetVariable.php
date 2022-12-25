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

    class SetVariable implements InstructionInterface
    {
        /**
         * The name of the variable to set
         *
         * @var mixed
         */
        private $Variable;

        /**
         * The value to set the variable to
         *
         * @var mixed
         */
        private $Value;

        /**
         * The name of the variable to set
         *
         * @return string
         */
        public function getType(): string
        {
            return InstructionType::SetVariable;
        }


        /**
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
         * @throws UnsupportedVariableType
         * @throws MalformedInstructionException
         * @noinspection PhpMissingParamTypeInspection
         */
        public function setVariable($variable): void
        {
            $this->Variable = InstructionBuilder::fromRaw($variable);
        }

        /**
         * @return mixed
         * @noinspection PhpMissingReturnTypeInspection
         */
        public function getValue()
        {
            return $this->Value;
        }

        /**
         * @param mixed $value
         * @throws MalformedInstructionException
         * @throws UnsupportedVariableType
         * @noinspection PhpMissingParamTypeInspection
         */
        public function setValue($value): void
        {
            $this->Value = InstructionBuilder::fromRaw($value);
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
                'variable' => $this->Variable,
                'value' => $this->Value
            ]);
        }

        /**
         * @param array $data
         * @return InstructionInterface
         * @throws MalformedInstructionException
         * @throws UnsupportedVariableType
         */
        public static function fromArray(array $data): InstructionInterface
        {
            $instruction = new self();
            $instruction->setVariable($data['variable'] ?? null);
            $instruction->setValue($data['value'] ?? null);

            return $instruction;
        }

        /**
         * @param Engine $engine
         * @return void
         * @throws UnsupportedVariableType
         */
        public function eval(Engine $engine): void
        {
            $engine->getEnvironment()->setRuntimeVariable(
                $engine->eval($this->Variable),
                $engine->eval($this->Value)
            );
        }

        /**
         * @inheritDoc
         * @throws UnsupportedVariableType
         */
        public function __toString(): string
        {
            return sprintf(
                self::getType() . ' (variable: %s, value: %s)',
                Utilities::entityToString($this->Variable),
                Utilities::entityToString($this->Value)
            );
        }
    }