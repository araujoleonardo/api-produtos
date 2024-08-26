<?php

namespace App\Trait;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

trait HasFile
{
    /**
     * @return Attribute
     */
    public function imageUrl(): Attribute
    {
        return Attribute::get(function () {
            if (!$this->image) {
                return null;
            }

            // Retornar a URL da imagem armazenada localmente
            //return Storage::disk('public')->url($this->image);

            return Storage::url($this->image);
        });
    }
}
