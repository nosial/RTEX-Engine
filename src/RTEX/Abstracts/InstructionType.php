<?php

    namespace RTEX\Abstracts;

    abstract class InstructionType
    {
        const Invoke = 'invoke';
        const GetVariable = 'get';
        const SetVariable = 'set';
    }