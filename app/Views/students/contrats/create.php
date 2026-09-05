<div class="page-content" style="max-width: 800px; margin: 0 auto;">
   <link rel="stylesheet" href="/smart-auto-ecole/public/css/style.css">
    <link rel="stylesheet" href="/smart-auto-ecole/public/css/toast.css">
    <div class="card-header" style="margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 22px; font-weight: 700; color: var(--text-primary);">Nouveau Contrat</h1>
            <p class="card-description">Créer un nouveau contrat de formation pour le candidat.</p>
        </div>
        <a href="/smart-auto-ecole/public/candidates/show?id=<?= htmlspecialchars($_GET['id_user'] ?? '') ?>" class="btn btn-secondary">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Annuler
        </a>
    </div>

    <!-- Form Card -->
    <div class="card">
        <form action="/smart-auto-ecole/public/candidates/contrats/store" method="POST">
            <!-- ID Candidat Hidden Input -->
<input type="hidden" name="id_user" value="<?= htmlspecialchars($_GET['id_user'] ?? $_GET['id'] ?? '') ?>">            <div class="form-group">
                <label class="form-label" for="id_categorie">Catégorie du Permis <span style="color: var(--danger);">*</span></label>
                <select name="id_categorie" id="id_categorie" class="form-control" required>
                    <option value="" disabled selected>Sélectionner une catégorie</option>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat['id_categorie']) ?>">
                                Permis <?= htmlspecialchars($cat['nom_categorie']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="1">Permis B (Voiture)</option>
                        <option value="2">Permis A (Moto)</option>
                        <option value="3">Permis C (Poids lourd)</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="dashboard-grid" style="grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 0;">
                <div class="form-group">
                    <label class="form-label" for="date_contrat">Date du Contrat <span style="color: var(--danger);">*</span></label>
                    <input type="date" name="date_contrat" id="date_contrat" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="prix_final">Prix Final (DH) <span style="color: var(--danger);">*</span></label>
                    <input type="number" step="0.01" name="prix_final" id="prix_final" class="form-control" placeholder="ex: 3500.00" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="statut">Statut Initial</label>
                <select name="statut" id="statut" class="form-control">
                    <option value="En cours" selected>En cours</option>
                    <option value="Soldé">Soldé</option>
                    <option value="Annulé">Annulé</option>
                </select>
            </div>

            <!-- Form Actions -->
            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border-color);">
                <a href="/smart-auto-ecole/public/candidates/show?id=<?= htmlspecialchars($_GET['id_user'] ?? '') ?>" class="btn btn-secondary">
                    Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Enregistrer le Contrat
                </button>
            </div>
        </form>
    </div>
</div>