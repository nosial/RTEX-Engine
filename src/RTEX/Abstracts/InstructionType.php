<?php

    namespace RTEX\Abstracts;

    abstract class InstructionType
    {
        // Arithmetic
        const Sum = 'sum';
        const Subtract = 'sub';
        const Divide = 'div';
        const Multiply = 'mul';
        const Modulo = 'mod';
        const Power = 'pow';
        const SquareRoot = 'sqrt';
        const Absolute = 'abs';
        const Round = 'round';
        const Floor = 'floor';

        // Base
        const Invoke = 'invoke';
        const ArrayGet = 'array_get';
        const ArraySet = 'array_set';
        const GetVariable = 'get';
        const SetVariable = 'set';

        // Comparators
        const Equals = 'eq';
        const NotEquals = 'neq';
        const GreaterThan = 'gt';
        const GreaterThanOrEquals = 'gte';
        const LessThan = 'lt';
        const LessThanOrEquals = 'lte';


        const All = [
            self::Sum,
            self::Subtract,
            self::Divide,
            self::Multiply,
            self::Modulo,
            self::Power,
            self::SquareRoot,
            self::Absolute,
            self::Round,
            self::Floor,

            self::Invoke,
            self::GetVariable,
            self::SetVariable,
            self::ArrayGet,
            self::ArraySet,

            self::Equals,
            self::GreaterThan,
            self::GreaterThanOrEquals,
            self::LessThan,
            self::LessThanOrEquals,
            self::NotEquals,
        ];
    }