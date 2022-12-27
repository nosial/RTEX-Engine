<?php

    namespace RTEX\Abstracts;

    abstract class InstructionType
    {
        // Base
        const Invoke = 'invoke';

        // Variables
        const GetVariable = 'get';
        const SetVariable = 'set';

        // Math
        const Equals = 'equals';
        const Sum = 'sum';
        const Subtract = 'subtract';
        const Divide = 'divide';
        const Multiply = 'multiply';
        const Modulo = 'modulo';
        const Power = 'power';
        const GreaterThan = 'greater_than';
        const GreaterThanOrEquals = 'greater_than_or_equals';
        const LessThan = 'less_than';
        const LessThanOrEquals = 'less_than_or_equals';
        const NotEquals = 'not_equals';

        // Arrays
        const ArrayGet = 'array_get';


        const All = [
            self::Invoke,

            self::GetVariable,
            self::SetVariable,

            self::Equals,
            self::Sum,
            self::Subtract,
            self::Divide,
            self::Multiply,
            self::Modulo,
            self::Power,
            self::GreaterThan,
            self::GreaterThanOrEquals,
            self::LessThan,
            self::LessThanOrEquals,
            self::NotEquals,

            self::ArrayGet,
        ];
    }