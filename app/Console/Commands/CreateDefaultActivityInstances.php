<?php

namespace App\Console\Commands;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CreateDefaultActivityInstances
{

    public function handle(Request $request, \Closure $next)
    {

        foreach($this->activities() as $activity) {

        }

    }

    private function activities(): Collection
    {

    }

}
