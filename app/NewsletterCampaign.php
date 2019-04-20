<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class NewsletterCampaign extends Model
{
	use  Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'newsletter_campaigns';

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
     public function newsletterName()
    {
        return $this->belongsTo('App\Newsletters', 'newsletter_id');
    }

}
