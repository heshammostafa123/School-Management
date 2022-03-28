<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Foundation\Auth\User as Authenticatable;
class My_Parent extends Authenticatable
{
    use HasTranslations;
    public $translatable = ['Name_Father','Job_Father','Name_Mother','Job_Mother'];
    protected $table = 'my__parents';
    protected $guarded=[];

    // علاقة بين الاب والصور لجلب اسم الصور  
    public function images()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }
}
