<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class AdminMenu extends Model
{
      use  Sortable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admin_menus';

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
        return $this->belongsTo('App\AdminMenu', 'parent_id');
    }
/*
      * get child  category  data
      *
      * */
    public function children()
    {
        return $this->hasMany('App\AdminMenu', 'parent_id');
    }
}
