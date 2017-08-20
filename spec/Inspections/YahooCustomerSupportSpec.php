<?php

namespace spec\Denismitr\Spam\Inspections;

use Denismitr\Spam\Exceptions\SpamDetected;
use Denismitr\Spam\Inspections\YahooCustomerSupport;
use Denismitr\Spam\Contracts\Inspection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class YahooCustomerSupportSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(YahooCustomerSupport::class);
        $this->shouldImplement(Inspection::class);
    }

    public function it_can_detect_spam()
    {
        $this->shouldThrow(SpamDetected::class)->duringDetect("Yahoo customer support");
    }

    public function it_can_detect_spam_on_utf8()
    {
        $this->shouldThrow(SpamDetected::class)->duringDetect("Наш Yahoo customer support тут");
    }

    public function it_does_not_throw_on_no_spam()
    {
        $this->shouldNotThrow(SpamDetected::class)->duringDetect("Наша ссылка тут");
    }
}
