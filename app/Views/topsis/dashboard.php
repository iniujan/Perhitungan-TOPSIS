<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Informasi Jurnal -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h3>Informasi Sistem</h3>
        </div>
        <div class="card-body">
            <p>
                Proses seleksi penerima beasiswa <b>Bidikmisi</b> sering kali menghadapi tantangan terkait efisiensi dan objektivitas. 
                Metode manual yang selama ini digunakan membutuhkan waktu lama, kurang akurat, dan rentan terhadap subjektivitas. 
            </p>
            <p>
                Untuk mengatasi permasalahan tersebut, metode <b>TOPSIS (Technique for Order Preference by Similarity to Ideal Solution)</b> diterapkan dalam sistem ini. 
                Metode ini bertujuan untuk membantu proses pengambilan keputusan yang lebih objektif dengan cara menentukan alternatif terbaik berdasarkan kriteria yang telah ditentukan, seperti:
            </p>
            <ul>
                <li>Pekerjaan dan penghasilan orang tua</li>
                <li>Prestasi akademik</li>
                <li>Prestasi non-akademik</li>
                <li>Jarak tempat tinggal</li>
            </ul>
            <p>
                Dengan sistem ini, proses seleksi penerima beasiswa dapat dilakukan dengan lebih cepat, tepat, dan sesuai dengan persyaratan yang ditetapkan, sekaligus meminimalisasi penerima yang tidak memenuhi kriteria.
            </p>
        </div>
    </div>

    <!-- Kartu Statistik -->
    <div class="row">
        <!-- Card Data Alternatif -->
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Data Alternatif</h5>
                    <p class="card-text display-6"><?= count($alternatif) ?></p>
                    <a href="<?= site_url('topsis/alternatif') ?>" class="btn btn-light">More info →</a>
                </div>
            </div>
        </div>

        <!-- Card Data Kriteria -->
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Data Kriteria</h5>
                    <p class="card-text display-6"><?= count($kriteria) ?></p>
                    <a href="<?= site_url('topsis/kriteria') ?>" class="btn btn-light">More info →</a>
                </div>
            </div>
        </div>

        <!-- Card Normalisasi -->
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Data Normalisasi</h5>
                    <p class="card-text display-6">-</p>
                    <a href="<?= site_url('topsis/normalisasi') ?>" class="btn btn-light">More info →</a>
                </div>
            </div>
        </div>

        <!-- Card Hasil Perankingan -->
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Hasil Perankingan</h5>
                    <p class="card-text display-6">-</p>
                    <a href="<?= site_url('topsis/hasil_preferensi_ranking') ?>" class="btn btn-light">More info →</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
