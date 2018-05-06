<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreTheme extends Model
{

    protected $table = 'store_themes';
    protected $fillable = ['store_id', 'theme_id'];


    public function store()
    {
        return $this->belongsTo('App\Store');
    }

    public function theme()
    {
        return $this->belongsTo('App\Theme');
    }

}
