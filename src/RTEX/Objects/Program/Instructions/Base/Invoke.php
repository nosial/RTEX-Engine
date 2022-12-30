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
         * The name of the namespace & method to invoke
         *
         * @var string
         */
        private $Callable;

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
                'callable' => $this->Callable,
                'parameters' => $this->Parameters,
                'fail_on_error' => $this->FailOnError
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
            $instruction->setCallable($data['callable'] ?? null);
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
            $callable = $engine->eval($this->Callable);
            $parameters = [];
            foreach($this->Parameters as $key => $value)
                $parameters[$key] = $engine->eval($value);

            if(!is_string($callable))
                throw new TypeException(sprintf('Callable must be a string, %s given', Utilities::getType($callable, true)));

            $callable = explode('.', $callable);
            if(count($callable) !== 2)
                throw new ImportException(sprintf('Callable must be in the format of "namespace.method", %s given', $this->Callable));

            $namespace = $callable[0];
            $method = $callable[1];

            return $engine->callMethod($namespace, $method, $parameters);
        }

        /**
         * @return string
         * @noinspection PhpUnused
         */
        public function getCallable(): string
        {
            return $this->Callable;
        }

        /**
         * @param string $Callable
         */
        public function setCallable(string $Callable): void
        {
            $this->Callable = $Callable;
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

            $callable = explode('.', Utilities::entityToString($this->Callable));
            if(count($callable) !== 2)
            {
                $namespace = 'unknown';
                $method = 'unknown';
            }
            else
            {
                $namespace = $callable[0];
                $method = $callable[1];
            }

            $results = sprintf(
                self::getType() . ' %s.%s(%s)',
                $namespace, $method, implode(', ', $parameters)
            );

            if(!$this->FailOnError)
                $results .= ' #FOE';

            return $results;
        }
    }