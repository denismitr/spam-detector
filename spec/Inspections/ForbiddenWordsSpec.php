<?php

namespace spec\Denismitr\Spam\Inspections;

use Denismitr\Spam\Contracts\Inspection;
use Denismitr\Spam\Exceptions\SpamDetected;
use Denismitr\Spam\Inspections\ForbiddenWords;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ForbiddenWordsSpec extends ObjectBehavior
{
    protected $forbidden = [
        'мразь',
        'блядь',
        'шлюха',
        'шлюхи',
        'шлюхой',
        'проститутка',
        'проститутки',
        'проституткой',
        ' хуй ',
        ' хуя ',
        ' хер ',
        'хуевый',
        'пизда',
        'сволочь',
        'пиздец',
        'наркота',
        'наркотики',
        'героин',
        'кокаин',
        'марихуана',
        'ублюдок',
        'отсосать',
        'отъебать',
        'избить',
        'жопа',
        'жопу',
        'ебать',
        ' ебло ',
        'выебать',
        'porno',
        'порно'
    ];

    function it_is_initializable()
    {
        $this->shouldHaveType(ForbiddenWords::class);
        $this->shouldImplement(Inspection::class);
    }

    function it_detects_any_forbidden_word()
    {
        foreach ($this->forbidden as $word) {
            $this->shouldThrow(SpamDetected::class)->duringDetect("Всякий текст " . $word . " ещё текст");
        }
    }

    function it_detects_any_forbidden_word_in_uppercase()
    {
        foreach ($this->forbidden as $word) {
            $word = mb_strtoupper($word);
            $this->shouldThrow(SpamDetected::class)->duringDetect("Всякий текст " . $word . " ещё текст");
        }
    }

    function it_detects_any_forbidden_word_as_part_of_text()
    {
        foreach ($this->forbidden as $word) {
            $this->shouldThrow(SpamDetected::class)->duringDetect("Всякий текст" . $word . "ещё текст");
        }
    }

    function it_should_not_throw_on_normal_text()
    {
        $this->shouldNotThrow(SpamDetected::class)->duringDetect("Всякий текст разный, и даже ещё текст");
    }
}
