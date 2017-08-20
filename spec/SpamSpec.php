<?php

namespace spec\Denismitr\Spam;

use Denismitr\Spam\Exceptions\SpamDetected;
use Denismitr\Spam\Inspections\YahooCustomerSupport;
use Denismitr\Spam\Spam;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SpamSpec extends ObjectBehavior
{
    function it_should_throw_an_exception_if_empty_array_of_inspections_is_given()
    {
        $this->beConstructedWith([]);
        $this->shouldThrow('\InvalidArgumentException')->duringInstantiation();
    }

    function it_should_throw_an_exception_if_wrong_args_of_inspections_is_given()
    {
        $this->beConstructedWith(['crap_class', 'crapSuperClass']);
        $this->shouldThrow('\InvalidArgumentException')->duringDetect("Yahoo customer support");
    }

    function it_should_throw_an_exception_if_wrong_classed_of_inspections_is_given()
    {
        $this->beConstructedWith(['Denismitr\Spam\Spam']);
        $this->shouldThrow('\TypeError')->duringDetect("Yahoo customer support");
    }

    function it_should_throw_type_error_if_none_is_given_on_construction()
    {
        $this->shouldThrow('\TypeError')->duringInstantiation();
    }

    function it_is_initializable_with_inspections_interface_array()
    {
        $this->beConstructedWith([
            YahooCustomerSupport::class
        ]);

        $this->shouldHaveType(Spam::class);
    }

    function it_can_detect_spam_according_to_a_passed_inspections()
    {
        $this->beConstructedWith([
            YahooCustomerSupport::class
        ]);

        $this->shouldThrow(SpamDetected::class)->duringDetect("Yahoo customer support");
    }

    function it_can_detect_any_spam_according_to_a_passed_inspections()
    {
        $this->beConstructedWith([
            YahooCustomerSupport::class
        ]);

        $this->shouldThrow(SpamDetected::class)->duringDetectAny([
            'title' => "Yahoo customer support",
            'body' => 'Not a spam'
        ]);
    }
}
