<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Hasil Perhitungan Preferensi dan Ranking</h2>

    <!-- Tabel Preferensi -->
    <h4>Preferensi</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Alternatif</th>
                <th>Preferensi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($preferensi as $kodeAlternatif => $pref): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($kodeAlternatif) ?></td>
                    <td><?= number_format($pref, 4) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Tabel Ranking -->
    <h4>Ranking</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Alternatif</th>
                <th>Ranking</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($ranking as $kodeAlternatif => $rank): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($kodeAlternatif) ?></td>
                    <td><?= $rank ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
