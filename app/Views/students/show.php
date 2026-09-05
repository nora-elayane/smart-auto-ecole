<div class="page-content">
        <link rel="stylesheet" href="/smart-auto-ecole/public/css/style.css">
    <link rel="stylesheet" href="/smart-auto-ecole/public/css/toast.css">
    <div class="card-header" style="margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 22px; font-weight: 700; color: var(--text-primary);">Fiche Candidat</h1>
            <p class="card-description">Détails du candidat et gestion de ses contrats d'apprentissage.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="/smart-auto-ecole/public/candidates" class="btn btn-secondary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Retour
            </a>
            <a href="/smart-auto-ecole/public/candidates/contrats/create?id=<?= htmlspecialchars($candidat['id_user'] ?? '') ?>" class="btn btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                Nouveau Contrat
            </a>
        </div>
    </div>

    <!-- Informations du Candidat -->
    <div class="card" style="margin-bottom: 24px;">
        <div class="card-header">
            <h2 class="card-title">Informations Personnelles</h2>
            <span class="badge <?= ($candidat['etat'] ?? '') === 'Actif' ? 'badge-success' : 'badge-danger' ?>">
                <?= htmlspecialchars($candidat['etat'] ?? 'Actif') ?>
            </span>
        </div>
        
        <div class="dashboard-grid" style="grid-template-columns: repeat(3, 1fr);">
            <div>
                <span class="card-description">Nom & Prénom</span>
                <p style="font-weight: 600; font-size: 15px; margin-top: 4px; color: var(--text-primary);">
                    <?= htmlspecialchars(($candidat['nom'] ?? '') . ' ' . ($candidat['prenom'] ?? '')) ?>
                </p>
            </div>
            <div>
                <span class="card-description">CIN</span>
                <p style="font-weight: 600; font-size: 15px; margin-top: 4px; color: var(--text-primary);">
                    <?= htmlspecialchars($candidat['cin'] ?? '-') ?>
                </p>
            </div>
            <div>
                <span class="card-description">Téléphone</span>
                <p style="font-weight: 600; font-size: 15px; margin-top: 4px; color: var(--text-primary);">
                    <?= htmlspecialchars($candidat['telephone'] ?? '-') ?>
                </p>
            </div>
            <div>
                <span class="card-description">Email</span>
                <p style="font-weight: 600; font-size: 15px; margin-top: 4px; color: var(--text-primary);">
                    <?= htmlspecialchars($candidat['email'] ?? '-') ?>
                </p>
            </div>
            <div>
                <span class="card-description">Date de Naissance</span>
                <p style="font-weight: 600; font-size: 15px; margin-top: 4px; color: var(--text-primary);">
                    <?= htmlspecialchars($candidat['date_naissance'] ?? '-') ?>
                </p>
            </div>
            <div>
                <span class="card-description">Adresse</span>
                <p style="font-weight: 600; font-size: 15px; margin-top: 4px; color: var(--text-primary);">
                    <?= htmlspecialchars($candidat['adresse'] ?? '-') ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Liste des Contrats -->
    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="card-title">Liste des Contrats</h2>
                <p class="card-description">Historique des souscriptions aux permis de conduire.</p>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>N° Contrat</th>
                        <th>Catégorie</th>
                        <th>Date Contrat</th>
                        <th>Prix Final</th>
                        <th>Statut</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($contrats) && is_array($contrats)): ?>
                        <?php foreach ($contrats as $contrat): ?>
                            <tr>
                                <td style="font-weight: 600;">#<?= htmlspecialchars($contrat['id_contrat']) ?></td>
                                <td>
                                    <span class="badge badge-warning" style="background: #eff6ff; color: var(--primary);">
                                        Permis <?= htmlspecialchars($contrat['nom_categorie'] ?? $contrat['id_categorie']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($contrat['date_contrat']) ?></td>
                                <td style="font-weight: 600; color: var(--success);">
                                    <?= number_format($contrat['prix_final'], 2) ?> DH
                                </td>
                                <td>
                                    <span class="badge <?= $contrat['statut'] === 'Soldé' ? 'badge-success' : 'badge-warning' ?>">
                                        <?= htmlspecialchars($contrat['statut']) ?>
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <a href="/smart-auto-ecole/public/candidates/contrats/show?id=<?= htmlspecialchars($contrat['id_contrat']) ?>" class="btn btn-secondary" style="min-height: 32px; padding: 0 10px; font-size: 12px;">
                                        Consulter
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--text-secondary); padding: 24px;">
                                Aucun contrat trouvé pour ce candidat.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>