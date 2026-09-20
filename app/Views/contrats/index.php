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
    <a href="/smart-auto-ecole/public/contrats/create" class="btn btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Nouveau Contrat
    </a>
</div>

<div class="table-wrapper table-container" style="position: relative;">

    <!-- Floating Action Bar -->
     <div id="actionBar" class="action-bar-overlay" style="margin-bottom: 15px; padding: 5px 0;">
                <div class="d-flex align-items-center gap-3">
                    <span id="selectedCount" class="badge bg-primary">0 sélectionné(s)</span>
            <button type="button" id="btnEdit" data-action-url="/smart-auto-ecole/public/contrats/edit?from=contrats" class="btn btn-sm btn-outline-secondary">
    Éditer
</button>
                    <button type="button" id="btnDelete" data-action-url="/smart-auto-ecole/public/contrats/delete?from=contrats" class="btn btn-sm btn-outline-danger">
                        Supprimer
                    </button>
                    
                    <div class="dropdown-wrapper" style="position: relative; display: inline-block; z-index: 1050;">
                        <button type="button" id="btnPrintDropdown" class="btn btn-sm btn-secondary">
                            Imprimer ▾
                        </button>
                        <div id="printMenu" class="custom-dropdown-menu" style="position: absolute; top: 100%; right: 0; z-index: 1060; background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-radius: 6px; min-width: 200px;">
                            <button type="button" class="dropdown-item print-action" data-type="contrat">Contrat d'apprentissage</button>
                            <button type="button" class="dropdown-item print-action" data-type="attestation">Attestation d'inscription</button>
                            <div class="dropdown-divider"></div>
                            <button type="button" class="dropdown-item print-action" data-type="carte">Carte Candidat</button>
                        </div>
                    </div>
                </div>
            </div>


    <table class="table align-middle">
        <thead>
            <tr>
                <th width="40"><input type="checkbox" id="selectAll" class="form-check-input"></th>
                <th>N° CONTRAT</th>
                <th>CANDIDAT</th>
                <th>CIN</th>
                <th>TÉLÉPHONE</th>
                <th>CATÉGORIE PERMIS</th>
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
                        <td data-label="Téléphone" style="color: var(--text-secondary);">
                            <?= htmlspecialchars($c['telephone'] ?? $c['phone'] ?? 'N/A'); ?>
                        </td>
                        <td data-label="Catégorie Permis">
    <span class="badge bg-light text-dark border">
        Permis <?= htmlspecialchars($c['categorie_code'] ?? 'B'); ?>
    </span>
</td>
                        <td data-label="Statut">
                            <?php 
                                $statut = $c['statut'] ?? 'En cours';
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