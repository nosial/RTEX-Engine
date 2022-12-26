<?php

    namespace RTEX\Classes;

    use RTEX\Abstracts\InstructionType;
    use RTEX\Exceptions\Core\MalformedInstructionException;
    use RTEX\Exceptions\Core\UnsupportedVariableType;
    use RTEX\Interfaces\InstructionInterface;
    use RTEX\Objects\Program\Instructions\ArrayGet;
    use RTEX\Objects\Program\Instructions\Divide;
    use RTEX\Objects\Program\Instructions\Equals;
    use RTEX\Objects\Program\Instructions\GetVariable;
    use RTEX\Objects\Program\Instructions\GreaterThan;
    use RTEX\Objects\Program\Instructions\GreaterThanOrEquals;
    use RTEX\Objects\Program\Instructions\Invoke;
    use RTEX\Objects\Program\Instructions\LessThan;
    use RTEX\Objects\Program\Instructions\LessThanOrEquals;
    use RTEX\Objects\Program\Instructions\Modulo;
    use RTEX\Objects\Program\Instructions\Multiply;
    use RTEX\Objects\Program\Instructions\Power;
    use RTEX\Objects\Program\Instructions\SetVariable;
    use RTEX\Objects\Program\Instructions\Subtract;
    use RTEX\Objects\Program\Instructions\Sum;

    class InstructionBuilder
    {
        /**
         * Re-constructs instructions and variable types from an array representation
         *
         * @param $value
         * @return array|mixed|InstructionInterface|null
         * @throws UnsupportedVariableType
         * @throws MalformedInstructionException
         * @noinspection PhpMissingReturnTypeInspection
         */
        public static function fromRaw($value)
        {
            // Check if it's a supported variable type
            if(!Validate::supportedVariableType($value))
                //throw new UnsupportedVariableType(gettype($value));

            // Check if it's an instruction
            if (is_array($value) && (isset($value['_']) && isset($value['type'])))
            {
                // Return the constructed InstructionInterface object
                return match ($value['type'])
                {
                    // Base instructions
                    InstructionType::Invoke => Invoke::fromArray($value['_']),

                    // Variables and constants
                    InstructionType::GetVariable => GetVariable::fromArray($value['_']),
                    InstructionType::SetVariable => SetVariable::fromArray($value['_']),

                    // Math operations
                    InstructionType::Equals => Equals::fromArray($value['_']),
                    InstructionType::Sum => Sum::fromArray($value['_']),
                    InstructionType::Subtract => Subtract::fromArray($value['_']),
                    InstructionType::Multiply => Multiply::fromArray($value['_']),
                    InstructionType::Divide => Divide::fromArray($value['_']),
                    InstructionType::Modulo => Modulo::fromArray($value['_']),
                    InstructionType::Power => Power::fromArray($value['_']),
                    InstructionType::GreaterThan => GreaterThan::fromArray($value['_']),
                    InstructionType::GreaterThanOrEquals => GreaterThanOrEquals::fromArray($value['_']),
                    InstructionType::LessThan => LessThan::fromArray($value['_']),
                    InstructionType::LessThanOrEquals => LessThanOrEquals::fromArray($value['_']),

                    // Array operations
                    InstructionType::ArrayGet => ArrayGet::fromArray($value['_']),

                    // Default
                    //default => throw new UnsupportedVariableType($value['type']),
                };
            }
            // Recursive call if it's an array
            elseif(is_array($value))
            {
                $output = [];
                foreach ($value as $key => $item)
                    $output[$key] = self::fromRaw($item);
                return $output;
            }

            // Return the value if it's not an array or an instruction
            return $value;
        }

        /**
         * Returns an array representation of an instruction
         * (Note, you must provide the array representation of the instruction's arguments)
         *
         * @param $type
         * @param $value
         * @return array
         * @throws UnsupportedVariableType
         */
        public static function toRaw($type, $value): array
        {
            return [
                'type' => $type,
                '_' => Utilities::toArray($value),
            ];
        }

        /**
         * Constructs a new get variable instruction
         *
         * @param $name
         * @return InstructionInterface
         * @throws MalformedInstructionException
         * @throws UnsupportedVariableType
         */
        public static function getVariable($name): InstructionInterface
        {
            $instruction = new GetVariable();
            $instruction->setVariable($name);

            return $instruction;
        }

        /**
         * Constructs a new set variable instruction
         *
         * @param $name
         * @param $value
         * @return InstructionInterface
         * @throws MalformedInstructionException
         * @throws UnsupportedVariableType
         */
        public static function setVariable($name, $value): InstructionInterface
        {
            $instruction = new SetVariable();
            $instruction->setVariable($name);
            $instruction->setValue($value);

            return $instruction;
        }

        /**
         * @param string $method
         * @param array $parameters
         * @param bool $fail_on_error
         * @return InstructionInterface
         * @throws MalformedInstructionException
         * @throws UnsupportedVariableType
         */
        public static function invoke(string $method, array $parameters, bool $fail_on_error=true): InstructionInterface
        {
            $exploded = explode('.', $method);

            //if(count($exploded) !== 2)
            //    throw new UndefinedMethodException(sprintf('Invalid method name "%s"', $method));

            $instruction = new Invoke();
            $instruction->setNamespace($exploded[0]);
            $instruction->setMethod($exploded[1]);
            $instruction->setParameters($parameters);
            $instruction->setFailOnError($fail_on_error);

            return $instruction;
        }

        /**
         * Creates a new equals instruction from two values or instructions
         * (or a combination of both)
         *
         * @param $a
         * @param $b
         * @return InstructionInterface
         * @throws MalformedInstructionException
         * @throws UnsupportedVariableType
         */
        public static function equals($a, $b): InstructionInterface
        {
            $instruction = new Equals();
            $instruction->setA($a);
            $instruction->setB($b);

            return $instruction;
        }

        /**
         * Creates a new sum instruction from two values or instructions
         * (or a combination of both)
         *
         * @param $a
         * @param $b
         * @return InstructionInterface
         * @throws MalformedInstructionException
         * @throws UnsupportedVariableType
         */
        public static function sum($a, $b): InstructionInterface
        {
            $instruction = new Sum();
            $instruction->setA($a);
            $instruction->setB($b);

            return $instruction;
        }

        /**
         * Creates a new subtract instruction from two values or instructions
         * (or a combination of both)
         *
         * @param $a
         * @param $b
         * @return InstructionInterface
         * @throws MalformedInstructionException
         * @throws UnsupportedVariableType
         */
        public static function subtract($a, $b): InstructionInterface
        {
            $instruction = new Subtract();
            $instruction->setA($a);
            $instruction->setB($b);

            return $instruction;
        }

        /**
         * Creates a new multiply instruction from two values or instructions
         * (or a combination of both)
         *
         * @param $a
         * @param $b
         * @return InstructionInterface
         * @throws MalformedInstructionException
         * @throws UnsupportedVariableType
         */
        public static function multiply($a, $b): InstructionInterface
        {
            $instruction = new Multiply();
            $instruction->setA($a);
            $instruction->setB($b);

            return $instruction;
        }

        /**
         * Creates a new divide instruction from two values or instructions
         * (or a combination of both)
         *
         * @param $a
         * @param $b
         * @return InstructionInterface
         * @throws MalformedInstructionException
         * @throws UnsupportedVariableType
         */
        public static function divide($a, $b): InstructionInterface
        {
            $instruction = new Divide();
            $instruction->setA($a);
            $instruction->setB($b);

            return $instruction;
        }

        /**
         * Creates a new modulo instruction from two values or instructions
         * (or a combination of both)
         *
         * @param $a
         * @param $b
         * @return InstructionInterface
         * @throws MalformedInstructionException
         * @throws UnsupportedVariableType
         */
        public static function modulo($a, $b): InstructionInterface
        {
            $instruction = new Modulo();
            $instruction->setA($a);
            $instruction->setB($b);

            return $instruction;
        }

        /**
         * Creates a new power instruction from two values or instructions
         * (or a combination of both)
         *
         * @param $a
         * @param $b
         * @return InstructionInterface
         * @throws MalformedInstructionException
         * @throws UnsupportedVariableType
         */
        public static function power($a, $b): InstructionInterface
        {
            $instruction = new Power();
            $instruction->setA($a);
            $instruction->setB($b);

            return $instruction;
        }

        /**
         * Creates a new greater than instruction from two values or instructions
         * (or a combination of both)
         *
         * @param $a
         * @param $b
         * @return InstructionInterface
         * @throws MalformedInstructionException
         * @throws UnsupportedVariableType
         */
        public static function greaterThan($a, $b): InstructionInterface
        {
            $instruction = new GreaterThan();
            $instruction->setA($a);
            $instruction->setB($b);

            return $instruction;
        }

        /**
         * Creates a new greater than or equals instruction from two values or instructions
         * (or a combination of both)
         *
         * @param $a
         * @param $b
         * @return InstructionInterface
         * @throws MalformedInstructionException
         * @throws UnsupportedVariableType
         */
        public static function greaterThanOrEquals($a, $b): InstructionInterface
        {
            $instruction = new GreaterThanOrEquals();
            $instruction->setA($a);
            $instruction->setB($b);

            return $instruction;
        }

        /**
         * Creates a new less than instruction from two values or instructions
         * (or a combination of both)
         *
         * @param $a
         * @param $b
         * @return InstructionInterface
         * @throws MalformedInstructionException
         * @throws UnsupportedVariableType
         */
        public static function lessThan($a, $b): InstructionInterface
        {
            $instruction = new LessThan();
            $instruction->setA($a);
            $instruction->setB($b);

            return $instruction;
        }

        /**
         * Creates a new less than or equals instruction from two values or instructions
         * (or a combination of both)
         *
         * @param $a
         * @param $b
         * @return InstructionInterface
         * @throws MalformedInstructionException
         * @throws UnsupportedVariableType
         */
        public static function lessThanOrEquals($a, $b): InstructionInterface
        {
            $instruction = new LessThanOrEquals();
            $instruction->setA($a);
            $instruction->setB($b);

            return $instruction;
        }
    }