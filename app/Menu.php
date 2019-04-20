<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class Menu extends Model
{
      use  Sortable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'menus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $guarded = ['id'];
     
     
     /*
      * get parent category  data
      *
      * */
     public function parent()
    {
        return $this->belongsTo('App\Menu', 'parent_id');
    }
/*
      * get child  category  data
      *
      * */
    public function children()
    {
        return $this->hasMany('App\Menu', 'parent_id');
    }
}
