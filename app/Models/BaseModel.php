<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {
    
    public function toArray()
    {
        $array = parent::toArray();
        foreach ($this->getMutatedAttributes() as $key)
        {
            if ( ! array_key_exists($key, $array)) {
                $array[$key] = $this->{$key};   
            }
        }
        return $array;
    }
}