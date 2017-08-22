<?php

namespace spec\Denismitr\Spam\Inspections;

use Denismitr\Spam\Contracts\Inspection;
use Denismitr\Spam\Exceptions\SpamDetected;
use Denismitr\Spam\Inspections\AsciiOnly;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AsciiOnlySpec extends ObjectBehavior
{
    protected $forbidden = [
        'Only english letters',
        'Only, english letters, and some gibberrish!! Yeah...',
    ];

    protected $allowed = [
        "Вот так, here it goes!",
        "Нормальный ткекст...",
    ];

    function it_is_initializable()
    {
        $this->shouldHaveType(AsciiOnly::class);
        $this->shouldImplement(Inspection::class);
    }

    function it_detects_key_held_down()
    {
        foreach ($this->forbidden as $phrase) {
            $this->shouldThrow(SpamDetected::class)->duringDetect($phrase);
        }
    }

    function it_allows_normal_text_with_some_repetitions()
    {
        foreach ($this->allowed as $phrase) {
            $this->shouldNotThrow(SpamDetected::class)->duringDetect($phrase);
        }
    }
}
