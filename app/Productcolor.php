<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class Productcolor extends Model
{
      use  Sortable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
      
    protected $table = 'productcolors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $guarded = ['id'];
     
     public function colors(){
         return $this->belongsTo('App\Color', 'color_id');
     }
    
     
}
