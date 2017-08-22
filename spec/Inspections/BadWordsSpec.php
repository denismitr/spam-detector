<?php

namespace spec\Denismitr\Spam\Inspections;

use Denismitr\Spam\Contracts\Inspection;
use Denismitr\Spam\Exceptions\SpamDetected;
use Denismitr\Spam\Inspections\BadWords;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BadWordsSpec extends ObjectBehavior
{
    protected $bad;

    public function let()
    {
        $this->bad = (new BadWords())->getBadWords();
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(BadWords::class);
        $this->shouldImplement(Inspection::class);
    }

    function it_throws_if_three_bad_words_are_present_in_a_text()
    {
            $keys = array_rand($this->bad, 3);

            $this
                ->shouldThrow(SpamDetected::class)
                ->duringDetect(
                    $this->bad[$keys[0]]  .
                    "Всякий текст " .
                    $this->bad[$keys[1]] .
                    " ещё текст" .
                    $this->bad[$keys[2]] .
                    " много текста"
                );

    }

    function it_does_not_throw_if_only_2_bad_words_are_present()
    {
        $keys = array_rand($this->bad, 2);

        $this
            ->shouldNotThrow(SpamDetected::class)
            ->duringDetect(
                $this->bad[$keys[0]] .
                "Всякий текст " .
                $this->bad[$keys[1]] .
                " ещё текст" .
                " много текста"
            );
    }
}
