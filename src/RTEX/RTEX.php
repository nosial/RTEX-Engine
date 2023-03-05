<?php

    namespace RTEX;

    use OptsLib\Parse;

    class RTEX
    {
        /**
         * The main CLI entry point for the RTEX program
         *
         * @return void
         * @noinspection PhpNoReturnAttributeCanBeAddedInspection
         */
        public static function main(): void
        {
            $args = Parse::getArguments();

            $file = $args['path'] ?? $args['p'] ?? null;

            if(($args['version'] ?? $args['v'] ?? false))
            {
                self::displayVersion(true);
            }

            if($file == null || ($args['help'] ?? $args['h'] ?? false))
            {
                self::displayHelp(true);
            }

            exit(0);
        }

        /**
         * Prints the version of the RTEX program and optionally exits the program
         *
         * @param bool $exit
         * @return void
         */
        private static function displayVersion(bool $exit=false): void
        {
            print('RTEX 0.1.0' . PHP_EOL);

            if($exit)
            {
                exit(0);
            }
        }

        /**
         * Prints the help menu and optionally exits the program
         *
         * @param bool $exit
         * @return void
         */
        private static function displayHelp(bool $exit=false): void
        {
            print('RTEX - Runtime Execution' . PHP_EOL);
            print('Usage: rtex [options] [file]' . PHP_EOL);
            print('Options:' . PHP_EOL);
            print('  -h, --help     Display this help message' . PHP_EOL);
            print('  -p, --path     Specify the path to the program file' . PHP_EOL);
            print('  -v, --version  Display the version of RTEX' . PHP_EOL);

            if($exit)
            {
                exit(0);
            }
        }
    }