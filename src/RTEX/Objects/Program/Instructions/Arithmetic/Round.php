<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace RTEX\Objects\Program\Instructions\Arithmetic;

    use RTEX\Abstracts\InstructionType;
    use RTEX\Classes\InstructionBuilder;
    use RTEX\Classes\Utilities;
    use RTEX\Engine;
    use RTEX\Exceptions\EvaluationException;
    use RTEX\Exceptions\InstructionException;
    use RTEX\Exceptions\Runtime\TypeException;
    use RTEX\Interfaces\InstructionInterface;

    class Round implements InstructionInterface
    {
        /**
         * @var mixed
         */
        private $Value;

        /**
         * The number of decimal places to round to
         *
         * @var mixed
         */
        private $Precision;

        /**
         * Returns the type of instruction
         *
         * @return string
         */
        public function getType(): string
        {
            return InstructionType::Round;
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
         * @return float|int
         * @throws EvaluationException
         * @throws TypeException
         */
        public function eval(Engine $engine): int|float
        {
            $value = $engine->eval($this->Value);
            $precision = $engine->eval($this->Precision);

            if(!(is_int($value) || is_float($value) || is_double($value)))
                throw new TypeException(sprintf('Cannot calculate the round value of a non-numeric value, got %s', Utilities::getType($value, true)));

            if(is_null($precision))
                return round($value);

            if(!(is_int($precision) || is_float($precision) || is_double($precision)))
                throw new TypeException(sprintf('Cannot calculate the round value of a non-numeric precision, got %s', Utilities::getType($precision, true)));

            return round($value, $precision);
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

        /**
         * @return mixed
         * @noinspection PhpUnused
         */
        public function getPrecision(): mixed
        {
            return $this->Precision;
        }

        /**
         * @param mixed $Precision
         * @noinspection PhpUnused
         */
        public function setPrecision(mixed $Precision): void
        {
            $this->Precision = $Precision;
        }

    }