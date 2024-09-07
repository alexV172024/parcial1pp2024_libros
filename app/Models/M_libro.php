<?php 
namespace App\Models;

use CodeIgniter\Model;

class M_libro extends Model{
    protected $table      = 'libros';
    // Uncomment below if you want add primary key
     protected $primaryKey = 'id';

    protected $allowedFields = ['titulo','fecha_publicacion','precio','isbn'];
}