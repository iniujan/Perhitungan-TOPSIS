<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Data Kriteria</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Kriteria</th>
                <th>Bobot</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($kriteria as $index => $item): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= esc($item['kode_kriteria']) ?></td>
                    <td><?= esc($item['nama_kriteria']) ?></td>
                    <td><?= esc($item['bobot']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
