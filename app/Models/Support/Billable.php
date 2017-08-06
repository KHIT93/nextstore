<?php

namespace App\Models\Support;

use App\Models\Address;

trait Billable
{
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
