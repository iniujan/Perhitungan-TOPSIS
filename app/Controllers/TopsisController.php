<?php

namespace App\Controllers;

use App\Models\AlternatifModel;
use App\Models\KriteriaModel;
use App\Models\NilaiKriteriaAlternatif;

class TopsisController extends BaseController
{
    public function index()
    {
        // Ambil data untuk dashboard
        $alternatifModel = new AlternatifModel();
        $kriteriaModel = new KriteriaModel();

        $data = [
            'alternatif' => $alternatifModel->findAll(),
            'kriteria' => $kriteriaModel->findAll(),
        ];

        // Tampilkan view dashboard
        return view('topsis/dashboard', $data);
    }

    public function alternatif()
    {
        // Ambil data alternatif
        $alternatifModel = new AlternatifModel();
        $data['alternatif'] = $alternatifModel->findAll();

        // Tampilkan view alternatif
        return view('topsis/alternatif', $data);
    }

    public function kriteria()
    {
        // Ambil data kriteria
        $kriteriaModel = new KriteriaModel();
        $data['kriteria'] = $kriteriaModel->findAll();

        // Tampilkan view kriteria
        return view('topsis/kriteria', $data);
    }

    public function normalisasi()
    {
        $db = \Config\Database::connect();
        // $query = $db->table('nilai_kriteria_alternatif')
        //     ->select('id_kriteria, id_alternatif, nilai')
        //     ->get();

        $query = $db->query("SELECT nilai_kriteria_alternatif.*, alternatif.kode_alternatif, kriteria.kode_kriteria 
                            FROM nilai_kriteria_alternatif, alternatif, kriteria 
                            WHERE nilai_kriteria_alternatif.id_alternatif = alternatif.id_alternatif
                            AND nilai_kriteria_alternatif.id_kriteria = kriteria.id_kriteria");

        $nilaiKriteria = $query->getResultArray();

        $normalisasi = [];
        $sumSquares = [];

        // Hitung total kuadrat untuk setiap kriteria
        foreach ($nilaiKriteria as $nilai) {
            if (!isset($sumSquares[$nilai['id_kriteria']])) {
                $sumSquares[$nilai['id_kriteria']] = 0;
            }
            $sumSquares[$nilai['id_kriteria']] += pow($nilai['nilai'], 2);
        }

        // Normalisasi nilai
        foreach ($nilaiKriteria as $nilai) {
            $normalisasi[] = [
                'kode_alternatif' => $nilai['kode_alternatif'],
                'kode_kriteria' => $nilai['kode_kriteria'],
                'nilai_normalisasi' => $nilai['nilai'] / sqrt($sumSquares[$nilai['id_kriteria']]),
            ];
        }

        $data['normalisasi'] = $normalisasi;

        return view('topsis/normalisasi', $data);
    }

    public function matriksKeputusan()
    {
        $nilaiKriteriaModel = new NilaiKriteriaAlternatif(); // Pakai model NilaiKriteriaAlternatif
        $data['matriks_keputusan'] = $nilaiKriteriaModel->getWithRelations();

        return view('topsis/matriks_keputusan', $data);
    }

    public function normalisasiTerbobot()
    {
        $db = \Config\Database::connect();
        // $query = $db->table('nilai_kriteria_alternatif')
        //     ->select('id_kriteria, id_alternatif, nilai')
        //     ->get();

        $query = $db->query("SELECT nilai_kriteria_alternatif.*, alternatif.kode_alternatif, kriteria.kode_kriteria, kriteria.bobot
                            FROM nilai_kriteria_alternatif, alternatif, kriteria 
                            WHERE nilai_kriteria_alternatif.id_alternatif = alternatif.id_alternatif
                            AND nilai_kriteria_alternatif.id_kriteria = kriteria.id_kriteria");

        $nilaiKriteria = $query->getResultArray();

        $normalisasi = [];
        $sumSquares = [];

        // Hitung total kuadrat untuk setiap kriteria
        foreach ($nilaiKriteria as $nilai) {
            if (!isset($sumSquares[$nilai['id_kriteria']])) {
                $sumSquares[$nilai['id_kriteria']] = 0;
            }
            $sumSquares[$nilai['id_kriteria']] += pow($nilai['nilai'], 2);
        }

        // Normalisasi nilai
        foreach ($nilaiKriteria as $nilai) {
            $normalisasi[] = [
                'kode_alternatif' => $nilai['kode_alternatif'],
                'kode_kriteria' => $nilai['kode_kriteria'],
                'nilai_normalisasi_terbobot' => ($nilai['nilai'] / sqrt($sumSquares[$nilai['id_kriteria']]) * $nilai['bobot']),
            ];
        }

        $data['normalisasi'] = $normalisasi;

        return view('topsis/normalisasi_terbobot', $data);
    }

    public function nilaiIdeal()
    {
        $db = \Config\Database::connect();

        // Ambil data normalisasi terbobot
        $query = $db->query("SELECT nilai_kriteria_alternatif.id_alternatif, alternatif.kode_alternatif, kriteria.kode_kriteria, kriteria.bobot, 
                            nilai_kriteria_alternatif.nilai
                            FROM nilai_kriteria_alternatif
                            INNER JOIN alternatif ON nilai_kriteria_alternatif.id_alternatif = alternatif.id_alternatif
                            INNER JOIN kriteria ON nilai_kriteria_alternatif.id_kriteria = kriteria.id_kriteria");
        $nilaiKriteria = $query->getResultArray();

        // Ambil data kriteria untuk mengetahui apakah cost atau benefit
        $queryKriteria = $db->query("SELECT kode_kriteria, tipe_kriteria FROM kriteria");
        $tipeKriteria = [];
        foreach ($queryKriteria->getResultArray() as $kriteria) {
            $tipeKriteria[$kriteria['kode_kriteria']] = $kriteria['tipe_kriteria'];
        }

        // Menyimpan nilai normalisasi terbobot
        $normalisasiTerbobot = [];
        $sumSquares = [];
        $idealPositif = [];
        $idealNegatif = [];

        // Hitung total kuadrat untuk normalisasi
        foreach ($nilaiKriteria as $nilai) {
            if (!isset($sumSquares[$nilai['kode_kriteria']])) {
                $sumSquares[$nilai['kode_kriteria']] = 0;
            }
            $sumSquares[$nilai['kode_kriteria']] += pow($nilai['nilai'], 2);
        }

        // Normalisasi dan hitung normalisasi terbobot
        foreach ($nilaiKriteria as $nilai) {
            $normalisasiTerbobot[] = [
                'kode_alternatif' => $nilai['kode_alternatif'],
                'kode_kriteria' => $nilai['kode_kriteria'],
                'nilai_terbobot' => ($nilai['nilai'] / sqrt($sumSquares[$nilai['kode_kriteria']])) * $nilai['bobot'],
            ];
        }

        // Proses untuk menentukan nilai ideal positif (D+) dan negatif (D-)
        foreach ($normalisasiTerbobot as $nt) {
            $kodeKriteria = $nt['kode_kriteria'];
            $nilaiTerbobot = $nt['nilai_terbobot'];

            // Tentukan apakah kriteria adalah cost atau benefit
            if ($tipeKriteria[$kodeKriteria] === 'benefit') {
                // Untuk kriteria benefit, ambil nilai maksimum untuk D+ dan nilai minimum untuk D-
                if (!isset($idealPositif[$kodeKriteria]) || $nilaiTerbobot > $idealPositif[$kodeKriteria]) {
                    $idealPositif[$kodeKriteria] = $nilaiTerbobot;
                }
                if (!isset($idealNegatif[$kodeKriteria]) || $nilaiTerbobot < $idealNegatif[$kodeKriteria]) {
                    $idealNegatif[$kodeKriteria] = $nilaiTerbobot;
                }
            } elseif ($tipeKriteria[$kodeKriteria] === 'cost') {
                // Untuk kriteria cost, ambil nilai minimum untuk D+ dan nilai maksimum untuk D-
                if (!isset($idealPositif[$kodeKriteria]) || $nilaiTerbobot < $idealPositif[$kodeKriteria]) {
                    $idealPositif[$kodeKriteria] = $nilaiTerbobot;
                }
                if (!isset($idealNegatif[$kodeKriteria]) || $nilaiTerbobot > $idealNegatif[$kodeKriteria]) {
                    $idealNegatif[$kodeKriteria] = $nilaiTerbobot;
                }
            }
        }

        // Hitung jarak ideal untuk setiap alternatif
        $jarakIdeal = [];
        foreach ($normalisasiTerbobot as $nt) {
            $kodeAlternatif = $nt['kode_alternatif'];
            $kodeKriteria = $nt['kode_kriteria'];
            if (!isset($jarakIdeal[$kodeAlternatif])) {
                $jarakIdeal[$kodeAlternatif] = ['positif' => 0, 'negatif' => 0];
            }

            // Hitung jarak dari nilai ideal positif dan negatif
            $jarakIdeal[$kodeAlternatif]['positif'] += pow($nt['nilai_terbobot'] - $idealPositif[$kodeKriteria], 2);
            $jarakIdeal[$kodeAlternatif]['negatif'] += pow($nt['nilai_terbobot'] - $idealNegatif[$kodeKriteria], 2);
        }

        // Ambil hasil jarak ideal dan hitung akarnya
        foreach ($jarakIdeal as $kodeAlternatif => $jarak) {
            $jarakIdeal[$kodeAlternatif]['positif'] = sqrt($jarak['positif']);
            $jarakIdeal[$kodeAlternatif]['negatif'] = sqrt($jarak['negatif']);
        }

        // Kirim data ke view
        $data['jarakIdeal'] = $jarakIdeal;
        $data['idealPositif'] = $idealPositif; // Menambahkan nilai ideal positif
        $data['idealNegatif'] = $idealNegatif; // Menambahkan nilai ideal negatif
        return view('topsis/jarak_ideal', $data);
    }


    public function preferensiRanking()
    {
        $db = \Config\Database::connect();

        // Ambil data normalisasi terbobot
        $query = $db->query("SELECT nilai_kriteria_alternatif.id_alternatif, alternatif.kode_alternatif, kriteria.kode_kriteria, kriteria.bobot, 
                            nilai_kriteria_alternatif.nilai
                            FROM nilai_kriteria_alternatif
                            INNER JOIN alternatif ON nilai_kriteria_alternatif.id_alternatif = alternatif.id_alternatif
                            INNER JOIN kriteria ON nilai_kriteria_alternatif.id_kriteria = kriteria.id_kriteria");
        $nilaiKriteria = $query->getResultArray();

        // Ambil data kriteria untuk mengetahui apakah cost atau benefit
        $queryKriteria = $db->query("SELECT kode_kriteria, tipe_kriteria FROM kriteria");
        $tipeKriteria = [];
        foreach ($queryKriteria->getResultArray() as $kriteria) {
            $tipeKriteria[$kriteria['kode_kriteria']] = $kriteria['tipe_kriteria'];
        }

        // Menyimpan nilai normalisasi terbobot
        $normalisasiTerbobot = [];
        $sumSquares = [];
        $idealPositif = [];
        $idealNegatif = [];

        // Hitung total kuadrat untuk normalisasi
        foreach ($nilaiKriteria as $nilai) {
            if (!isset($sumSquares[$nilai['kode_kriteria']])) {
                $sumSquares[$nilai['kode_kriteria']] = 0;
            }
            $sumSquares[$nilai['kode_kriteria']] += pow($nilai['nilai'], 2);
        }

        // Normalisasi dan hitung normalisasi terbobot
        foreach ($nilaiKriteria as $nilai) {
            $normalisasiTerbobot[] = [
                'kode_alternatif' => $nilai['kode_alternatif'],
                'kode_kriteria' => $nilai['kode_kriteria'],
                'nilai_terbobot' => ($nilai['nilai'] / sqrt($sumSquares[$nilai['kode_kriteria']])) * $nilai['bobot'],
            ];
        }

        // Proses untuk menentukan nilai ideal positif (D+) dan negatif (D-)
        foreach ($normalisasiTerbobot as $nt) {
            $kodeKriteria = $nt['kode_kriteria'];
            $nilaiTerbobot = $nt['nilai_terbobot'];

            // Tentukan apakah kriteria adalah cost atau benefit
            if ($tipeKriteria[$kodeKriteria] === 'benefit') {
                // Untuk kriteria benefit, ambil nilai maksimum untuk D+ dan nilai minimum untuk D-
                if (!isset($idealPositif[$kodeKriteria]) || $nilaiTerbobot > $idealPositif[$kodeKriteria]) {
                    $idealPositif[$kodeKriteria] = $nilaiTerbobot;
                }
                if (!isset($idealNegatif[$kodeKriteria]) || $nilaiTerbobot < $idealNegatif[$kodeKriteria]) {
                    $idealNegatif[$kodeKriteria] = $nilaiTerbobot;
                }
            } elseif ($tipeKriteria[$kodeKriteria] === 'cost') {
                // Untuk kriteria cost, ambil nilai minimum untuk D+ dan nilai maksimum untuk D-
                if (!isset($idealPositif[$kodeKriteria]) || $nilaiTerbobot < $idealPositif[$kodeKriteria]) {
                    $idealPositif[$kodeKriteria] = $nilaiTerbobot;
                }
                if (!isset($idealNegatif[$kodeKriteria]) || $nilaiTerbobot > $idealNegatif[$kodeKriteria]) {
                    $idealNegatif[$kodeKriteria] = $nilaiTerbobot;
                }
            }
        }

        // Hitung jarak ideal untuk setiap alternatif
        $jarakIdeal = [];
        foreach ($normalisasiTerbobot as $nt) {
            $kodeAlternatif = $nt['kode_alternatif'];
            $kodeKriteria = $nt['kode_kriteria'];
            if (!isset($jarakIdeal[$kodeAlternatif])) {
                $jarakIdeal[$kodeAlternatif] = ['positif' => 0, 'negatif' => 0];
            }

            // Hitung jarak dari nilai ideal positif dan negatif
            $jarakIdeal[$kodeAlternatif]['positif'] += pow($nt['nilai_terbobot'] - $idealPositif[$kodeKriteria], 2);
            $jarakIdeal[$kodeAlternatif]['negatif'] += pow($nt['nilai_terbobot'] - $idealNegatif[$kodeKriteria], 2);
        }

        // Ambil hasil jarak ideal dan hitung akarnya
        foreach ($jarakIdeal as $kodeAlternatif => $jarak) {
            $jarakIdeal[$kodeAlternatif]['positif'] = sqrt($jarak['positif']);
            $jarakIdeal[$kodeAlternatif]['negatif'] = sqrt($jarak['negatif']);
        }

        // Menghitung preferensi untuk setiap alternatif
        $preferensi = [];
        foreach ($jarakIdeal as $kodeAlternatif => $jarak) {
            // Menghindari pembagian dengan nol
            if ($jarak['positif'] + $jarak['negatif'] != 0) {
                $preferensi[$kodeAlternatif] = $jarak['negatif'] / ($jarak['positif'] + $jarak['negatif']);
            } else {
                $preferensi[$kodeAlternatif] = 0; // Jika pembagi adalah nol, set preferensi ke 0
            }
        }

        // Sorting berdasarkan preferensi (ranking) dari preferensi terbesar ke terkecil
        arsort($preferensi);

        // Menghitung ranking untuk setiap alternatif
        $ranking = [];
        $rank = 1;
        foreach ($preferensi as $kodeAlternatif => $preferensiValue) {
            $ranking[$kodeAlternatif] = $rank++; // Urutkan berdasarkan nilai preferensi tertinggi
        }

        // Kirim data ke view
        $data['preferensi'] = $preferensi;
        $data['ranking'] = $ranking;
        return view('topsis/hasil_preferensi_ranking', $data);
    }
}
