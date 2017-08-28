<?php

namespace Denismitr\Spam\Inspections;

use Denismitr\Spam\Contracts\Inspection;
use Denismitr\Spam\Exceptions\SpamDetected;

class EnglishForbiddenWords implements Inspection
{
    protected $forbidden = [
        'best porn',
        'free porn',
        'whores',
        'fucking',
        'fuck',
        'shit',
        'free sex',
        'blow job',
        'asshole',
        'poop'
    ];

    public function detect(string $text)
    {
        foreach ($this->getForbiddenWords() as $word) {
            if (mb_stripos($text, $word) !== false) {
                throw new SpamDetected("Forbidden word detected!");
            }
        }
    }

    public function getForbiddenWords()
    {
        return $this->forbidden;
    }
}
