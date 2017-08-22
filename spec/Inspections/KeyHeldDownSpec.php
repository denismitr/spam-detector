<?php

namespace spec\Denismitr\Spam\Inspections;

use Denismitr\Spam\Contracts\Inspection;
use Denismitr\Spam\Exceptions\SpamDetected;
use Denismitr\Spam\Inspections\KeyHeldDown;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class KeyHeldDownSpec extends ObjectBehavior
{
    protected $forbidden = [
        'abcdeeeeeeee',
        'Я пишу спаммммммммммм',
        'Я козел ллллллвввввв',
        'I am idiottttt.',
        'Я люблю слишком!!!!!',
    ];

    protected $allowed = [
        "I'am not a spam!!!",
        "I'am not a spammmer...",
    ];

    function it_is_initializable()
    {
        $this->shouldHaveType(KeyHeldDown::class);
        $this->shouldImplement(Inspection::class);
    }

    function it_detects_key_held_down()
    {
        foreach ($this->forbidden as $phrase) {
            $this->shouldThrow(SpamDetected::class)->duringDetect("Всякий текст " . $phrase . " ещё текст");
        }
    }

    function it_allows_normal_text_with_some_repetitions()
    {
        foreach ($this->allowed as $phrase) {
            $this->shouldNotThrow(SpamDetected::class)->duringDetect("Всякий текст " . $phrase . " ещё текст");
        }
    }
}
