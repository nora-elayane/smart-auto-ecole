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
        <h1 style="font-size: 1.75rem; font-weight: 700; color: var(--text-primary); margin-bottom: 4px;">Gestion des Véhicules</h1>
        <p class="card-description">Liste et suivi du parc automobile de l'auto-école.</p>
    </div>
    <a href="/smart-auto-ecole/public/vehicules/create" class="btn btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Nouvelle Véhicule
    </a>
</div>

<div class="table-wrapper table-container" style="position: relative;">

    <!-- Floating Action Bar -->
    <div id="actionBar" class="action-bar-overlay">
        <div class="d-flex align-items-center gap-3">
            <span id="selectedCount" class="badge bg-primary">0 sélectionné(s)</span>

            <button type="button" id="btnEdit" class="btn btn-sm btn-outline-secondary" data-action-url="/smart-auto-ecole/public/vehicules/edit">
                Éditer
            </button>

            <button type="button" id="btnDelete" class="btn btn-sm btn-outline-danger" data-action-url="/smart-auto-ecole/public/vehicules/delete">
                Supprimer
            </button>
        </div>
    </div>

    <table class="table align-middle">
        <thead>
            <tr>
                <th width="40"><input type="checkbox" id="selectAll" class="form-check-input"></th>
                <th>#ID</th>
                <th>IMMATRICULATION</th>
                <th>MARQUE & MODÈLE</th>
                <th>ASSURANCE</th>
                <th>VISITE TECHNIQUE</th>
                <th>STATUT</th>
                <th style="text-align: right;">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($vehicules) && is_array($vehicules)): ?>
                <?php foreach ($vehicules as $v): ?>
                    <?php
                        $today = date('Y-m-d');
                        $assuranceExpiree = ($v['date_assurance'] && $v['date_assurance'] < $today);
                        $visiteExpiree = ($v['date_visite_technique'] && $v['date_visite_technique'] < $today);
                        $etat = $v['etat'] ?? 'Disponible';
                    ?>
                    <tr>
                        <td data-label="Sélection">
                            <input type="checkbox" class="select-row form-check-input" value="<?= htmlspecialchars($v['id_vehicule']); ?>">
                        </td>
                        <td data-label="#ID" style="font-weight: 600; color: var(--text-secondary);">
                            #<?= htmlspecialchars($v['id_vehicule'] ?? '-'); ?>
                        </td>
                        <td data-label="Immatriculation" style="font-weight: 600; font-family: monospace;">
                            <span class="badge bg-secondary bg-opacity-10 text-dark border border-secondary px-2 py-1">
                                <?= htmlspecialchars($v['immatriculation'] ?? 'N/A'); ?>
                            </span>
                        </td>
                        <td data-label="Marque & Modèle">
                            <div style="font-weight: 600; color: var(--text-primary);"><?= htmlspecialchars($v['marque'] ?? ''); ?></div>
                            <div style="font-size: 12px; color: var(--text-secondary);"><?= htmlspecialchars($v['modele'] ?? ''); ?></div>
                        </td>
                        <td data-label="Assurance" style="color: var(--text-secondary);">
                            <span class="<?= $assuranceExpiree ? 'text-danger fw-bold' : ''; ?>">
                                <?= $v['date_assurance'] ? date('d/m/Y', strtotime($v['date_assurance'])) : 'N/A'; ?>
                                <?php if ($assuranceExpiree): ?>
                                    <i class="bi bi-exclamation-triangle-fill text-danger ms-1" title="Assurance expirée!"></i>
                                <?php endif; ?>
                            </span>
                        </td>
                        <td data-label="Visite Technique" style="color: var(--text-secondary);">
                            <span class="<?= $visiteExpiree ? 'text-danger fw-bold' : ''; ?>">
                                <?= $v['date_visite_technique'] ? date('d/m/Y', strtotime($v['date_visite_technique'])) : 'N/A'; ?>
                                <?php if ($visiteExpiree): ?>
                                    <i class="bi bi-exclamation-triangle-fill text-danger ms-1" title="Visite technique expirée!"></i>
                                <?php endif; ?>
                            </span>
                        </td>
                        <td data-label="Statut">
                            <?php if ($etat === 'Disponible'): ?>
                                <span class="badge badge-success">Disponible</span>
                            <?php elseif ($etat === 'Maintenance'): ?>
                                <span class="badge badge-warning">Maintenance</span>
                            <?php else: ?>
                                <span class="badge badge-danger">En panne</span>
                            <?php endif; ?>
                        </td>
                        <td data-label="Actions" class="actions" style="text-align: right;">
                            <a href="/smart-auto-ecole/public/vehicules/edit?id=<?= htmlspecialchars($v['id_vehicule']); ?>" class="btn btn-sm btn-outline-primary me-1">
                               <i class="bi bi-pencil"></i> Éditer
                            </a>
                            <a href="/smart-auto-ecole/public/vehicules/delete?id=<?= htmlspecialchars($v['id_vehicule']); ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette véhicule ?');">
                               <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="padding: 40px; text-align: center; color: var(--text-light);">
                        <div style="font-size: 16px; font-weight: 600;">Aucune véhicule trouvée</div>
                        <div style="font-size: 13px; margin-top: 4px;">Commencez par ajouter une nouvelle véhicule à la base de données.</div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="/smart-auto-ecole/public/js/table-actions.js"></script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>