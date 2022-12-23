<?php

    namespace RTEX\Objects;

    use RTEX\Objects\Program\Script;

    class Program
    {
        /**
         * The main script of the program to execute
         *
         * @var Script
         */
        private $Main;

        /**
         * Public Constructor
         */
        public function __construct()
        {
            $this->Main = new Script();
        }

        /**
         * Returns an array representation of the object
         *
         * @return array
         */
        public function toArray(): array
        {
            return [
                'main' => $this->Main->toArray()
            ];
        }

        /**
         * Constructs a new program from an array representation
         *
         * @param array $data
         * @return Program
         */
        public static function fromArray(array $data): Program
        {
            $program = new Program();
            $program->Main = Script::fromArray($data['main']);

            return $program;
        }

        /**
         * @return Script
         */
        public function getMain(): Script
        {
            return $this->Main;
        }

        /**
         * Saves the program to a file
         *
         * @param string $path
         * @return void
         */
        public function save(string $path): void
        {
            file_put_contents($path, json_encode($this->toArray()));
        }

        /**
         * Loads a program from a file
         *
         * @param string $path
         * @return Program
         */
        public static function load(string $path): Program
        {
            return self::fromArray(json_decode(file_get_contents($path), true));
        }
    }