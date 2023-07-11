<?php

namespace App\System\Component;

class Widget
{
    public function __construct(
        private readonly string $nomeComponente,
        private readonly int $size = 4
    )
    {
    }
    public function getComponente(){
        return '<'.$this->nomeComponente.' />';
    }
    public function getSize(){
        return $this->size;
    }
}
