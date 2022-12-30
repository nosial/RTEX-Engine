<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace RTEX\Objects\Program\Instructions\Base;

    use RTEX\Abstracts\InstructionType;
    use RTEX\Classes\InstructionBuilder;
    use RTEX\Classes\Utilities;
    use RTEX\Engine;
    use RTEX\Exceptions\EvaluationException;
    use RTEX\Exceptions\InstructionException;
    use RTEX\Exceptions\Runtime\ImportException;
    use RTEX\Exceptions\Runtime\TypeException;
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
         */
        public function toArray(): array
        {
            return InstructionBuilder::toRaw(self::getType(), [
                'namespace' => $this->Namespace,
                'method' => $this->Method,
                'parameters' => $this->Parameters,
                'fail_on_error' => $this->FailOnError, // TODO: Implement this
            ]);
        }

        /**
         * Constructs an instruction from an array
         *
         * @param array $data
         * @return InstructionInterface
         * @throws InstructionException
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
         * @throws EvaluationException
         * @throws ImportException
         * @throws TypeException
         */
        public function eval(Engine $engine): mixed
        {
            $namespace = $engine->eval($this->Namespace);
            $method = $engine->eval($this->Method);
            $parameters = [];
            foreach($this->Parameters as $key => $value)
                $parameters[$key] = $engine->eval($value);

            if(!is_string($namespace))
                throw new TypeException(sprintf('The namespace must be a string, %s given', Utilities::getType($namespace, true)));
            if(!is_string($method))
                throw new TypeException(sprintf('The method must be a string, %s given', Utilities::getType($method, true)));

            return $engine->callMethod($namespace, $method, $parameters);
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
         * @throws InstructionException
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