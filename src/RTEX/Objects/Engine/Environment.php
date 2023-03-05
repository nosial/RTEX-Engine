<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace RTEX\Objects\Engine;

    use LogLib\Log;
    use RTEX\Exceptions\Runtime\NameException;

    class Environment
    {
        /**
         * @var array
         */
        private $RuntimeVariables;

        /**
         * Public Constructor
         */
        public function __construct()
        {
            $this->RuntimeVariables = [];
        }

        /**
         * Returns the value of the specified variable
         *
         * @param string $name
         * @return mixed
         * @throws NameException
         */
        public function getRuntimeVariable(string $name): mixed
        {
            Log::debug('net.nosial.rtex', $name);

            if (!$this->variableExists($name))
                throw new NameException("Variable '$name' is not defined");

            return $this->RuntimeVariables[$name];
        }

        /**
         * Sets the value of the specified variable
         *
         * @param string $name
         * @param mixed $value
         */
        public function setRuntimeVariable(string $name, mixed $value): void
        {
            Log::debug('net.nosial.rtex', $name);
            $this->RuntimeVariables[$name] = $value;
        }

        /**
         * @param string $name
         * @return bool
         */
        public function variableExists(string $name): bool
        {
            return array_key_exists($name, $this->RuntimeVariables);
        }

        /**
         * Clears the value of the specified variable
         *
         * @return void
         * @noinspection PhpUnused
         */
        public function clearRuntimeVariables(): void
        {
            $this->RuntimeVariables = [];
        }

        /**
         * Counts the number of variables in the environment
         *
         * @return int
         */
        public function countRuntimeVariables(): int
        {
            return count($this->RuntimeVariables);
        }

        /**
         * Returns an array representation of the object
         *
         * @return array
         */
        public function toArray(): array
        {
            return [
                'variables' => $this->RuntimeVariables
            ];
        }

        /**
         * Constructs a new environment from an array representation
         *
         * @param array $data
         * @return Environment
         */
        public static function fromArray(array $data): Environment
        {
            $environment = new Environment();
            $environment->RuntimeVariables = $data['variables'];

            return $environment;
        }
    }