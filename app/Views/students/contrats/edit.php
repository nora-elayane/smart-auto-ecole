<div class="page-content" style="max-width: 800px; margin: 0 auto;">
    <link rel="stylesheet" href="/smart-auto-ecole/public/css/style.css">
    <link rel="stylesheet" href="/smart-auto-ecole/public/css/toast.css">
    
    <div class="card-header" style="margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 22px; font-weight: 700; color: var(--text-primary);">Modifier le Contrat</h1>
            <p class="card-description">Mise à jour des informations du contrat N° #<?= htmlspecialchars($contrat['id_contrat'] ?? '') ?></p>
        </div>
        <a href="/smart-auto-ecole/public/candidates/show?id=<?= htmlspecialchars($contrat['id_user'] ?? $_GET['student_id'] ?? '') ?>" class="btn btn-secondary">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Annuler
        </a>
    </div>

    <div class="card">
        <form action="/smart-auto-ecole/public/candidates/contrats/update" method="POST">
            <input type="hidden" name="id_contrat" value="<?= htmlspecialchars($contrat['id_contrat'] ?? '') ?>">
            <input type="hidden" name="id_user" value="<?= htmlspecialchars($contrat['id_user'] ?? $_GET['student_id'] ?? '') ?>">

            <div class="form-group">
                <label class="form-label" for="id_categorie">Catégorie du Permis <span style="color: var(--danger);">*</span></label>
                <select name="id_categorie" id="id_categorie" class="form-control" required>
                    <option value="" disabled>Sélectionner une catégorie</option>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat['id_categorie']) ?>" 
                                <?= (isset($contrat['id_categorie']) && $contrat['id_categorie'] == $cat['id_categorie']) ? 'selected' : '' ?>>
                                Permis <?= htmlspecialchars($cat['code']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="dashboard-grid" style="grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 0;">
                <div class="form-group">
                    <label class="form-label" for="date_contrat">Date du Contrat <span style="color: var(--danger);">*</span></label>
                    <input type="date" name="date_contrat" id="date_contrat" class="form-control" 
                           value="<?= htmlspecialchars($contrat['date_contrat'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="prix_final">Prix Final (DH) <span style="color: var(--danger);">*</span></label>
                    <input type="number" step="0.01" name="prix_final" id="prix_final" class="form-control" 
                           value="<?= htmlspecialchars($contrat['prix_final'] ?? '') ?>" placeholder="ex: 3500.00" required>
                </div>
            </div>
            <div class="form-group">
    <label class="form-label" for="num_enregistrement">N° d'enregistrement (NARSA / Ref Web)</label>
    <input type="text" name="num_enregistrement" id="num_enregistrement" class="form-control" 
           value="<?= htmlspecialchars($contrat['num_enregistrement'] ?? '') ?>" placeholder="ex: 12345678 أو Ref Web">
</div>

            <!-- Statut -->
            <div class="form-group">
                <label class="form-label" for="statut">Statut du Contrat</label>
                <select name="statut" id="statut" class="form-control">
                    <?php $statut = $contrat['statut'] ?? 'En cours'; ?>
                    <option value="En cours" <?= $statut === 'En cours' ? 'selected' : '' ?>>En cours</option>
                    <option value="Soldé" <?= $statut === 'Soldé' ? 'selected' : '' ?>>Soldé</option>
                    <option value="Annulé" <?= $statut === 'Annulé' ? 'selected' : '' ?>>Annulé</option>
                </select>
            </div>

            <!-- Form Actions -->
            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border-color);">
                <a href="/smart-auto-ecole/public/candidates/show?id=<?= htmlspecialchars($contrat['id_user'] ?? $_GET['student_id'] ?? '') ?>" class="btn btn-secondary">
                    Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>