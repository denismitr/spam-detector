<?php

namespace Denismitr\Spam\Inspections;

use Denismitr\Spam\Contracts\Inspection;
use Denismitr\Spam\Exceptions\SpamDetected;

class KeyHeldDown implements Inspection
{
    public function detect(string $text)
    {
        if (preg_match('/([^\s])\\1{4,}/u', $text)) {
            throw new SpamDetected("Key held down detected!");
        }
    }
}
