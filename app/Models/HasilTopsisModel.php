<?php

namespace App\Models;
use CodeIgniter\Model;

class HasilTopsisModel extends Model
{
    protected $table = 'hasil_topsis';
    protected $primaryKey = 'id_hasil';
    protected $allowedFields = ['id_alternatif', 'nilai_preferensi', 'ranking'];
    protected $returnType = 'array';
    protected $useTimestamps = false;
}
