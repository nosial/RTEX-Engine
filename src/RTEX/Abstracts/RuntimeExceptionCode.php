<?php

    namespace RTEX\Abstracts;

    abstract class RuntimeExceptionCode
    {
        const Exception = 0;
        const ImportException = -100;
        const KeyException = -101;
        const NameException = -102;
        const TypeException = -103;
        const UndefinedMethodException = -104;
        const ZeroDivisionException = -105;
    }