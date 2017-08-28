<?php

namespace Denismitr\Spam\Inspections;

use Denismitr\Spam\Contracts\Inspection;
use Denismitr\Spam\Exceptions\SpamDetected;

class RussianBadWords implements Inspection
{
    protected $bad = [
        'сука',
        'viagra',
        'травка',
        'bitch',
        'проститутки',
        'проститутка',
        'проституткой',
        'шлюхи',
        'шлюха'
    ];

    protected $matchCount = 0;

    const LIMIT = 2;

    public function detect(string $text)
    {
        foreach ($this->getBadWords() as $word) {
            if (mb_stripos($text, $word) !== false) {
                $this->matchCount++;
            }
        }

        if ($this->numberOfMatchesExceeded()) {
            throw new SpamDetected("Number of matches of bad words exceeded.");
        }
    }

    public function getLimit() : int
    {
        return static::LIMIT;
    }

    public function getBadWords() : array
    {
        return $this->bad;
    }

    protected function numberOfMatchesExceeded() : bool
    {
        return $this->matchCount >= $this->getLimit();
    }
}
