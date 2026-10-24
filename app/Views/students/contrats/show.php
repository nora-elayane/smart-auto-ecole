<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Contrat - Smart Auto-École</title>
    <link rel="stylesheet" href="/smart-auto-ecole/public/css/style.css">
    <link rel="stylesheet" href="/smart-auto-ecole/public/css/toast.css">
    <link rel="stylesheet" href="/smart-auto-ecole/public/css/buttons.css">
</head>
<body>
<?php 
    $referer = $_SERVER['HTTP_REFERER'] ?? '';
    $candidateId = $contrat['id_user'] ?? '';

    if (strpos($referer, 'candidates/show') !== false && !empty($candidateId)) {
        $cancelUrl = BASE_URL . '/candidates/show?id=' . $candidateId;
    } else {
        $cancelUrl = BASE_URL . '/contrats';
    }
?>

        <main class="page-content">
            <!-- Header & Actions -->
           <!-- Title Header avec Numéro d'enregistrement -->
<div class="card-header" style="margin-bottom: 24px;">
    <div>
        <h1 class="card-title" style="font-size: 22px;">
            Contrat N° <?= htmlspecialchars($contrat['num_enregistrement'] ?? $contrat['id_contrat']) ?>
        </h1>
        <p class="card-description">Gestion financière et suivi du contrat d'apprentissage.</p>
    </div>
    <div style="display: flex; gap: 10px;">
          <a href="<?= $cancelUrl; ?>" class="btn btn-secondary">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
    Retour
</a>
        <button onclick="openPaymentModal()" class="btn btn-primary">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Ajouter un Paiement
        </button>
    </div>
</div>

<!-- Grid Details -->
<div style="display: grid; grid-template-columns: 2.5fr 2.5fr; gap: 20px; margin-bottom: 24px;">
    
    <!-- Informations Contrat & Candidat -->
    <div class="card">
        <h3 class="card-title" style="margin-bottom: 16px; font-size: 16px; display: flex; align-items: center; gap: 8px;">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path></svg>
            Informations Générales
        </h3>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; font-size: 14px;">
            <div>
                <span style="color: var(--text-secondary); display: block; font-size: 12px;">N° Enregistrement</span>
                <strong><?= htmlspecialchars($contrat['num_enregistrement'] ?? 'Non renseigné') ?></strong>
            </div>
            <div>
                <span style="color: var(--text-secondary); display: block; font-size: 12px;">Candidat</span>
                <strong><?= htmlspecialchars($contrat['nom'] . ' ' . $contrat['prenom']) ?></strong>
            </div>
            <div>
                <span style="color: var(--text-secondary); display: block; font-size: 12px;">CIN / Téléphone</span>
                <strong><?= htmlspecialchars($contrat['cin']) ?> / <?= htmlspecialchars($contrat['telephone']) ?></strong>
            </div>
            <div>
                <span style="color: var(--text-secondary); display: block; font-size: 12px;">Catégorie Permis</span>
                <span class="badge badge-success"><?= htmlspecialchars($contrat['categorie_code'] ?? 'Permis B') ?></span>
            </div>
            <div>
                <span style="color: var(--text-secondary); display: block; font-size: 12px;">Date du Contrat</span>
                <strong><?= htmlspecialchars($contrat['date_contrat']) ?></strong>
            </div>
            <div>
                <span style="color: var(--text-secondary); display: block; font-size: 12px;">Statut</span>
                <span class="badge badge-warning"><?= htmlspecialchars($contrat['statut']) ?></span>
            </div>
        </div>
    </div>

                <!-- Résumé Financier -->
                <div class="card" style="background: linear-gradient(135deg, var(--primary-light), #ffffff); border-color: var(--primary);">
                    <h3 class="card-title" style="margin-bottom: 16px; font-size: 16px; color: var(--primary-dark);">Bilan Financier</h3>
                    
                    <div style="margin-bottom: 12px; display: flex; justify-content: space-between; font-size: 14px;">
                        <span style="color: var(--text-secondary);">Prix Final:</span>
                        <strong style="font-size: 16px;"><?= number_format($contrat['prix_final'], 2) ?> DH</strong>
                    </div>
                    <div style="margin-bottom: 12px; display: flex; justify-content: space-between; font-size: 14px;">
                        <span style="color: var(--text-secondary);">Total Payé:</span>
                        <strong style="color: var(--success); font-size: 16px;"><?= number_format($contrat['total_paye'], 2) ?> DH</strong>
                    </div>
                    <div style="margin-bottom: 16px; display: flex; justify-content: space-between; font-size: 14px; border-top: 1px dashed var(--border-color); padding-top: 8px;">
                        <span style="color: var(--text-secondary);">Reste à payer:</span>
                        <strong style="color: var(--danger); font-size: 16px;"><?= number_format($contrat['reste_a_payer'], 2) ?> DH</strong>
                    </div>

                  <?php 
    $percent = $contrat['prix_final'] > 0 ? min(100, ($contrat['total_paye'] / $contrat['prix_final']) * 100) : 0; 
