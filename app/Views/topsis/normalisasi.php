<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Hasil Normalisasi</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode Alternatif</th>
                <th>Kode Kriteria</th>
                <th>Nilai Normalisasi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($normalisasi)): ?>
                <?php foreach ($normalisasi as $row): ?>
                    <tr>
                        <td><?= esc($row['kode_alternatif']) ?></td>
                        <td><?= esc($row['kode_kriteria']) ?></td>
                        <td><?= esc(number_format($row['nilai_normalisasi'], 4)) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">Data tidak ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
