<?php
    namespace RTEX\Classes;

    use RTEX\Abstracts\InstructionType;
    use RTEX\Exceptions\InstructionException;
    use RTEX\Interfaces\InstructionInterface;
    use RTEX\Objects\Instructions\Arithmetic\Absolute;
    use RTEX\Objects\Instructions\Arithmetic\Divide;
    use RTEX\Objects\Instructions\Arithmetic\Floor;
    use RTEX\Objects\Instructions\Arithmetic\Modulo;
    use RTEX\Objects\Instructions\Arithmetic\Multiply;
    use RTEX\Objects\Instructions\Arithmetic\Power;
    use RTEX\Objects\Instructions\Arithmetic\Round;
    use RTEX\Objects\Instructions\Arithmetic\SquareRoot;
    use RTEX\Objects\Instructions\Arithmetic\Subtract;
    use RTEX\Objects\Instructions\Arithmetic\Sum;
    use RTEX\Objects\Instructions\Base\ArrayGet;
    use RTEX\Objects\Instructions\Base\ArraySet;
    use RTEX\Objects\Instructions\Base\GetVariable;
    use RTEX\Objects\Instructions\Base\Invoke;
    use RTEX\Objects\Instructions\Base\SetVariable;
    use RTEX\Objects\Instructions\Comparators\Equals;
    use RTEX\Objects\Instructions\Comparators\GreaterThan;
    use RTEX\Objects\Instructions\Comparators\GreaterThanOrEqual;
    use RTEX\Objects\Instructions\Comparators\LessThan;
    use RTEX\Objects\Instructions\Comparators\LessThanOrEqual;
    use RTEX\Objects\Instructions\Comparators\NotEquals;

    class InstructionBuilder
    {
        /**
         * Re-constructs instructions and variable types from an array representation
         *
         * @param $value
         * @return array|mixed|InstructionInterface|null
         * @throws InstructionException
         */
        public static function fromRaw($value): mixed
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
                    // Arithmetic operations
                    InstructionType::Absolute => Absolute::fromArray($value['_']),
                    InstructionType::Divide => Divide::fromArray($value['_']),
                    InstructionType::Floor => Floor::fromArray($value['_']),
                    InstructionType::Modulo => Modulo::fromArray($value['_']),
                    InstructionType::Multiply => Multiply::fromArray($value['_']),
                    InstructionType::Power => Power::fromArray($value['_']),
                    InstructionType::Round => Round::fromArray($value['_']),
                    InstructionType::SquareRoot => SquareRoot::fromArray($value['_']),
                    InstructionType::Subtract => Subtract::fromArray($value['_']),
                    InstructionType::Sum => Sum::fromArray($value['_']),

                    // Base instructions
                    InstructionType::Invoke => Invoke::fromArray($value['_']),
                    InstructionType::GetVariable => GetVariable::fromArray($value['_']),
                    InstructionType::SetVariable => SetVariable::fromArray($value['_']),
                    InstructionType::ArrayGet => ArrayGet::fromArray($value['_']),
                    InstructionType::ArraySet => ArraySet::fromArray($value['_']),

                    // Comparators
                    InstructionType::Equals => Equals::fromArray($value['_']),
                    InstructionType::GreaterThan => GreaterThan::fromArray($value['_']),
                    InstructionType::GreaterThanOrEqual => GreaterThanOrEqual::fromArray($value['_']),
                    InstructionType::LessThan => LessThan::fromArray($value['_']),
                    InstructionType::LessThanOrEqual => LessThanOrEqual::fromArray($value['_']),
                    InstructionType::NotEquals => NotEquals::fromArray($value['_']),

                    // Default (Unknown)
                    default => throw new InstructionException(sprintf('Unknown instruction type "%s"', $value['type'])),
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
         */
        public static function toRaw($type, $value): array
        {
            return [
                'type' => $type,
                '_' => Utilities::toArray($value),
            ];
        }


        /**
         * Returns the absolute value of a number
         *
         * @param $value float|int|InstructionInterface The number to get the absolute value of
         * @return InstructionInterface
         * @throws InstructionException
         */
        public static function abs(InstructionInterface|float|int $value): InstructionInterface
        {
            $instruction = new Absolute();
            $instruction->setValue($value);

            return $instruction;
        }

        /**
         * Divides two numbers and returns the result
         *
         * @param $a float|int|InstructionInterface The dividend
         * @param $b float|int|InstructionInterface The divisor
         * @return InstructionInterface
         * @throws InstructionException
         */
        public static function div(InstructionInterface|float|int $a, InstructionInterface|float|int $b): InstructionInterface
        {
            $instruction = new Divide();
            $instruction->setA($a);
            $instruction->setB($b);

            return $instruction;
        }

        /**
         * Returns the largest integer less than or equal to a number
         *
         * @param $value float|int|InstructionInterface The number to get the floor of
         * @return InstructionInterface
         * @throws InstructionException
         */
        public static function floor(InstructionInterface|float|int $value): InstructionInterface
        {
            $instruction = new Floor();
            $instruction->setValue($value);

            return $instruction;
        }

        /**
         * Returns the remainder of a division
         *
         * @param $a float|int|InstructionInterface The dividend
         * @param $b float|int|InstructionInterface The divisor
         * @return InstructionInterface
         * @throws InstructionException
         */
        public static function mod(InstructionInterface|float|int $a, InstructionInterface|float|int $b): InstructionInterface
        {
            $instruction = new Modulo();
            $instruction->setA($a);
            $instruction->setB($b);

            return $instruction;
        }

        /**
         * Multiplies two numbers and returns the result
         *
         * @param $a float|int|InstructionInterface The first number
         * @param $b float|int|InstructionInterface The second number
         * @return InstructionInterface
         * @throws InstructionException
         */
        public static function mul(InstructionInterface|float|int $a, InstructionInterface|float|int $b): InstructionInterface
        {
            $instruction = new Multiply();
            $instruction->setA($a);
            $instruction->setB($b);

            return $instruction;
        }

        /**
         * Raises a number to a power and returns the result
         *
         * @param $a float|int|InstructionInterface The base number
         * @param $b float|int|InstructionInterface The exponent
         * @return InstructionInterface
         * @throws InstructionException
         */
        public static function pow(InstructionInterface|float|int $a, InstructionInterface|float|int $b): InstructionInterface
        {
            $instruction = new Power();
            $instruction->setA($a);
            $instruction->setB($b);

            return $instruction;
        }

        /**
         * Rounds a number to a given precision
         *
         * @param $value float|int|InstructionInterface The number to round
         * @param $precision int|InstructionInterface The precision to round to
         * @return InstructionInterface
         * @throws InstructionException
         */
        public static function round(InstructionInterface|float|int $value, InstructionInterface|int $precision=0): InstructionInterface
        {
            $instruction = new Round();
            $instruction->setValue($value);
            $instruction->setPrecision($precision);

            return $instruction;
        }

        /**
         * Returns the square root of a number
         *
         * @param $value float|int|InstructionInterface The number to get the square root of
         * @return InstructionInterface
         * @throws InstructionException
         */
        public static function sqrt(InstructionInterface|float|int $value): InstructionInterface
        {
            $instruction = new SquareRoot();
            $instruction->setValue($value);

            return $instruction;
        }

        /**
         * Subtracts two numbers and returns the result
         *
         * @param $a float|int|InstructionInterface The minuend
         * @param $b float|int|InstructionInterface The subtrahend
         * @return InstructionInterface
         * @throws InstructionException
         */
        public static function sub(InstructionInterface|float|int $a, InstructionInterface|float|int $b): InstructionInterface
        {
            $instruction = new Subtract();
            $instruction->setA($a);
            $instruction->setB($b);

            return $instruction;
        }

        /**
         * Adds two numbers and returns the result
         *
         * @param $a float|int|InstructionInterface The first number
         * @param $b float|int|InstructionInterface The second number
         * @return InstructionInterface
         * @throws InstructionException
         */
        public static function sum(InstructionInterface|float|int $a, InstructionInterface|float|int $b): InstructionInterface
        {
            $instruction = new Sum();
            $instruction->setA($a);
            $instruction->setB($b);

            return $instruction;
        }

        /**
         * Returns the requested key from an array
         *
         * @param InstructionInterface|array $array The array to get the key from
         * @param InstructionInterface|string $key The key to get (can be a string or an instruction) (eg; "foo" or "foo.bar")
         * @return InstructionInterface
         * @throws InstructionException
         */
        public static function array_get(InstructionInterface|array $array, InstructionInterface|string $key): InstructionInterface
        {
            $instruction = new ArrayGet();
            $instruction->setArray($array);
            $instruction->setKey($key);

            return $instruction;
        }

        /**
         * Sets the requested key in an array
         *
         * @param InstructionInterface|array $array The array to set the key in
         * @param InstructionInterface|string $key The key to get (can be a string or an instruction) (eg; "foo" or "foo.bar")
         * @param mixed $value The value to set the key to
         * @return InstructionInterface
         * @throws InstructionException
         */
        public static function array_set(InstructionInterface|array $array, InstructionInterface|string $key, mixed $value): InstructionInterface
        {
            $instruction = new ArraySet();
            $instruction->setArray($array);
            $instruction->setKey($key);
            $instruction->setValue($value);

            return $instruction;
        }

        /**
         * Gets an existing variable from the environment
         *
         * @param InstructionInterface|string $name The name of the variable to get
         * @return InstructionInterface
         * @throws InstructionException
         */
        public static function get(InstructionInterface|string $name): InstructionInterface
        {
            $instruction = new GetVariable();
            $instruction->setVariableName($name);

            return $instruction;
        }

        /**
         * Invokes a callable with the given arguments
         *
         * @param InstructionInterface|string $callable The callable to invoke
         * @param array $parameters The parameters to pass to the callable
         * @param bool|InstructionBuilder $fail_on_error Whether to fail on error or not
         * @return InstructionInterface
         * @throws InstructionException
         */
        public static function invoke(InstructionInterface|string $callable, array $parameters=[], bool|InstructionBuilder $fail_on_error=true): InstructionInterface
        {
            $instruction = new Invoke();
            $instruction->setCallable($callable);
            $instruction->setParameters($parameters);
            $instruction->setFailOnError($fail_on_error);

            return $instruction;
        }

        /**
         * Sets a variable in the environment
         *
         * @param InstructionInterface|string $name The name of the variable to set
         * @param mixed $value The value to set the variable to
         * @return InstructionInterface
         * @throws InstructionException
         */
        public static function set(InstructionInterface|string $name, mixed $value): InstructionInterface
        {
            $instruction = new SetVariable();
            $instruction->setName($name);
            $instruction->setValue($value);

            return $instruction;
        }

        /**
         * Returns true if the two values are equal
         *
         * @param InstructionInterface|float|int|string $a The first value
         * @param InstructionInterface|float|int|string $b The second value
         * @return InstructionInterface
         * @throws InstructionException
         */
        public static function eq(InstructionInterface|float|int|string $a, InstructionInterface|float|int|string $b): InstructionInterface
        {
            $instruction = new Equals();
            $instruction->setA($a);
            $instruction->setB($b);

            return $instruction;
        }

        /**
         * Returns true if the two values are not equal
         *
         * @param InstructionInterface|float|int|string $a The first value
         * @param InstructionInterface|float|int|string $b The second value
         * @return InstructionInterface
         * @throws InstructionException
         */
        public static function neq(InstructionInterface|float|int|string $a, InstructionInterface|float|int|string $b): InstructionInterface
        {
            $instruction = new NotEquals();
            $instruction->setA($a);
            $instruction->setB($b);

            return $instruction;
        }

        /**
         * Returns true if the first value is greater than the second value
         *
         * @param InstructionInterface|float|int|string $a The first value
         * @param InstructionInterface|float|int|string $b The second value
         * @return InstructionInterface
         * @throws InstructionException
         */
        public static function gt(InstructionInterface|float|int|string $a, InstructionInterface|float|int|string $b): InstructionInterface
        {
            $instruction = new GreaterThan();
            $instruction->setA($a);
            $instruction->setB($b);

            return $instruction;
        }

        /**
         * Returns true if the first value is greater than or equal to the second value
         *
         * @param InstructionInterface|float|int|string $a The first value
         * @param InstructionInterface|float|int|string $b The second value
         * @return InstructionInterface
         * @throws InstructionException
         */
        public static function gte(InstructionInterface|float|int|string $a, InstructionInterface|float|int|string $b): InstructionInterface
        {
            $instruction = new GreaterThanOrEqual();
            $instruction->setA($a);
            $instruction->setB($b);

            return $instruction;
        }

        /**
         * Returns true if the first value is less than the second value
         *
         * @param InstructionInterface|float|int|string $a The first value
         * @param InstructionInterface|float|int|string $b The second value
         * @return InstructionInterface
         * @throws InstructionException
         */
        public static function lt(InstructionInterface|float|int|string $a, InstructionInterface|float|int|string $b): InstructionInterface
        {
            $instruction = new LessThan();
            $instruction->setA($a);
            $instruction->setB($b);

            return $instruction;
        }


        /**
         * Returns true if the first value is less than or equal to the second value
         *
         * @param InstructionInterface|float|int|string $a The first value
         * @param InstructionInterface|float|int|string $b The second value
         * @return InstructionInterface
         * @throws InstructionException
         */
        public static function lte(InstructionInterface|float|int|string $a, InstructionInterface|float|int|string $b): InstructionInterface
        {
            $instruction = new LessThanOrEqual();
            $instruction->setA($a);
            $instruction->setB($b);

            return $instruction;
        }
    }