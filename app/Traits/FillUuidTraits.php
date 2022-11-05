<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid;

trait FillUuidTraits
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            try {
                $model->uuid = Uuid::uuid4()->toString();
            } catch (\Exception $e) {
                abort(500, $e->getMessage());
            }
        });
    }

    /**
      * Get the value indicating whether the IDs are incrementing.
      *
      * @return bool
      */
     public function getIncrementing()
     {
         return false;
     }
 
    /**
      * Get the auto-incrementing key type.
      *
      * @return string
      */
     public function getKeyType()
     {
         return 'string';
     }
}