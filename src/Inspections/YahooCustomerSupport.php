<?php

namespace Denismitr\Spam\Inspections;

use Denismitr\Spam\Contracts\Inspection;
use Denismitr\Spam\Exceptions\SpamDetected;

class YahooCustomerSupport implements Inspection
{
    public function detect(string $text)
    {
        if ( mb_stripos($text, 'Yahoo customer support') !== false ) {
            throw new SpamDetected;
        }
    }
}
