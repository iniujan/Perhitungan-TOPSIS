<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Hasil Perhitungan Jarak Ideal</h2>

    <?php if (!empty($jarakIdeal)): ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Alternatif</th>
                <th>C1: Kadar Air - D+</th>
                <th>C2: Kadar Kotoran - D+</th>
                <th>C3: Serangga Hidup - D+</th>
                <th>C4: Biji Berbau Busuk - D+</th>
                <th>C5: Ukuran Biji - D+</th>
                <th>C6: Nilai Cacat - D+</th>
                <th>C1: Kadar Air - D-</th>
                <th>C2: Kadar Kotoran - D-</th>
                <th>C3: Serangga Hidup - D-</th>
                <th>C4: Biji Berbau Busuk - D-</th>
                <th>C5: Ukuran Biji - D-</th>
                <th>C6: Nilai Cacat - D-</th>
                <th>Jarak Ideal Positif (D+)</th>
                <th>Jarak Ideal Negatif (D-)</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($jarakIdeal as $kodeAlternatif => $jarak): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($kodeAlternatif) ?></td>
                    <td><?= number_format($idealPositif['C1'], 4) ?></td>
                    <td><?= number_format($idealPositif['C2'], 4) ?></td>
                    <td><?= number_format($idealPositif['C3'], 4) ?></td>
                    <td><?= number_format($idealPositif['C4'], 4) ?></td>
                    <td><?= number_format($idealPositif['C5'], 4) ?></td>
                    <td><?= number_format($idealPositif['C6'], 4) ?></td>
                    <td><?= number_format($idealNegatif['C1'], 4) ?></td>
                    <td><?= number_format($idealNegatif['C2'], 4) ?></td>
                    <td><?= number_format($idealNegatif['C3'], 4) ?></td>
                    <td><?= number_format($idealNegatif['C4'], 4) ?></td>
                    <td><?= number_format($idealNegatif['C5'], 4) ?></td>
                    <td><?= number_format($idealNegatif['C6'], 4) ?></td>
                    <td><?= number_format($jarak['positif'], 4) ?></td>
                    <td><?= number_format($jarak['negatif'], 4) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>Data jarak ideal tidak tersedia.</p>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
