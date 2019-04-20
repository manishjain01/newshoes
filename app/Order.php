<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Order extends Model {

    use Sortable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /*public function products() {
        return $this->belongsTo('App\Product', 'product_id');
    }*/

    public function order_detail()
    {
    	return $this->hasMany('App\Orderdetail', 'order_id');
    }
    
    
}
