# Spam Detector

### Author 
Denis Mitrofanov

### Installation
```
composer require denismitr/spam-detector
```

### Usage

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

You can add your own inspections. They must implement ```Inspection``` interface.