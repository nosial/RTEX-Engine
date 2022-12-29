<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace RTEX\Objects\Program\Instructions;

    use RTEX\Abstracts\InstructionType;
    use RTEX\Abstracts\RegexPatterns;
    use RTEX\Classes\InstructionBuilder;
    use RTEX\Classes\Utilities;
    use RTEX\Classes\Validate;
    use RTEX\Engine;
    use RTEX\Exceptions\EvaluationException;
    use RTEX\Exceptions\InstructionException;
    use RTEX\Exceptions\Runtime\KeyException;
    use RTEX\Exceptions\Runtime\TypeException;
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
         * @noinspection PhpUnused
         */
        public function getArray(): mixed
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
         */
        public function getValue(): mixed
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
         * @throws TypeException
         */
        public function eval(Engine $engine): mixed
        {
            $value = $engine->eval($this->Value);
            $array = $engine->eval($this->Array);

            if (!is_array($array))
                throw new KeyException(sprintf('Cannot read from non-array value of type %s', Utilities::getType($array, true)));
            if(!is_string($value) && !is_int($value))
                throw new TypeException(sprintf('Cannot read from array with non-string value %s', Utilities::getType($value, true)));
            if(!Validate::validateRegex($value, RegexPatterns::ArrayQuery))
                throw new KeyException(sprintf('Cannot read from array with invalid query %s', $value));

            $keys = explode('.', $value);
            $result = $array;
            foreach ($keys as $key)
            {
                if (is_array($result) && array_key_exists($key, $result))
                {
                    $result = $result[$key];
                }
                else
                {
                    throw new KeyException(sprintf('Key "%s" does not exist in array (%s)', $key, $value));
                }
            }

            return $result;
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