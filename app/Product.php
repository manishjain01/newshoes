<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class Product extends Model
{
      use  Sortable;
      /*public $sortable = ['id',
                        'price',
                        'created_at',
                        'updated_at'];*/

    /**
     * The database table used by the model.
     *
     * @var string
     */
      
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
  
     protected $guarded = ['id'];
     
     public function product_color()
    {
    	return $this->hasMany('App\Productcolor');
    }
    
    public function product_image()
    {
    	return $this->hasMany('App\Productimage');
    }
    public function product_category()
    {
    	return $this->belongsTo('App\Category', 'category_id');
    }
    public function product_subcategory()
    {
    	return $this->belongsTo('App\Category', 'sub_category_id');
    }
    public function product_sub_subcategory()
    {
    	return $this->belongsTo('App\Category', 'sub_sub_category_id');
    }
}

