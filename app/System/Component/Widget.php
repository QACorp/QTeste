<?php

namespace App\System\Component;

class Widget
{
    public function __construct(
        private readonly string $nomeComponente,
        private readonly int $size = 4,
        private readonly array $parameters = []
    )
    {
    }
    public function getComponente(){
        $parameters = '';
        foreach($this->parameters as $key => $value){
            $parameters .= ' :'.$key.'="'.$value.'"';
        }
        return '<'.$this->nomeComponente.' '.$parameters.' />';
    }
    public function getSize(){
        return $this->size;
    }
}
