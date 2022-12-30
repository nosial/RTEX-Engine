<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace RTEX\Objects\Program\Instructions\Base;

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
        private $Key;

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
         * @noinspection PhpUnused
         */
        public function getKey(): mixed
        {
            return $this->Key;
        }

        /**
         * @param mixed $value
         * @throws InstructionException
         * @noinspection PhpMissingParamTypeInspection
         */
        public function setKey($value): void
        {
            $this->Key = InstructionBuilder::fromRaw($value);
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
                'key' => $this->Key
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
            $instruction->setKey($data['key'] ?? null);

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
            $key = $engine->eval($this->Key);
            $array = $engine->eval($this->Array);

            /** @noinspection DuplicatedCode */
            if (!is_array($array))
                throw new KeyException(sprintf('Cannot read from non-array value of type %s', Utilities::getType($array, true)));
            if(!is_string($key) && !is_int($key))
                throw new TypeException(sprintf('Cannot read from array with non-string value %s', Utilities::getType($key, true)));
            if(!Validate::validateRegex($key, RegexPatterns::ArrayQuery))
                throw new KeyException(sprintf('Cannot read from array with invalid query %s', $key));

            $keys = explode('.', $key);
            $result = $array;
            foreach ($keys as $key)
            {
                if (is_array($result) && array_key_exists($key, $result))
                {
                    $result = $result[$key];
                }
                else
                {
                    throw new KeyException(sprintf('Key "%s" does not exist in array (%s)', $key, $key));
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
                self::getType() . ' %s[%s]',
                Utilities::entityToString($this->Array),
                Utilities::entityToString($this->Key)
            );
        }
    }