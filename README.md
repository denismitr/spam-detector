# Spam Detector

### Author
Denis Mitrofanov

### Installation
```
composer require denismitr/spam-detector
```

### Usage

You can pass as many inspections as you want to the ```Denismitr\Spam\Spam``` class constructor. Every inspection must implement ```Denismitr\Spam\Contracts\Inspection``` interface. Right now, out of the box, you get __6__ of them:

* Denismitr\Spam\Inspections\AsciiOnly
* Denismitr\Spam\Inspections\YahooCustomerSupport
* Denismitr\Spam\Inspections\RussianForbiddenWords
* Denismitr\Spam\Inspections\RussianBadWords
* Denismitr\Spam\Inspections\KeyHeldDown
* Denismitr\Spam\Inspections\EnglishForbiddenWords

An example of usage:

```
$text = "Some text to check";

$spam = new Spam([
    YahooCustomerSupport::class,
    RussianForbiddenWords::class,
    RussianBadWords::class,
    KeyHeldDown::class
]);

try {
    $spam->detect($text);
} catch(SpamDetected $e) {
    // Do stuff
}
```

or to see if  any of the given fields contain spam use ```detectAny`` method

```
try {
    $spam->detectAny([
        'title' => 'Some title...',
        'body' => 'Some body...'
    ]);
} catch(SpamDetected $e) {
    // Do stuff
}
```

This method will __throw__ if any of the given fields contain spam.

And, of course, if you need, another method ```detectAll``` will throw if all fields contain
spam:

```
try {
    $spam->detectAll([
        'title' => 'Some title...',
        'body' => 'Some body...'
    ]);
} catch(SpamDetected $e) {
    // Do stuff
}
```
-----------------------------------------------------------------------------------
Another usecase is when you want to check against only one inspection. For this case there is
a static method __inspect__ that accepts a string for a haystack and the Inspection __instance__ like so:

$text = 'Some text to check';

try {
    Spam::inspect($text, new KeyHeldDown);
} catch(SpamDetected $e) {
    // Do stuff
}

------------------------------------------------------------------------------------

You can easily add your own inspections. They must implement ```Inspection``` interface. That
looks like so:

```
interface Inspection
{
    /**
     * @param string $text
     * @return void
     */
    public function detect(string $text);
}
```
