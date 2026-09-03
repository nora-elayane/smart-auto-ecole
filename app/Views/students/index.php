
<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>
<link rel="stylesheet" href="/smart-auto-ecole/public/css/toast.css">
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

        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Candidat</th>
                        <th>CIN</th>
                        <th>Contact</th>
                        <th>Adresse</th>
                        <th>Né(e) le</th>
                        <th>Statut</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($students) && is_array($students)): ?>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td style="font-weight: 600; color: var(--text-secondary);">
                                    #<?php echo htmlspecialchars($student['id_user'] ?? '-'); ?>
                                </td>

                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <?php if (!empty($student['photo'])): ?>
<img src="/smart-auto-ecole/public/uploads/<?php echo htmlspecialchars($student['photo']); ?>" alt="Avatar" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">   
                                        <?php else: ?>
                                            <div class="user-avatar" style="width: 36px; height: 36px; font-weight: 600; font-size: 0.875rem;">
                                                <?php echo strtoupper(substr($student['nom'] ?? 'C', 0, 1)); ?>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <div style="font-weight: 600; color: var(--text-primary);"><?php echo htmlspecialchars(($student['prenom'] ?? '') . ' ' . ($student['nom'] ?? '')); ?></div>
                                            <div style="font-size: 12px; color: var(--text-secondary);"><?php echo htmlspecialchars($student['email'] ?? ''); ?></div>
                                        </div>
                                    </div>
                                </td>

                                <td style="font-weight: 500; font-family: monospace;">
                                    <?php echo htmlspecialchars($student['cin'] ?? 'N/A'); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($student['telephone'] ?? 'N/A'); ?>
                                </td>

                                <td style="color: var(--text-secondary); max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <?php echo htmlspecialchars($student['adresse'] ?? 'N/A'); ?>
                                </td>

                                <td style="color: var(--text-secondary);">
                                    <?php echo htmlspecialchars($student['date_naissance'] ?? 'N/A'); ?>
                                </td>

                                <td>
                                    <?php 
                                        $etat = strtolower($student['etat'] ?? 'actif');
                                        $isActif = ($etat === 'actif' || $etat === 'active');
                                    ?>
                                    <span class="badge <?php echo $isActif ? 'badge-success' : 'badge-danger'; ?>">
                                        <?php echo ucfirst($etat); ?>
                                    </span>
                                </td>

                                <td class="actions">
    <a href="/smart-auto-ecole/public/candidates/contract?id=<?php echo $student['id_user']; ?>" class="btn btn-primary btn-sm">Contrat</a>

    <?php if ($student['etat'] === 'Actif'): ?>
        <a href="/smart-auto-ecole/public/candidates/edit?id=<?php echo $student['id_user']; ?>" class="btn btn-secondary btn-sm">Éditer</a>
        <a href="/smart-auto-ecole/public/candidates/archive?id=<?php echo $student['id_user']; ?>" 
           onclick="return confirm('Voulez-vous vraiment archiver ce candidat ?');" 
           class="btn btn-warning btn-sm">Archiver</a>

    <?php else: ?>
        <a href="/smart-auto-ecole/public/candidates/activate?id=<?php echo $student['id_user']; ?>" 
           onclick="return confirm('Voulez-vous réactiver ce candidat ?');" 
           class="btn btn-success btn-sm">Activer</a>
        
        <a href="/smart-auto-ecole/public/candidates/delete?id=<?php echo $student['id_user']; ?>" 
           onclick="return confirm('Attention! Voulez-vous supprimer définitivement ce candidat ?');" 
           class="btn btn-danger btn-sm">Supprimer</a>
    <?php endif; ?>
</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="padding: 40px; text-align: center; color: var(--text-light);">
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
        // إخفاء الـ Toast أوتوماتيكياً بعد 3 ثواني
        setTimeout(function() {
            const toast = document.getElementById('toastBox');
            if (toast) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-20px)';
                setTimeout(() => toast.remove(), 400); // مسح العنصر من DOM
            }
        }, 3000);
    </script>
<?php endif; ?>