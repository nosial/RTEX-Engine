<?php

    namespace RTEX\Abstracts;

    abstract class VariableType
    {
        const String = 'string';

        const Integer = 'integer';

        const Float = 'float';

        const Boolean = 'boolean';

        const Array = 'array';

        const Null = 'null';

        const Instruction = 'instruction';

        const All = [
            self::String,
            self::Integer,
            self::Float,
            self::Boolean,
            self::Array,
            self::Null,
            self::Instruction
        ];
    }