?>
<div style="background: #e2e8f0; border-radius: 999px; height: 8px; width: 100%; overflow: hidden;">
    <!-- Correction : pas d'espace entre la balise PHP et le symbole % en CSS -->
    <div style="background: var(--success); height: 100%; width: <?= $percent ?>%;"></div>
</div>

<!-- Correction : le symbole % doit être une chaîne de caractères normale à l'extérieur de la balise PHP -->
<span style="font-size: 11px; color: var(--text-secondary); margin-top: 4px; display: block; text-align: right;">
    <?= round($percent, 1) ?>% réglé
</span>
                </div>

            </div>

         <div class="card">
    <div class="card-header" style="margin-bottom: 16px;">
        <h3 class="card-title" style="font-size: 16px;">Historique des Paiements (UC07)</h3>
    </div>

    <div class="table-wrapper">
       <table class="table">
    <thead>
        <tr>
            <th># ID</th>
            <th>DATE</th>
            <th>MONTANT</th>
            <th>MODE DE PAIEMENT</th>
            <th>RÉFÉRENCE</th>
            <th style="text-align: center;">ACTIONS</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($contrat['paiements'])): ?>
            <?php foreach ($contrat['paiements'] as $pay): ?>
                <tr>
                    <td>#<?= htmlspecialchars($pay['id_paiement']) ?></td>
                    <td><?= htmlspecialchars($pay['date_paiement']) ?></td>
                    <td><strong><?= number_format($pay['montant'], 2) ?> DH</strong></td>
                    <td><span class="badge badge-success"><?= htmlspecialchars($pay['mode_paiement']) ?></span></td>
                    <td><?= htmlspecialchars($pay['reference'] ?? '-') ?></td>
                    <td style="text-align: center; white-space: nowrap;">
                        <!-- Print Reçu -->
                        <a href="<?= BASE_URL ?>/payments/print?id=<?= $pay['id_paiement'] ?>" target="_blank" class="btn btn-sm btn-secondary" title="Imprimer le reçu">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                        </a>
                        <!-- Edit Button -->
                        <button onclick="editPayment(<?= htmlspecialchars(json_encode($pay)) ?>)" class="btn btn-sm btn-secondary" title="Modifier">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </button>
                        <!-- Delete Form -->
                        <form action="<?= BASE_URL ?>/payments/delete" method="POST" style="display: inline-block;" onsubmit="return confirm('Voulez-vous vraiment supprimer ce paiement ?');">
                            <input type="hidden" name="id_paiement" value="<?= $pay['id_paiement'] ?>">
                            <input type="hidden" name="id_contrat" value="<?= $contrat['id_contrat'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" style="text-align: center; color: var(--text-secondary); padding: 30px;">
                    Aucun paiement enregistré pour le moment.
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
    </div>
</div>

        </main>
    </div>
</div>

<div id="paymentModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; width: 100%; max-width: 400px; padding: 24px; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
        <h3 style="margin-bottom: 16px; font-size: 18px; font-weight: 700;">Enregistrer un Paiement</h3>
        <form action="<?= BASE_URL ?>/payments/store" method="POST">
            <input type="hidden" name="id_contrat" value="<?= $contrat['id_contrat'] ?>">
            
            <div class="form-group">
                <label class="form-label">Montant (DH)</label>
                <input type="number" step="0.01" class="form-control" name="montant" required max="<?= $contrat['reste_a_payer'] ?>" placeholder="Ex: 1000">
            </div>

            <div class="form-group">
                <label class="form-label">Mode de Paiement</label>
                <select class="form-control" name="mode_paiement">
                    <option value="Espèces">Espèces</option>
                    <option value="Chèque">Chèque</option>
                    <option value="Virement">Virement</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Référence / N° Reçu</label>
                <input type="text" class="form-control" name="reference" placeholder="Ex: REC-2026-001 ou N° Chèque">
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" onclick="closePaymentModal()" class="btn btn-secondary">Annuler</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
    </div>

<script>
function openPaymentModal() {
    document.getElementById('paymentModal').style.display = 'flex';
}
function closePaymentModal() {
    document.getElementById('paymentModal').style.display = 'none';
}
</script>

</body>
</html>