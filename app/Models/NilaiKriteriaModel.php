<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiKriteriaModel extends Model
{
    protected $table = 'nilai_kriteria_alternatif';
    protected $primaryKey = 'id_nilai';
    protected $allowedFields = ['id_alternatif', 'id_kriteria', 'nilai'];

    // Fungsi untuk mengambil data gabungan dengan tabel alternatif dan kriteria
    public function getWithRelations()
    {
        return $this->select('nilai_kriteria_alternatif.*, alternatif.nama_alternatif, kriteria.nama_kriteria')
            ->join('alternatif', 'alternatif.id_alternatif = nilai_kriteria_alternatif.id_alternatif')
            ->join('kriteria', 'kriteria.id_kriteria = nilai_kriteria_alternatif.id_kriteria')
            ->orderBy('id_alternatif, id_kriteria')
            ->findAll();
    }
}
