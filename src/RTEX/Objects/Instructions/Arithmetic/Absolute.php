<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace RTEX\Objects\Instructions\Arithmetic;

    use RTEX\Abstracts\InstructionType;
    use RTEX\Classes\InstructionBuilder;
    use RTEX\Classes\Utilities;
    use RTEX\Engine;
    use RTEX\Exceptions\EvaluationException;
    use RTEX\Exceptions\InstructionException;
    use RTEX\Exceptions\Runtime\TypeException;
    use RTEX\Interfaces\InstructionInterface;

    class Absolute implements InstructionInterface
    {
        /**
         * @var mixed
         */
        private $Value;

        /**
         * Returns the type of instruction
         *
         * @return string
         */
        public function getType(): string
        {
            return InstructionType::Absolute;
        }

        /**
         * Returns an array representation of the instruction
         *
         * @return array
         */
        public function toArray(): array
        {
            return InstructionBuilder::toRaw(self::getType(), [
                'value' => $this->Value,
            ]);
        }

        /**
         * Constructs a new instance of this class from an array representation
         *
         * @param array $data
         * @return InstructionInterface
         * @throws InstructionException
         */
        public static function fromArray(array $data): InstructionInterface
        {
            $instruction = new self();
            $instruction->setValue($data['value'] ?? null);
            return $instruction;
        }

        /**
         * @param Engine $engine
         * @return int|float
         * @throws EvaluationException
         * @throws TypeException
         */
        public function eval(Engine $engine): int|float
        {
            $value = $engine->eval($this->Value);

            if(!(is_int($value) || is_float($value) || is_double($value)))
                throw new TypeException(sprintf('Cannot calculate the absolute value of a non-numeric value, got %s', Utilities::getType($value, true)));

            return abs($value);
        }

        /**
         * Returns the string representation of the instruction
         *
         * @return string
         */
        public function __toString(): string
        {
            return sprintf(
                self::getType() . ' %s',
                Utilities::entityToString($this->Value),
            );
        }

        /**
         * Gets the value of A
         *
         * @return mixed
         */
        public function getValue(): mixed
        {
            return $this->Value;
        }

        /**
         * Sets the value of A
         *
         * @param mixed $Value
         * @throws InstructionException
         */
        public function setValue(mixed $Value): void
        {
            $this->Value = InstructionBuilder::fromRaw($Value);
        }

    }