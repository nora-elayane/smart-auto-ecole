<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<!-- Toast Notification UI -->
<?php if (isset($_SESSION['flash'])): ?>
    <div id="toastNotification" class="custom-toast toast-<?php echo $_SESSION['flash']['type']; ?>">
        <div class="toast-indicator"></div>
        <div class="toast-content">
            <?php echo $_SESSION['flash']['message']; ?>
        </div>
    </div>
    <?php unset($_SESSION['flash']); ?>

    <script>
        setTimeout(function() {
            const toast = document.getElementById('toastNotification');
            if (toast) {
                toast.classList.add('toast-hide');
                setTimeout(() => toast.remove(), 400);
            }
        }, 3000);
    </script>
<?php endif; ?>

<div class="card-header">
    <div>
        <h1 style="font-size: 1.75rem; font-weight: 700; color: var(--text-primary); margin-bottom: 4px;">Gestion des Contrats</h1>
        <p class="card-description">Liste globale et suivi de tous les contrats d'apprentissage.</p>
    </div>
    <a href="/smart-auto-ecole/public/candidates/contrats/create" class="btn btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Nouveau Contrat
    </a>
</div>

<div class="table-wrapper table-container" style="position: relative;">

    <!-- Floating Action Bar -->
    <div id="actionBar" class="action-bar-overlay">
        <div class="d-flex align-items-center gap-3">
            <span id="selectedCount" class="badge bg-primary">0 sélectionné(s)</span>

            <button type="button" id="btnDelete" class="btn btn-sm btn-outline-danger" data-action-url="/smart-auto-ecole/public/candidates/contrats/delete">
                Supprimer
            </button>
        </div>
    </div>

    <table class="table align-middle">
        <thead>
            <tr>
                <th width="40"><input type="checkbox" id="selectAll" class="form-check-input"></th>
                <th>#N° CONTRAT</th>
                <th>CANDIDAT</th>
                <th>CIN</th>
                <th>DATE DEBUT</th>
                <th>MONTANT TOTAL</th>
                <th>STATUT</th>
                <th style="text-align: right;">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($contrats) && is_array($contrats)): ?>
                <?php foreach ($contrats as $c): ?>
                    <tr>
                        <td data-label="Sélection">
                            <input type="checkbox" class="select-row form-check-input" value="<?= htmlspecialchars($c['id_contrat']); ?>">
                        </td>
                        <td data-label="N° Contrat" style="font-weight: 600; color: var(--text-secondary);">
                            #<?= htmlspecialchars($c['numero_contrat'] ?? $c['id_contrat']); ?>
                        </td>
                        <td data-label="Candidat">
                            <div style="font-weight: 600; color: var(--text-primary);">
                                <?= htmlspecialchars(($c['prenom'] ?? '') . ' ' . ($c['nom'] ?? '')); ?>
                            </div>
                        </td>
                        <td data-label="CIN" style="font-weight: 500; font-family: monospace;">
                            <?= htmlspecialchars($c['cin'] ?? 'N/A'); ?>
                        </td>
                        <td data-label="Date Début" style="color: var(--text-secondary);">
                            <?= !empty($c['date_debut']) ? date('d/m/Y', strtotime($c['date_debut'])) : 'N/A'; ?>
                        </td>
                        <td data-label="Montant Total" style="font-weight: 600; color: var(--text-primary);">
                            <?= number_format($c['prix_total'] ?? 0, 2); ?> DH
                        </td>
                        <td data-label="Statut">
                            <?php 
                                $statut = $c['statut'] ?? 'Actif';
                                $badgeClass = ($statut === 'Actif' || $statut === 'En cours') ? 'badge-success' : 'badge-danger';
                            ?>
                            <span class="badge <?= $badgeClass; ?>">
                                <?= htmlspecialchars($statut); ?>
                            </span>
                        </td>
                        <td data-label="Actions" class="actions" style="text-align: right;">
                            <a href="/smart-auto-ecole/public/candidates/contrats/show?id=<?= htmlspecialchars($c['id_contrat']); ?>" class="btn btn-sm btn-outline-primary me-1">
                               <i class="bi bi-file-text"></i> Consulter
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="padding: 40px; text-align: center; color: var(--text-light);">
                        <div style="font-size: 16px; font-weight: 600;">Aucun contrat trouvé</div>
                        <div style="font-size: 13px; margin-top: 4px;">Commencez par enregistrer un nouveau contrat.</div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="/smart-auto-ecole/public/js/table-actions.js"></script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>