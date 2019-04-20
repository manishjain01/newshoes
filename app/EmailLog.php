<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class EmailLog extends Model {
       public $timestamps = true;
    use  Sortable;
    protected $table = 'email_logs';
    protected $guarded = ['id'];
     protected $sortable = ['id',
                           'email_to',
                           'email_from',
                           'email_type',
                           'subject',
                           'created_at',
                           ];

}
