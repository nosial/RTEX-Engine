<?php

    use RTEX\Classes\InstructionBuilder;
    use RTEX\Engine;
    use RTEX\Objects\Program;

    require 'ncc';

    import('net.nosial.rtex', 'latest');

    $program = new Program();

    $program->getMain()->addInstruction(InstructionBuilder::set('foo', 'bar'));
    $program->getMain()->addInstruction(InstructionBuilder::set('bar', 500));

    $program->getMain()->addInstruction(InstructionBuilder::set('results',
        InstructionBuilder::sum(
            500,
            InstructionBuilder::get('bar')
        )
    ));

    $engine = new Engine($program);
    $engine->run();