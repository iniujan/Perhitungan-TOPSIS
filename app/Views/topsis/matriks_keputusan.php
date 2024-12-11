<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Matriks Keputusan</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Alternatif</th>
                <th>Kriteria</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($matriks_keputusan)): ?>
                <?php foreach ($matriks_keputusan as $row): ?>
                    <tr>
                        <td><?= esc($row['nama_alternatif']) ?></td>
                        <td><?= esc($row['nama_kriteria']) ?></td>
                        <td><?= esc($row['nilai']) ?></td>
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
