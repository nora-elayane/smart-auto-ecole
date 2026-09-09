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


<main class="main-content">
    <div class="page-content">
        
        <div class="card-header">
            <div>
                <h1 style="font-size: 1.75rem; font-weight: 700; color: var(--text-primary); margin-bottom: 4px;">Gestion des Candidats</h1>
                <p class="card-description">Liste et suivi de tous les candidats inscrits au système.</p>
            </div>
            <a href="/smart-auto-ecole/public/candidates/createStudent" class="btn btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Nouveau Candidat
            </a>
        </div>

       <div class="table-wrapper table-container" style="position: relative;">

    <!-- Floating Action Bar -->
    <div id="actionBar" class="action-bar-overlay">
        <div class="d-flex align-items-center gap-3">
            <span id="selectedCount" class="badge bg-primary">0 sélectionné(s)</span>
            
            <button type="button" id="btnEdit" class="btn btn-sm btn-outline-secondary" data-action-url="/smart-auto-ecole/public/candidates/edit">
                Éditer
            </button>

            <button type="button" id="btnArchive" class="btn btn-sm btn-outline-warning" data-action-url="/smart-auto-ecole/public/candidates/archive">
                Archiver
            </button>

            <button type="button" id="btnActivate" class="btn btn-sm btn-outline-success" data-action-url="/smart-auto-ecole/public/candidates/activate">
                Activer
            </button>

            <button type="button" id="btnDelete" class="btn btn-sm btn-outline-danger" data-action-url="/smart-auto-ecole/public/candidates/delete">
                Supprimer
            </button>
        </div>
    </div>

            <table class="table align-middle">
                <thead>
                    <tr>
                        <th width="40"><input type="checkbox" id="selectAll" class="form-check-input"></th>
                        <th>#ID</th>
                        <th>CANDIDAT</th>
                        <th>CIN</th>
                        <th>CONTACT</th>
                        <th>ADRESSE</th>
                        <th>NÉ(E) LE</th>
                        <th>STATUT</th>
                        <th style="text-align: right;">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($students) && is_array($students)): ?>
                        <?php foreach ($students as $student): ?>
                            <?php 
                                $etatRaw = strtolower($student['etat'] ?? 'actif');
                                $isActif = ($etatRaw === 'actif' || $etatRaw === 'active');
                            ?>
                            <tr data-etat="<?= $isActif ? 'actif' : 'archivé' ?>">
                                <td>
                                    <input type="checkbox" class="select-row form-check-input" value="<?= htmlspecialchars($student['id_user']); ?>">
                                </td>
                                <td style="font-weight: 600; color: var(--text-secondary);">
                                    #<?= htmlspecialchars($student['id_user'] ?? '-'); ?>
                                </td>

                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <?php if (!empty($student['photo'])): ?>
                                            <img src="/smart-auto-ecole/public/uploads/<?= htmlspecialchars($student['photo']); ?>" alt="Avatar" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">   
                                        <?php else: ?>
                                            <div class="user-avatar" style="width: 36px; height: 36px; font-weight: 600; font-size: 0.875rem;">
                                                <?= strtoupper(substr($student['nom'] ?? 'C', 0, 1)); ?>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <div style="font-weight: 600; color: var(--text-primary);"><?= htmlspecialchars(($student['prenom'] ?? '') . ' ' . ($student['nom'] ?? '')); ?></div>
                                            <div style="font-size: 12px; color: var(--text-secondary);"><?= htmlspecialchars($student['email'] ?? ''); ?></div>
                                        </div>
                                    </div>
                                </td>

                                <td style="font-weight: 500; font-family: monospace;">
                                    <?= htmlspecialchars($student['cin'] ?? 'N/A'); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($student['telephone'] ?? 'N/A'); ?>
                                </td>

                                <td style="color: var(--text-secondary); max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <?= htmlspecialchars($student['adresse'] ?? 'N/A'); ?>
                                </td>

                                <td style="color: var(--text-secondary);">
                                    <?= htmlspecialchars($student['date_naissance'] ?? 'N/A'); ?>
                                </td>

                                <td>
                                    <span class="badge <?= $isActif ? 'badge-success' : 'badge-danger'; ?>">
                                        <?= ucfirst($etatRaw); ?>
                                    </span>
                                </td>

                                <td class="actions" style="text-align: right;">
                                    <a href="/smart-auto-ecole/public/candidates/show?id=<?= htmlspecialchars($student['id_user']); ?>" class="btn btn-sm btn-outline-primary">
                                       <i class="bi bi-file-text"></i> Consulter
                                    </a>

                                   
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" style="padding: 40px; text-align: center; color: var(--text-light);">
                                <div style="font-size: 16px; font-weight: 600;">Aucun candidat trouvé</div>
                                <div style="font-size: 13px; margin-top: 4px;">Commencez par ajouter un nouveau candidat à la base de données.</div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</main>

<script src="/smart-auto-ecole/public/js/table-actions.js"></script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>


<!-- Toast Notification UI -->
<?php if (isset($_SESSION['flash'])): ?>
    <div id="toastBox" class="toast-box toast-<?php echo $_SESSION['flash']['type']; ?>">
        <span class="toast-icon">
            <?php 
                echo match($_SESSION['flash']['type']) {
                    'success' => '✅',
                    'warning' => '⚠️',
                    'danger'  => '🗑️',
                    default   => 'ℹ️'
                };
            ?>
        </span>
        <span class="toast-message"><?php echo $_SESSION['flash']['message']; ?></span>
    </div>
    <?php unset($_SESSION['flash']); ?>

    <script>
        setTimeout(function() {
            const toast = document.getElementById('toastBox');
            if (toast) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-20px)';
                setTimeout(() => toast.remove(), 400); 
            }
        }, 3000);
    </script>
<?php endif; ?>