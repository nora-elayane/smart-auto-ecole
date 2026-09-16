<div class="page-content" style="width: 100% !important; max-width: 100% !important; padding: 0 !important; box-sizing: border-box;">
    <link rel="stylesheet" href="/smart-auto-ecole/public/css/style.css">
    <link rel="stylesheet" href="/smart-auto-ecole/public/css/toast.css">
    <link rel="stylesheet" href="/smart-auto-ecole/public/css/buttons.css">

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

    <div class="card-header" style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 22px; font-weight: 700; color: var(--text-primary); margin: 0;">Fiche Candidat</h1>
            <p class="card-description" style="margin: 4px 0 0 0;">Détails du candidat et gestion de ses contrats d'apprentissage.</p>
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

    <!-- بطاقة تفاصيل المرشح -->
    <div class="card" style="margin-bottom: 24px; padding: 24px; width: 100% !important; box-sizing: border-box;">
        <div class="d-flex align-items-center justify-content-between mb-4 pb-3" style="border-bottom: 1px solid var(--border-color, #eef2f6);">
            <div class="d-flex align-items-center gap-3">
                <div class="profile-avatar-wrapper">
                    <?php 
                        $photoName = $candidat['photo'] ?? '';
                        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/smart-auto-ecole/public/uploads/';
                        $hasPhoto = !empty($photoName) && file_exists($uploadDir . $photoName);
                    ?>

                    <?php if ($hasPhoto): ?>
                        <img src="/smart-auto-ecole/public/uploads/<?= htmlspecialchars($photoName) ?>" 
                             alt="Photo Candidate" 
                             style="width: 72px; height: 72px; border-radius: 50%; object-fit: cover; border: 3px solid #f1f5f9; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    <?php else: ?>
                        <div style="width: 72px; height: 72px; border-radius: 50%; background: #e2e8f0; color: #475569; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 22px; border: 3px solid #f1f5f9;">
                            <?= strtoupper(substr($candidat['nom'] ?? 'C', 0, 1) . substr($candidat['prenom'] ?? '', 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div>
                    <h2 class="card-title" style="margin: 0; font-size: 20px; font-weight: 700; color: var(--text-primary);">
                        <?= htmlspecialchars(($candidat['nom'] ?? '') . ' ' . ($candidat['prenom'] ?? '')) ?>
                    </h2>
                    <span class="card-description" style="font-size: 13px;">Fiche détaillée du candidat</span>
                </div>
            </div>

            <span class="badge <?= ($candidat['etat'] ?? '') === 'Actif' ? 'badge-success' : 'badge-danger' ?>" style="padding: 6px 14px; font-size: 13px; font-weight: 600;">
                <?= htmlspecialchars($candidat['etat'] ?? 'Actif') ?>
            </span>
        </div>
        
        <div class="dashboard-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; width: 100%;">
            <div class="info-item">
                <span class="card-description" style="display: block; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b;">CIN</span>
                <p style="font-weight: 600; font-size: 15px; margin-top: 4px; margin-bottom: 0; color: var(--text-primary);">
                    <?= htmlspecialchars($candidat['cin'] ?? '-') ?>
                </p>
            </div>

            <div class="info-item">
                <span class="card-description" style="display: block; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b;">Téléphone</span>
                <p style="font-weight: 600; font-size: 15px; margin-top: 4px; margin-bottom: 0; color: var(--text-primary);">
                    <?= htmlspecialchars($candidat['telephone'] ?? '-') ?>
                </p>
            </div>

            <div class="info-item">
                <span class="card-description" style="display: block; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b;">Email</span>
                <p style="font-weight: 600; font-size: 15px; margin-top: 4px; margin-bottom: 0; color: var(--text-primary);">
                    <?= htmlspecialchars($candidat['email'] ?? '-') ?>
                </p>
            </div>

            <div class="info-item">
                <span class="card-description" style="display: block; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b;">Date de Naissance</span>
                <p style="font-weight: 600; font-size: 15px; margin-top: 4px; margin-bottom: 0; color: var(--text-primary);">
                    <?= htmlspecialchars($candidat['date_naissance'] ?? '-') ?>
                </p>
            </div>

            <div class="info-item" style="grid-column: span 2;">
                <span class="card-description" style="display: block; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b;">Adresse</span>
                <p style="font-weight: 600; font-size: 15px; margin-top: 4px; margin-bottom: 0; color: var(--text-primary);">
                    <?= htmlspecialchars($candidat['adresse'] ?? '-') ?>
                </p>
            </div>
        </div>
    </div>

    <!-- بطاقة العقود -->
    <div class="card" style="width: 100% !important; padding: 20px; box-sizing: border-box; overflow: visible;">
        <div class="card-header" style="margin-bottom: 15px;">
            <div>
                <h2 class="card-title" style="margin: 0; font-size: 18px; font-weight: 700;">Liste des Contrats</h2>
                <p class="card-description" style="margin: 2px 0 0 0;">Historique des souscriptions aux permis de conduire.</p>
            </div>
        </div>

        <div class="table-wrapper table-container" style="width: 100% !important; padding: 0; background: #fff; border-radius: 10px; overflow-x: auto; overflow-y: visible;">
            
            <!-- شريط العمليات -->
            <div id="actionBar" class="action-bar-overlay" style="margin-bottom: 15px; padding: 5px 0;">
                <div class="d-flex align-items-center gap-3">
                    <span id="selectedCount" class="badge bg-primary">0 sélectionné(s)</span>
                    <button type="button" id="btnEdit" data-action-url="/smart-auto-ecole/public/candidates/contrats/edit" class="btn btn-sm btn-outline-secondary">
                        Éditer
                    </button>
                    <button type="button" id="btnDelete" data-action-url="/smart-auto-ecole/public/candidates/contrats/delete" class="btn btn-sm btn-outline-danger">
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

            <table class="table align-middle" style="width: 100% !important; min-width: 950px; margin-bottom: 0; table-layout: fixed;">
                <thead>
                    <tr>
                        <th style="width: 45px;"><input type="checkbox" id="selectAll" class="form-check-input"></th>
                        <th style="width: 160px;">N° CONTRAT</th>
                        <th style="width: 140px;">CATÉGORIE</th>
                        <th style="width: 150px;">DATE CONTRAT</th>
                        <th style="width: 150px;">PRIX FINAL</th>
                        <th style="width: 130px;">STATUT</th>
                        <th style="width: 120px; text-align: right;">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($contrats) && is_array($contrats)): ?>
                        <?php foreach ($contrats as $contrat): ?>
                            <tr>
                                <td><input type="checkbox" class="select-row" value="<?= htmlspecialchars($contrat['id_contrat']) ?>"></td>
                                <td class="text-start">
                                    <div style="font-weight: 600; color: var(--text-primary);">
                                        #<?= htmlspecialchars($contrat['id_contrat']) ?>
                                    </div>
                                    <?php if (!empty($contrat['num_enregistrement'])): ?>
                                        <small style="color: #6b7280; font-size: 11px; display: block;">
                                            Ref: <?= htmlspecialchars($contrat['num_enregistrement']) ?>
                                        </small>
                                    <?php else: ?>
                                        <small style="color: #9ca3af; font-size: 11px; display: block; font-style: italic;">
                                            Non enregistré
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge badge-warning" style="background: #eff6ff; color: var(--primary);">
                                        Permis <?= htmlspecialchars($contrat['code']) ?>
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
                                    <a href="/smart-auto-ecole/public/candidates/contrats/show?id=<?= htmlspecialchars($contrat['id_contrat']) ?>" class="btn btn-secondary" style="min-height: 32px; padding: 0 12px; font-size: 12px; white-space: nowrap;">
                                        Consulter
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center; color: var(--text-secondary); padding: 24px;">
                                Aucun contrat trouvé pour ce candidat.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="/smart-auto-ecole/public/js/table-actions.js"></script>

