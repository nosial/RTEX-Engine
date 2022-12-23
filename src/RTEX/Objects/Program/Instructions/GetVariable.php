<?php

    namespace RTEX\Objects\Program\Instructions;

    use RTEX\Abstracts\InstructionType;
    use RTEX\Classes\Utilities;
    use RTEX\Engine;
    use RTEX\Exceptions\Core\UnsupportedVariableType;
    use RTEX\Interfaces\InstructionInterface;

    class GetVariable implements InstructionInterface
    {
        /**
         * The name of the variable to select
         *
         * @var string|integer|boolean|float|null|InstructionInterface|InstructionInterface[]
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
                    'variable' => Utilities::toArray($this->Variable)
                ]
            ];
        }

        /**
         * Returns
         *
         * @return bool|float|int|InstructionInterface|string|null
         * @noinspection PhpMissingReturnTypeInspection
         */
        public function getVariable()
        {
            return $this->Variable;
        }

        /**
         * @param bool|float|int|InstructionInterface|string|null $variable
         * @throws UnsupportedVariableType
         */
        public function setVariable($variable): void
        {
            switch(Utilities::determineType($variable))
            {


                default:
                    $this->Variable = $variable;
            }
        }

        /**
         * Constructs a new GetVariable instruction from an array representation
         *
         * @throws UnsupportedVariableType
         */
        public static function fromArray(array $data): InstructionInterface
        {
            $instruction = new GetVariable();
            $instruction->setVariable($data['variable'] ?? null);
            return $instruction;
        }

        /**
         * @inheritDoc
         */
        public function eval(Engine $engine)
        {
            return $engine->getEnvironment()->getRuntimeVariable(
                $engine->eval($this->Variable)
            );
        }
    }