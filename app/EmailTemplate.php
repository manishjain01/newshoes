<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class EmailTemplate extends Model {
	use  Sortable;
    public $timestamps = true;
    protected $table = 'email_templates';
    protected $guarded = ['id'];
}
