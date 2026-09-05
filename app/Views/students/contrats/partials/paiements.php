<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0">Historique des Paiements</h5>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addPaiementModal">
        <i class="bi bi-plus-lg"></i> Nouveau Paiement
    </button>
</div>

<table class="table table-hover align-middle">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Montant</th>
            <th>Mode</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <!-- Loop des paiements -->
        <?php foreach ($paiements as $p): ?>
        <tr>
            <td>#<?= $p['id_paiement'] ?></td>
            <td><?= $p['date_paiement'] ?></td>
            <td class="fw-bold text-success"><?= number_format($p['montant'], 2) ?> DH</td>
            <td><?= $p['mode_paiement'] ?></td>
            <td>
                <a href="/paiements/recu/<?= $p['id_paiement'] ?>" class="btn btn-sm btn-outline-secondary">
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>