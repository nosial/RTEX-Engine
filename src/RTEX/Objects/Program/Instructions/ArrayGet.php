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

    class ArrayGet implements InstructionInterface
    {
        /**
         * The array to read from
         *
         * @var mixed
         */
        private $Array;

        /**
         * The query to use to read from the array
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
            return InstructionType::ArrayGet;
        }


        /**
         * @return mixed
         * @noinspection PhpMissingReturnTypeInspection
         * @noinspection PhpUnused
         */
        public function getArray()
        {
            return $this->Array;
        }

        /**
         * @param mixed $variable
         * @throws UnsupportedVariableType
         * @throws MalformedInstructionException
         * @noinspection PhpMissingParamTypeInspection
         */
        public function setArray($variable): void
        {
            $this->Array = InstructionBuilder::fromRaw($variable);
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
                'array' => $this->Array,
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
            $instruction->setArray($data['array'] ?? null);
            $instruction->setValue($data['value'] ?? null);

            return $instruction;
        }

        /**
         * @param Engine $engine
         * @return void
         * @throws UnsupportedVariableType
         */
        public function eval(Engine $engine)
        {

            $queryParts = explode('.', $engine->eval($this->Value));
            $value = $engine->getEnvironment()->getRuntimeVariable($engine->eval($this->Array));

            foreach ($queryParts as $queryPart)
            {
                if (is_array($value) && array_key_exists($queryPart, $value))
                {
                    $value = $value[$queryPart];
                }
                else
                {
                    return null;
                }
            }

            return $value;
        }

        /**
         * @inheritDoc
         * @throws UnsupportedVariableType
         */
        public function __toString(): string
        {
            return sprintf(
                self::getType() . ' (array: %s, value: %s)',
                Utilities::entityToString($this->Array),
                Utilities::entityToString($this->Value)
            );
        }
    }