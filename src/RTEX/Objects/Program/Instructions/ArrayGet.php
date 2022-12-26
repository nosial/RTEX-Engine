<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace RTEX\Objects\Program\Instructions;

    use RTEX\Abstracts\InstructionType;
    use RTEX\Classes\InstructionBuilder;
    use RTEX\Classes\Utilities;
    use RTEX\Engine;
    use RTEX\Exceptions\EvaluationException;
    use RTEX\Exceptions\InstructionException;
    use RTEX\Exceptions\Runtime\KeyException;
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
         * @throws InstructionException
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
         * @throws InstructionException
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
         * @throws InstructionException
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
         * @return mixed
         * @throws EvaluationException
         * @throws KeyException
         */
        public function eval(Engine $engine): mixed
        {
            $queryParts = explode('.', $engine->eval($this->Value));
            $value = $engine->getEnvironment()->getRuntimeVariable($engine->eval($this->Array));

            foreach ($queryParts as $queryPart)
            {
                if (is_array($value) && array_key_exists($queryPart, $value))
                {
                    return $value[$queryPart];
                }

                throw new KeyException(sprintf('Key "%s" does not exist in array', $queryPart));
            }

            return $value;
        }

        /**
         * @inheritDoc
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