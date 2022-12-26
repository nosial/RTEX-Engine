<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace RTEX\Objects\Program\Instructions;

    use RTEX\Abstracts\InstructionType;
    use RTEX\Classes\InstructionBuilder;
    use RTEX\Classes\Utilities;
    use RTEX\Engine;
    use RTEX\Exceptions\EvaluationException;
    use RTEX\Exceptions\InstructionException;
    use RTEX\Exceptions\Runtime\ZeroDivisionException;
    use RTEX\Interfaces\InstructionInterface;

    class Divide implements InstructionInterface
    {
        /**
         * @var mixed
         */
        private $A;

        /**
         * @var mixed
         */
        private $B;

        /**
         * Returns the type of instruction
         *
         * @return string
         */
        public function getType(): string
        {
            return InstructionType::Divide;
        }

        /**
         * Returns an array representation of the instruction
         *
         * @return array
         */
        public function toArray(): array
        {
            return InstructionBuilder::toRaw(self::getType(), [
                'a' => $this->A,
                'b' => $this->B
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
            $instruction->setA($data['a'] ?? null);
            $instruction->setB($data['b'] ?? null);
            return $instruction;
        }

        /**
         * @param Engine $engine
         * @return int
         * @throws ZeroDivisionException
         * @throws EvaluationException
         */
        public function eval(Engine $engine): int
        {
            if ($this->B === 0)
                throw new ZeroDivisionException(sprintf('Division by zero in %s', $this));

            return (intval($engine->eval($this->A)) / intval($engine->eval($this->B)));
        }

        /**
         * Returns the string representation of the instruction
         *
         * @return string
         */
        public function __toString(): string
        {
            return sprintf(
                self::getType() . ' (%s/%s)',
                Utilities::entityToString($this->A),
                Utilities::entityToString($this->B)
            );
        }

        /**
         * Gets the value of A
         *
         * @return mixed
         */
        public function getA(): mixed
        {
            return $this->A;
        }

        /**
         * Sets the value of A
         *
         * @param mixed $A
         * @throws InstructionException
         */
        public function setA(mixed $A): void
        {
            $this->A = InstructionBuilder::fromRaw($A);
        }

        /**
         * Gets the value of B
         *
         * @return mixed
         */
        public function getB(): mixed
        {
            return $this->B;
        }

        /**
         * Sets the value of B
         *
         * @param mixed $B
         * @throws InstructionException
         */
        public function setB(mixed $B): void
        {
            $this->B = InstructionBuilder::fromRaw($B);
        }
    }