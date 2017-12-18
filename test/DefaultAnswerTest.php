<?php

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class DefaultAnswerTest extends PHPUnit\Framework\TestCase
{
    public function test_generate()
    {
        $testee = new DefaultAnswer();
        $this->assertSame('<speak>Your weather station cannot help you with that.</speak>', $testee->generate());
    }
}

?>
