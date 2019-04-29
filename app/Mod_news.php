<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Mod_news extends Model
{
   protected $connection = 'mysql2';
   protected $table = 'data_news as dn'; //nama table yang kita buat lewat migration adalah todo
}

?>