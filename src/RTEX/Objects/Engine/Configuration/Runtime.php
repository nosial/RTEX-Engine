<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace RTEX\Objects\Engine\Configuration;

    class Runtime
    {
        /**
         * The maximum size a variable value can have (in bytes)
         * (default: 0) (no limit)
         *
         * @var int
         */
        private $MaxVariableSize;

        /**
         * The maximum number of variables that can be defined
         * (default: 0) (no limit)
         *
         * @var int
         */
        private $MaxVariables;

        /**
         * The maximum number of instructions that can be executed
         * (default: 0) (no limit)
         *
         * @var int
         */
        private $MaxStackSize;

        /**
         * An array of instructions that are not allowed to be executed
         * if the script attempts to execute one of these instructions
         * the engine will treat it as a fatal error and stop the execution
         *
         * For production environments it is recommended to disable dangerous
         * instructions such as regex if you aren't supervising the engine
         *
         * @var string[]
         */
        private $InstructionBlacklist;

        /**
         * An array of ncc packages to import as a namespace into the engine
         * (The engine will look for a file named 'rtex.conf' in the package
         * source directory and register the defined methods for that namespace)
         *
         * This will only work for packages designed for the engine and will
         * not work for regular PHP packages (unless they include support for RTEX)
         *
         * Values must be in the format of 'com.example.package' (The same format as
         * importing packages via the import() function)
         *
         * @var string[]
         */
        private $ImportNamespaces;

        /**
         * Public Constructor
         */
        public function __construct()
        {
            $this->MaxVariableSize = 0;
            $this->MaxVariables = 0;
            $this->MaxStackSize = 0;
            $this->InstructionBlacklist = [];
        }

        /**
         * @return int
         */
        public function getMaxVariableSize(): int
        {
            return $this->MaxVariableSize;
        }

        /**
         * @param int $MaxVariableSize
         */
        public function setMaxVariableSize(int $MaxVariableSize): void
        {
            $this->MaxVariableSize = $MaxVariableSize;
        }

        /**
         * @return int
         */
        public function getMaxVariables(): int
        {
            return $this->MaxVariables;
        }

        /**
         * @param int $MaxVariables
         */
        public function setMaxVariables(int $MaxVariables): void
        {
            $this->MaxVariables = $MaxVariables;
        }

        /**
         * @return int
         */
        public function getMaxStackSize(): int
        {
            return $this->MaxStackSize;
        }

        /**
         * @param int $MaxStackSize
         */
        public function setMaxStackSize(int $MaxStackSize): void
        {
            $this->MaxStackSize = $MaxStackSize;
        }

        /**
         * Returns the instruction blacklist
         *
         * @return array|string[]
         */
        public function getInstructionBlacklist(): array
        {
            return $this->InstructionBlacklist;
        }

        /**
         * Sets the instruction blacklist
         *
         * @param array|string[] $InstructionBlacklist
         */
        public function setInstructionBlacklist(array $InstructionBlacklist): void
        {
            $this->InstructionBlacklist = $InstructionBlacklist;
        }

        /**
         * Adds an instruction to the blacklist
         *
         * @param string $instruction
         * @return void
         */
        public function addInstructionToBlacklist(string $instruction): void
        {
            if (in_array($instruction, $this->InstructionBlacklist))
                return;

            $this->InstructionBlacklist[] = $instruction;
        }

        /**
         * Removes an instruction from the blacklist
         *
         * @param string $instruction
         * @return void
         */
        public function removeInstructionFromBlacklist(string $instruction): void
        {
            if (!in_array($instruction, $this->InstructionBlacklist))
                return;

            $this->InstructionBlacklist = array_diff($this->InstructionBlacklist, [$instruction]);
        }

        /**
         * @return string[]
         */
        public function getImportNamespaces(): array
        {
            return $this->ImportNamespaces;
        }

        /**
         * @param string[] $ImportNamespaces
         */
        public function setImportNamespaces(array $ImportNamespaces): void
        {
            $this->ImportNamespaces = $ImportNamespaces;
        }

        /**
         * Adds a namespace to the import list
         *
         * @param string $namespace
         * @return void
         */
        public function addNamespaceToImport(string $namespace): void
        {
            if (in_array($namespace, $this->ImportNamespaces))
                return;

            $this->ImportNamespaces[] = $namespace;
        }

        /**
         * Removes a namespace from the import list
         *
         * @param string $namespace
         * @return void
         */
        public function removeNamespaceFromImport(string $namespace): void
        {
            if (!in_array($namespace, $this->ImportNamespaces))
                return;

            $this->ImportNamespaces = array_diff($this->ImportNamespaces, [$namespace]);
        }

    }