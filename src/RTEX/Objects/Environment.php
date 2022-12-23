<?php

    namespace RTEX\Objects;

    use LogLib\Log;

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
         */
        public function getRuntimeVariable(string $name)
        {
            Log::debug('net.nosial.rtex', $name);
            return $this->RuntimeVariables[$name];
        }

        /**
         * Sets the value of the specified variable
         *
         * @param string $name
         * @param mixed $value
         */
        public function setRuntimeVariable(string $name, $value): void
        {
            Log::debug('net.nosial.rtex', $name);
            $this->RuntimeVariables[$name] = $value;
        }

        /**
         * Clears the value of the specified variable
         *
         * @return void
         */
        public function clearRuntimeVariables(): void
        {
            $this->RuntimeVariables = [];
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