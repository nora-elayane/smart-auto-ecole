<div class="row g-3">
    <div class="col-md-4">
        <div class="p-3 bg-light rounded border text-center">
            <span class="text-muted small">Prix Total du Contrat</span>
            <h3 class="fw-bold text-dark mt-1"><?= number_format($contrat['prix_final'], 2) ?> DH</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-3 bg-light rounded border text-center">
            <span class="text-muted small">Total Payé</span>
            <h3 class="fw-bold text-success mt-1"><?= number_format($totalPaye, 2) ?> DH</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-3 bg-light rounded border text-center">
            <span class="text-muted small">Reste à Payer (Arriérés)</span>
            <h3 class="fw-bold text-danger mt-1"><?= number_format($contrat['prix_final'] - $totalPaye, 2) ?> DH</h3>
        </div>
    </div>
</div>