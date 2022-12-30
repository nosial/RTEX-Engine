<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace RTEX\Objects\Instructions\Base;

    use RTEX\Abstracts\InstructionType;
    use RTEX\Classes\InstructionBuilder;
    use RTEX\Classes\Utilities;
    use RTEX\Engine;
    use RTEX\Exceptions\EvaluationException;
    use RTEX\Exceptions\InstructionException;
    use RTEX\Exceptions\Runtime\TypeException;
    use RTEX\Interfaces\InstructionInterface;

    class SetVariable implements InstructionInterface
    {
        /**
         * The name of the variable to set
         *
         * @var mixed
         */
        private $Name;

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
         
         * @noinspection PhpUnused
         */
        public function getName(): mixed
        {
            return $this->Name;
        }

        /**
         * @param mixed $variable
         * @throws InstructionException
         * @noinspection PhpMissingParamTypeInspection
         */
        public function setName($variable): void
        {
            $this->Name = InstructionBuilder::fromRaw($variable);
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
                'name' => $this->Name,
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
            $instruction->setName($data['name'] ?? null);
            $instruction->setValue($data['value'] ?? null);

            return $instruction;
        }

        /**
         * @param Engine $engine
         * @return void
         * @throws EvaluationException
         * @throws TypeException
         */
        public function eval(Engine $engine): void
        {
            $name = $engine->eval($this->Name);
            $value = $engine->eval($this->Value);

            if(!is_string($name))
                throw new TypeException(sprintf('Variable name must be a string, %s given', Utilities::getType($name, true)));

            $engine->getEnvironment()->setRuntimeVariable($name, $value);
        }

        /**
         * @inheritDoc
         */
        public function __toString(): string
        {
            return sprintf(
                self::getType() . ' %s VALUE %s',
                Utilities::entityToString($this->Name),
                Utilities::entityToString($this->Value)
            );
        }
    }