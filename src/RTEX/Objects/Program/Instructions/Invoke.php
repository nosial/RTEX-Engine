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

    class Invoke implements InstructionInterface
    {
        /**
         * The namespace of the method to invoke
         *
         * @var string
         */
        private $Namespace;

        /**
         * The name of the method to invoke
         *
         * @var string
         */
        private $Method;

        /**
         * The parameters to pass to the method
         *
         * @var array
         */
        private $Parameters;

        /**
         * If the execution should be stopped after the method has raised an exception
         *
         * @var bool
         */
        private $FailOnError;

        /**
         * Returns the type of instruction
         *
         * @return string
         */
        public function getType(): string
        {
            return InstructionType::Invoke;
        }

        public function __construct()
        {
            $this->Parameters = [];
            $this->FailOnError = false;
        }

        /**
         * @return array
         * @throws UnsupportedVariableType
         */
        public function toArray(): array
        {
            return InstructionBuilder::toRaw(self::getType(), [
                'namespace' => $this->Namespace,
                'method' => $this->Method,
                'parameters' => $this->Parameters,
                'fail_on_error' => $this->FailOnError,
            ]);
        }

        /**
         * Constructs an instruction from an array
         *
         * @param array $data
         * @return InstructionInterface
         * @throws MalformedInstructionException
         * @throws UnsupportedVariableType
         */
        public static function fromArray(array $data): InstructionInterface
        {
            $instruction = new self();
            $instruction->setNamespace($data['namespace'] ?? null);
            $instruction->setMethod($data['method'] ?? null);
            $instruction->setParameters($data['parameters'] ?? []);
            $instruction->setFailOnError($data['fail_on_error'] ?? false);

            return $instruction;
        }

        /**
         * Invokes the method and returns the result
         *
         * @param Engine $engine
         * @return mixed
         * @throws UnsupportedVariableType
         * @noinspection PhpMissingReturnTypeInspection
         */
        public function eval(Engine $engine)
        {
            $parameters = [];
            foreach($this->Parameters as $key => $value)
                $parameters[$key] = $engine->eval($value);

            return $engine->callMethod(
                $engine->eval($this->Namespace), $engine->eval($this->Method),
                $parameters
            );
        }

        /**
         * @return string
         * @noinspection PhpUnused
         */
        public function getNamespace(): string
        {
            return $this->Namespace;
        }

        /**
         * @param string $Namespace
         */
        public function setNamespace(string $Namespace): void
        {
            $this->Namespace = $Namespace;
        }

        /**
         * @return string
         * @noinspection PhpUnused
         */
        public function getMethod(): string
        {
            return $this->Method;
        }

        /**
         * @param string $Method
         */
        public function setMethod(string $Method): void
        {
            $this->Method = $Method;
        }

        /**
         * @return array
         * @noinspection PhpUnused
         */
        public function getParameters(): array
        {
            return $this->Parameters;
        }

        /**
         * @param array $Parameters
         * @throws MalformedInstructionException
         * @throws UnsupportedVariableType
         */
        public function setParameters(array $Parameters): void
        {
            $this->Parameters = InstructionBuilder::fromRaw($Parameters);
        }

        /**
         * @return bool
         * @noinspection PhpUnused
         */
        public function isFailOnError(): bool
        {
            return $this->FailOnError;
        }

        /**
         * @param bool $FailOnError
         */
        public function setFailOnError(bool $FailOnError): void
        {
            $this->FailOnError = $FailOnError;
        }

        /**
         * @inheritDoc
         * @throws UnsupportedVariableType
         */
        public function __toString(): string
        {
            $parameters = [];
            foreach ($this->Parameters as $key => $value)
                $parameters[] = $key . ': ' . Utilities::entityToString($value);

            $results = sprintf(
                self::getType() . ' %s::%s(%s)',
                $this->Namespace, $this->Method, implode(', ', $parameters)
            );

            if(!$this->FailOnError)
                $results .= ' #FOE';

            return $results;
        }
    }