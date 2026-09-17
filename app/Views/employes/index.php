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
        <h1 style="font-size: 1.75rem; font-weight: 700; color: var(--text-primary); margin-bottom: 4px;">Gestion des Employés</h1>
        <p class="card-description">Gestion et suivi des moniteurs et secrétaires de l'auto-école.</p>
    </div>
    <a href="/smart-auto-ecole/public/employes/create" class="btn btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Nouveau Employé
    </a>
</div>

<div class="table-wrapper table-container" style="position: relative;">

    <!-- Floating Action Bar -->
    <div id="actionBar" class="action-bar-overlay">
        <div class="d-flex align-items-center gap-3">
            <span id="selectedCount" class="badge bg-primary">0 sélectionné(s)</span>

            <button type="button" id="btnEdit" class="btn btn-sm btn-outline-secondary" data-action-url="/smart-auto-ecole/public/employes/edit">
                Éditer
            </button>

            <button type="button" id="btnArchive" class="btn btn-sm btn-outline-warning" data-action-url="/smart-auto-ecole/public/employes/archive">
                Archiver
            </button>

            <button type="button" id="btnActivate" class="btn btn-sm btn-outline-success" data-action-url="/smart-auto-ecole/public/employes/active">
                Activer
            </button>

            <button type="button" id="btnDelete" class="btn btn-sm btn-outline-danger" data-action-url="/smart-auto-ecole/public/employes/delete">
                Supprimer
            </button>
        </div>
    </div>

    <table class="table align-middle">
        <thead>
            <tr>
                <th width="40"><input type="checkbox" id="selectAll" class="form-check-input"></th>
                <th>#ID</th>
                <th>EMPLOYÉ</th>
                <th>RÔLE</th>
                <th>CIN</th>
                <th>CONTACT</th>
                <th>ADRESSE</th>
                <th>STATUT</th>
                <th style="text-align: right;">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($employes) && is_array($employes)): ?>
                <?php foreach ($employes as $emp): ?>
                    <?php
                        $etatRaw = strtolower($emp['etat'] ?? 'actif');
                        $isActif = ($etatRaw === 'actif' || $etatRaw === 'active');
                        $roleName = $emp['nom_role'] ?? ($emp['id_role'] == 3 ? 'Moniteur' : 'Secrétaire');
                    ?>
                    <tr data-etat="<?= $isActif ? 'actif' : 'archivé' ?>">
                        <td data-label="Sélection">
                            <input type="checkbox" class="select-row form-check-input" value="<?= htmlspecialchars($emp['id_user']); ?>">
                        </td>
                        <td data-label="#ID" style="font-weight: 600; color: var(--text-secondary);">
                            #<?= htmlspecialchars($emp['id_user'] ?? '-'); ?>
                        </td>
                        <td data-label="Employé">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <?php if (!empty($emp['photo'])): ?>
                                    <img src="/smart-auto-ecole/public/uploads/<?= htmlspecialchars($emp['photo']); ?>" alt="Avatar" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">
                                <?php else: ?>
                                    <div class="user-avatar" style="width: 36px; height: 36px; font-weight: 600; font-size: 0.875rem;">
                                        <?= strtoupper(substr($emp['nom'] ?? 'E', 0, 1)); ?>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <div style="font-weight: 600; color: var(--text-primary);"><?= htmlspecialchars(($emp['prenom'] ?? '') . ' ' . ($emp['nom'] ?? '')); ?></div>
                                    <div style="font-size: 12px; color: var(--text-secondary);"><?= htmlspecialchars($emp['email'] ?? ''); ?></div>
                                </div>
                            </div>
                        </td>
                        <td data-label="Rôle">
                            <span class="badge <?= ($emp['id_role'] == 3) ? 'badge-info' : 'badge-secondary'; ?>" style="font-weight: 600;">
                                <?= htmlspecialchars($roleName); ?>
                            </span>
                        </td>
                        <td data-label="CIN" style="font-weight: 500; font-family: monospace;">
                            <?= htmlspecialchars($emp['cin'] ?? 'N/A'); ?>
                        </td>
                        <td data-label="Contact">
                            <?= htmlspecialchars($emp['telephone'] ?? 'N/A'); ?>
                        </td>
                        <td data-label="Adresse" style="color: var(--text-secondary);">
                            <?= htmlspecialchars($emp['adresse'] ?? 'N/A'); ?>
                        </td>
                        <td data-label="Statut">
                            <span class="badge <?= $isActif ? 'badge-success' : 'badge-danger'; ?>">
                                <?= ucfirst($etatRaw); ?>
                            </span>
                        </td>
                        <td data-label="Actions" class="actions">
                            <a href="/smart-auto-ecole/public/employes/edit?id=<?= htmlspecialchars($emp['id_user']); ?>" class="btn btn-sm btn-outline-primary">
                               <i class="bi bi-pencil"></i> Éditer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" style="padding: 40px; text-align: center; color: var(--text-light);">
                        <div style="font-size: 16px; font-weight: 600;">Aucun employé trouvé</div>
                        <div style="font-size: 13px; margin-top: 4px;">Commencez par ajouter un nouveau moniteur ou secrétaire à la base de données.</div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="/smart-auto-ecole/public/js/table-actions.js"></script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>