<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{

    protected $table = 'themes';
    protected $fillable = ['title', 'description', 'folder_name', 'is_free'];


    public function stores()
    {
        return $this->hasMany('App\Store');
    }


    public function getPreviewAttribute()
    {
    	return url('') . '/themes/' . $this->attributes['folder_name'] . '/preview.jpg';
    }


}
