<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

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
                    <?php if (!empty($students)): ?>
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

                                <td style="text-align: right;">
                                    <div style="display: flex; justify-content: flex-end; gap: 6px;">
                                        <a href="/smart-auto-ecole/public/contracts/create?candidate_id=<?php echo $student['id_user']; ?>" class="btn btn-primary" style="min-height: 32px; padding: 0 10px; font-size: 12px;" title="Créer un contrat">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                                            Contrat
                                        </a>

                                        <a href="/smart-auto-ecole/public/candidates/edit?id=<?php echo $student['id_user']; ?>" class="btn btn-secondary" style="min-height: 32px; padding: 0 8px; font-size: 12px;" title="Éditer">
                                            Éditer
                                        </a>

                                        <a href="/smart-auto-ecole/public/candidates/archive?id=<?php echo $student['id_user']; ?>" onclick="return confirm('Voulez-vous vraiment archiver ce candidat ?');" class="btn btn-danger" style="min-height: 32px; padding: 0 8px; font-size: 12px;" title="Archiver">
                                            Archiver
                                        </a>
                                    </div>
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