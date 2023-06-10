<?php

namespace App\System\Component;

class Widget
{
    public function __construct(
        private readonly string $nomeComponente
    )
    {
    }
    public function getComponente(){
        return '<'.$this->nomeComponente.' />';
    }
}
