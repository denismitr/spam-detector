<?php

namespace Denismitr\Spam\Contracts;


interface Inspection
{
    /**
     * @param string $text
     * @return void
     */
    public function detect(string $text);
}