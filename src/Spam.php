<?php

namespace Denismitr\Spam;

use Denismitr\Spam\Contracts\Inspection;
use Denismitr\Spam\Exceptions\SpamDetected;
use Psr\Log\InvalidArgumentException;

class Spam
{
    /**
     * @var array
     */
    private $inspections;

    /**
     * Spam constructor.
     * @param array $inspections
     */
    public function __construct(array $inspections)
    {
        if (empty($inspections)) {
            throw new \InvalidArgumentException("Inspections array is empty");
        }

        $this->inspections = $inspections;
    }

    /**
     * @param string $text
     */
    public function detect(string $text)
    {
        foreach ($this->inspections as $inspection) {
            $this->getInspectionInstance($inspection)->detect($text);
        }
    }

    /**
     * @param array $items
     */
    public function detectAny(array $items)
    {
        foreach ($this->inspections as $inspection) {
            $spamInspection = $this->getInspectionInstance($inspection);

            foreach ($items as $text) {
                $spamInspection->detect($text);
            }
        }
    }

    /**
     * @param array $fields
     * @throws SpamDetected
     */
    public function detectAll(array $fields)
    {
        $detected = [];

        foreach ($fields as $key => $body) {
            try {
                $this->detect($body);
            } catch (SpamDetected $e) {
                $detected[$key] = true;
            }
        }

        if ( count($detected) === count($fields) ) {
            throw new SpamDetected("Spam detected for all input fields");
        }
    }

    /**
     * @param string $text
     * @param Inspection $inspection
     */
    public function inspect(string $text, Inspection $inspection)
    {
        $inspection->detect($text);
    }

    /**
     * @param string $inspection
     * @return Inspection
     * @throws \TypeError
     */
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
}
