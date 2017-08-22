<?php

namespace Denismitr\Spam\Inspections;

use Denismitr\Spam\Contracts\Inspection;
use Denismitr\Spam\Exceptions\SpamDetected;

class ForbiddenWords implements Inspection
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
