<?php

    use RTEX\Classes\InstructionBuilder;
    use RTEX\Objects\Program;

    require('ncc');
    import('net.nosial.rtex', 'latest');

    $program = new Program();

    $program->getMain()->addInstruction(InstructionBuilder::abs(-2));
    $program->getMain()->addInstruction(InstructionBuilder::div(2, 2));
    $program->getMain()->addInstruction(InstructionBuilder::floor(2.5));
    $program->getMain()->addInstruction(InstructionBuilder::mod(2, 2));
    $program->getMain()->addInstruction(InstructionBuilder::mul(2, 2));
    $program->getMain()->addInstruction(InstructionBuilder::pow(2, 2));
    $program->getMain()->addInstruction(InstructionBuilder::round(2.5));
    $program->getMain()->addInstruction(InstructionBuilder::sqrt(2));
    $program->getMain()->addInstruction(InstructionBuilder::sub(2, 2));
    $program->getMain()->addInstruction(InstructionBuilder::sum(2, 2));

    $program->getMain()->addInstruction(InstructionBuilder::array_set(["test"=>["foo"=>"bar"]], 'test.foo', 'baz'));
    $program->getMain()->addInstruction(InstructionBuilder::array_get(["test"=>["foo"=>"bar"]], 'test.foo'));
    $program->getMain()->addInstruction(InstructionBuilder::set('test', 'foo'));
    $program->getMain()->addInstruction(InstructionBuilder::get('test'));

    $program->getMain()->addInstruction(InstructionBuilder::eq(2, 2));
    $program->getMain()->addInstruction(InstructionBuilder::gt(2, 2));
    $program->getMain()->addInstruction(InstructionBuilder::gte(2, 2));
    $program->getMain()->addInstruction(InstructionBuilder::lt(2, 2));
    $program->getMain()->addInstruction(InstructionBuilder::lte(2, 2));
    $program->getMain()->addInstruction(InstructionBuilder::neq(2, 2));

    print(json_encode($program->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL);
    print((string)$program->getMain() . PHP_EOL);