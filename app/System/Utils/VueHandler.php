<?php

namespace App\System\Utils;

class VueHandler
{
    public function __construct(private readonly bool $haveVue = false)
    {
    }

    public function hasVue()
    {
        return $this->haveVue;
    }
}
