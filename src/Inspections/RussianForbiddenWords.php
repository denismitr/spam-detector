<?php

namespace Denismitr\Spam\Inspections;

use Denismitr\Spam\Contracts\Inspection;
use Denismitr\Spam\Exceptions\SpamDetected;

class RussianForbiddenWords implements Inspection
{
    protected $forbidden = [
        'мразь',
        'блядь',
        'хуй',
        'херов',
        'на хер',
        ' хуя ',
        ' хер ',
        'хуевый',
        'пизда',
        'пизду',
        'пиздой',
        'сволочь',
        'скотина',
        'скатина',
        'паскуда',
        ' ебло ',
        'сучий',
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
        'бесплатное порно',
        'лучшее порно',
        'дешевые шлюхи',
        'лучшие шлюхи',
        'шлюхи москвы',
        'ночь со шлюхой',
        'трахнуть шлюхю',
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
