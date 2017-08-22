<?php

namespace spec\Denismitr\Spam;

use Denismitr\Spam\Exceptions\SpamDetected;
use Denismitr\Spam\Inspections\ForbiddenWords;
use Denismitr\Spam\Inspections\KeyHeldDown;
use Denismitr\Spam\Inspections\YahooCustomerSupport;
use Denismitr\Spam\Spam;
use PhpSpec\ObjectBehavior;

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
        $this->beConstructedWith([Spam::class]);
        $this->shouldThrow('\TypeError')->duringDetect("Yahoo customer support");
    }

    function it_should_throw_type_error_if_none_is_given_on_construction()
    {
        $this->shouldThrow('\TypeError')->duringInstantiation();
    }

    function it_is_initializable_with_inspections_interface_array()
    {
        $this->beConstructedWith([
            YahooCustomerSupport::class,
            ForbiddenWords::class,
            KeyHeldDown::class
        ]);

        $this->shouldHaveType(Spam::class);
    }

    function it_can_detect_spam_according_to_a_passed_inspections()
    {
        $this->beConstructedWith([
            YahooCustomerSupport::class,
            ForbiddenWords::class,
            KeyHeldDown::class
        ]);

        $this->shouldThrow(SpamDetected::class)->duringDetect("Yahoo customer support");
    }

    function it_can_detect_any_spam_according_to_a_passed_inspections()
    {
        $this->beConstructedWith([
            YahooCustomerSupport::class,
            ForbiddenWords::class,
            KeyHeldDown::class
        ]);

        $this->shouldThrow(SpamDetected::class)->duringDetectAny([
            'title' => "Yahoo customer support",
            'body' => 'Not a spam'
        ]);
    }

    function it_can_detect_forbidden_words()
    {
        $this->beConstructedWith([
            YahooCustomerSupport::class,
            ForbiddenWords::class,
            KeyHeldDown::class
        ]);

        $words = (new ForbiddenWords)->getForbiddenWords();

        foreach ($words as $word) {
            $this->shouldThrow(SpamDetected::class)->duringDetect("Всякий текст " . $word . " ещё текст");
        }
    }

    function it_does_not_throw_on_normal_text()
    {
        $this->beConstructedWith([
            YahooCustomerSupport::class,
            ForbiddenWords::class,
            KeyHeldDown::class
        ]);

        $text = "Существует пять видов живописи: станковая, 
            монументальная, декоративная, театрально-декоративная, миниатюрная[1]. 
            К станковой живописи относят произведения, существующие независимо от места создания. 
            В основном это картины, созданные на мольберте (то есть на станке) художника. 
            В станковой живописи преобладают работы, выполненные масляными красками, 
            но могут использоваться и другие красители (темпера, акриловые краски и т. д.). 
            Картины пишутся в основном на холсте, натянутом на раму или наклеенном на картон. 
            В прошлом широко применялись деревянные доски, могут использоваться любые плоские материалы. 
            Монументальная живопись выполняется непосредственно на стенах и потолках зданий и других сооружений. 
            В прошлом преобладала живопись водными красками по сырой штукатурке (фреска). 
            В Италии до начала XVI века по высохшей «чистой фреске» практиковалась прописка деталей темперой. 
            Техника «чистой фрески» требует особого мастерства от художника, поэтому применялись и другие технологии, например, 
            не такая устойчивая живопись по сухой штукатурке — секко, позднее росписи выполнялись малоподходящими для 
            монументальной живописи масляными красками. 
            Цветные изображения на бумаге (акварель, гуашь, пастель и др.) формально (например, по месту в коллекции) 
            относят к графике, но эти произведения часто рассматриваются и как живописные. 
            Все другие способы цветного изображения относятся к графике, в том числе и изображения, 
            созданные с помощью компьютерных технологий. Наиболее распространены произведения живописи, выполненные на 
            плоских или почти плоских поверхностях, таких как натянутый на подрамник холст, дерево, полотно, 
            обработанные поверхности стен и т. д. Существует также узкая трактовка термина живопись как работ, 
            выполненных масляными красками на холсте, картоне, оргалите и других подобных материалах.";

        $this->shouldNotThrow(SpamDetected::class)->duringDetect($text);
    }
}
