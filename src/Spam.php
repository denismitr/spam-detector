<?php

namespace Denismitr\Spam;

use Denismitr\Spam\Contracts\Inspection;
use Psr\Log\InvalidArgumentException;

class Spam
{
    private $inspections;

    public function __construct(array $inspections)
    {
        if (empty($inspections)) {
            throw new \InvalidArgumentException("Inspections array is empty");
        }

        $this->inspections = $inspections;
    }

    public function detect(string $text)
    {
        foreach ($this->inspections as $inspection) {
            $this->getInspectionInstance($inspection)->detect($text);
        }
    }

    private function getInspectionInstance(string $inspection) : Inspection
    {
        if ( ! class_exists($inspection) ) {
            throw new InvalidArgumentException("{$inspection} class does not exist!");
        }

        $instance = new $inspection;

        if ( ! $instance instanceof Inspection ) {
            throw new \TypeError("{$inspection} does not implement the Inspection interface");
        }

        return $instance;
    }

    public function detectAny(array $items)
    {
        foreach ($this->inspections as $inspection) {
            $spamInspection = $this->getInspectionInstance($inspection);

            foreach ($items as $text) {
                $spamInspection->detect($text);
            }
        }
    }
}
