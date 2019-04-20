<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class Pincode extends Model
{
      use  Sortable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pincode';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $guarded = ['id'];
}
