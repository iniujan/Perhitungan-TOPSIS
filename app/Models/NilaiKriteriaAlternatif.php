<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiKriteriaAlternatif extends Model
{
    protected $table = 'nilai_kriteria_alternatif'; // Nama tabel
    protected $primaryKey = 'id_nilai'; // Primary key tabel
    protected $allowedFields = ['id_alternatif', 'id_kriteria', 'nilai']; // Kolom yang dapat diisi

    // Fungsi untuk mendapatkan data dengan join ke tabel alternatif dan kriteria
    public function getWithRelations()
    {
        return $this->select('nilai_kriteria_alternatif.*, alternatif.nama_alternatif, kriteria.nama_kriteria')
            ->join('alternatif', 'alternatif.id_alternatif = nilai_kriteria_alternatif.id_alternatif')
            ->join('kriteria', 'kriteria.id_kriteria = nilai_kriteria_alternatif.id_kriteria')
            ->orderBy('id_alternatif, id_kriteria')
            ->findAll();
    }
}
