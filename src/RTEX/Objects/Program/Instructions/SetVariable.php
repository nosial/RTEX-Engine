<?php /** @noinspection PhpReturnDocTypeMismatchInspection */

namespace RTEX\Objects\Program\Instructions;

    use RTEX\Abstracts\InstructionType;
    use RTEX\Classes\Utilities;
    use RTEX\Engine;
    use RTEX\Exceptions\Core\UnsupportedVariableType;
    use RTEX\Interfaces\InstructionInterface;

    class SetVariable implements InstructionInterface
    {
        /**
         * The name of the variable to set
         *
         * @var string|integer|boolean|float|null|InstructionInterface
         */
        private $Variable;

        /**
         * The value to set the variable to
         *
         * @var string|integer|boolean|float|null|InstructionInterface
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
         * Returns an array representation of the object
         *
         * @return array
         * @throws UnsupportedVariableType
         */
        public function toArray(): array
        {
            return [
                'type' => $this->getType(),
                '_' => [
                    'variable' => Utilities::toArray($this->Variable),
                    'value' => Utilities::toArray($this->Value)
                ]
            ];
        }

        /**
         * @inheritDoc
         */
        public static function fromArray(array $data): InstructionInterface
        {
            $instruction = new self();
            $instruction->setVariable($data['variable'] ?? null);
            $instruction->setValue($data['value'] ?? null);

            return $instruction;
        }

        /**
         * @return bool|float|int|InstructionInterface|InstructionInterface[]|string|null
         */
        public function getVariable()
        {
            return $this->Variable;
        }

        /**
         * @param bool|float|int|InstructionInterface|InstructionInterface|string|null $variable
         * @throws UnsupportedVariableType
         * @noinspection PhpMissingParamTypeInspection
         */
        public function setVariable($variable): void
        {
            Utilities::determineType($variable);
            $this->Variable = $variable;
        }

        /**
         * @return bool|float|int|InstructionInterface|InstructionInterface[]|string|null
         */
        public function getValue()
        {
            return $this->Value;
        }

        /**
         * @param bool|float|int|InstructionInterface|InstructionInterface|string|null $value
         * @throws UnsupportedVariableType
         * @noinspection PhpMissingParamTypeInspection
         */
        public function setValue($value): void
        {
            Utilities::determineType($value);
            $this->Value = $value;
        }

        /**
         * @param Engine $engine
         * @return mixed|void
         * @throws UnsupportedVariableType
         */
        public function eval(Engine $engine)
        {
            $engine->getEnvironment()->setRuntimeVariable(
                $engine->eval($this->Variable),
                $engine->eval($this->Value)
            );
        }
    }