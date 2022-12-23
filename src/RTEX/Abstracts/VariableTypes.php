<?php

    namespace RTEX\Abstracts;

    abstract class VariableTypes
    {
        const String = 'string';

        const Integer = 'integer';

        const Float = 'float';

        const Boolean = 'boolean';

        const Null = 'null';

        const Instruction = 'instruction';

        const InstructionList = 'i_instruction';

        const All = [
            self::String,
            self::Integer,
            self::Float,
            self::Boolean,
            self::Null,
            self::Instruction,
            self::InstructionList
        ];
    }