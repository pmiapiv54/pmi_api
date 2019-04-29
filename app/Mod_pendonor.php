<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Mod_pendonor extends Model
{
   protected $connection = 'mysql';
   protected $table = 'pendonor'; //nama table yang kita buat lewat migration adalah todo
   protected $primaryKey  = 'Kode';
   public $timestamps = false;
   protected $fillable = [
      'Kode',
      'TglLhr',
      'Kode_lama',
      'NoKTP',
      'Telp' ,
      'Status',
      'Call' ,
      'title' ,
      'jns' ,
      'sukubangsa',
      'ibukandung',
      'pencatat' ,
      'up',
      'Nama',
      'telp2',
      'TempatLhr',
      'Jk',
      'Rhesus',
      'ketdarah',
      'GolDarah',
      'Pekerjaan',
      'Email',
      'Alamat',
      'kelurahan',
      'kecamatan',
      'wilayah',
      'KodePos',
      'umur',
      'mu',
      'instansi',
      'tanggal_cetak',
      'tglkembali_apheresis',
      'tanggal_entry',
      'abs',
      'waktu_update',
      'instansi',
  ];
}

?>