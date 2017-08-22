<?php

namespace Denismitr\Spam\Inspections;

use Denismitr\Spam\Contracts\Inspection;
use Denismitr\Spam\Exceptions\SpamDetected;

class AsciiOnly implements Inspection
{

    public function detect(string $text)
    {
        if (mb_check_encoding($text, 'ASCII')) {
            throw new SpamDetected("Ascii only text detected.");
        }
    }
}
