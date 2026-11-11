<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
/* =========================================================
   Vue : Programmer une séance (UC08)
   Variables fournies par PlanningController::create() :
     $moniteurs, $vehicules, $candidats, $categories, $old
   Mode modification : $isEdit = true, $nbCandidats (la gestion des candidats se fait depuis le planning)
   ========================================================= */
$h = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
$isEdit = $isEdit ?? false;
$nbCandidats = $nbCandidats ?? 0;
$jsonFlags = JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE;

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<link rel="stylesheet" href="<?= BASE_URL ?>/css/planning.css">

    <main class="page-content pl-scope">
        <div class="card-header">
            <div>
                <h1 style="font-size: 22px;"><?= $isEdit ? 'Modifier la séance #' . (int)$_GET['id'] : 'Programmer une séance' ?></h1>
                <p class="card-description"><?= $isEdit
                    ? "Modifiez le type, l'horaire, le moniteur ou le véhicule."
                    : "Choisissez le type, l'horaire, le moniteur, le véhicule et les candidats." ?></p>
            </div>
            <a href="<?= BASE_URL ?>/planning" class="btn btn-secondary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                Retour au planning
            </a>
        </div>

        <form action="<?= BASE_URL ?>/planning/<?= $isEdit ? 'update' : 'store' ?>" method="POST" id="createForm">
            <?php if ($isEdit): ?><input type="hidden" name="id_seance" value="<?= (int)$_GET['id'] ?>"><?php endif; ?>
            <div class="pl-form-grid <?= $isEdit ? 'single' : '' ?>">

                <!-- ===== Informations de la séance ===== -->
                <section class="card pl-form-card">
                    <h2 class="card-title" style="margin-bottom: 18px;"><?= $isEdit ? 'Informations de la séance' : 'Informations de la séance' ?></h2>

                    <div class="form-group">
                        <label class="form-label">Type de séance</label>
                        <div class="pl-type">
                            <input type="radio" name="type" id="ty-conduite" value="Conduite" <?= $old['type'] !== 'Code' ? 'checked' : '' ?>>
                            <label for="ty-conduite" class="l-conduite">🚗 Conduite</label>
                            <input type="radio" name="type" id="ty-code" value="Code" <?= $old['type'] === 'Code' ? 'checked' : '' ?>>
                            <label for="ty-code" class="l-code">📘 Code</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="fDate">Date</label>
                        <input type="date" name="date" id="fDate" class="form-control" value="<?= $h($old['date']) ?>" required>
                    </div>

                    <div class="pl-row2 form-group">
                        <div>
                            <label class="form-label" for="fDebut">Heure début</label>
                            <input type="time" name="heure_debut" id="fDebut" class="form-control" value="<?= $h($old['heure_debut']) ?>" required>
                        </div>
                        <div>
                            <label class="form-label" for="fFin">Heure fin</label>
                            <input type="time" name="heure_fin" id="fFin" class="form-control" value="<?= $h($old['heure_fin']) ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="fMon">Moniteur <span class="pl-req">*</span></label>
                        <select name="id_moniteur" id="fMon" class="form-control">
                            <option value="">-- Sélectionner un moniteur --</option>
                            <?php foreach ($moniteurs as $m): ?>
                                <option value="<?= $h($m['id_user']) ?>" <?= (string)$old['id_moniteur'] === (string)$m['id_user'] ? 'selected' : '' ?>>
                                    <?= $h($m['nom'] . ' ' . $m['prenom']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (empty($moniteurs)): ?>
                            <div class="pl-help">Aucun moniteur disponible. Ajoutez d'abord un moniteur dans la gestion du personnel.</div>
                        <?php endif; ?>
                    </div>

                    <!-- Le véhicule n'apparaît que pour une séance de Conduite -->
                    <div class="form-group" id="vehGroup">
                        <label class="form-label" for="fVeh">Véhicule <span class="pl-req">*</span></label>
                        <select name="id_vehicule" id="fVeh" class="form-control">
                            <option value="">-- Sélectionner un véhicule --</option>
                            <?php foreach ($vehicules as $v): ?>
                                <option value="<?= $h($v['id_vehicule']) ?>" <?= (string)$old['id_vehicule'] === (string)$v['id_vehicule'] ? 'selected' : '' ?>>
                                    <?= $h($v['marque'] . ' (' . $v['immatriculation'] . ')') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php if ($isEdit): ?>
                        <div class="pl-note" style="margin-bottom:0;">
                            <?= (int)$nbCandidats ?> candidat<?= $nbCandidats > 1 ? 's' : '' ?> inscrit<?= $nbCandidats > 1 ? 's' : '' ?>.
                            Pour en ajouter ou en retirer, ouvrez la séance depuis le planning.
                        </div>
                    <?php endif; ?>
                </section>

                <?php if (!$isEdit): ?>
                <!-- ===== Candidats ===== -->
                <section class="card pl-form-card">
                    <h2 class="card-title" style="margin-bottom: 4px;">Candidats</h2>
                    <p class="card-description" style="margin-bottom: 14px;">Les candidats sont affichés avec la catégorie de permis de leur contrat. Optionnel : vous pourrez en ajouter plus tard depuis le planning.</p>

                    <div class="pl-row2">
                        <select id="catFilter" class="form-control" aria-label="Catégorie de permis">
                            <option value="">Toutes les catégories de permis</option>
                            <?php foreach ($categories as $id => $label): ?>
                                <option value="<?= $h($label) ?>"><?= $h($label) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" id="pickSearch" class="form-control" placeholder="Rechercher (nom, n° d'enregistrement)…">
                    </div>

                    <div class="pl-pick" id="pickList">
                        <?php if (empty($candidats)): ?>
                            <div class="pl-pick-empty">Aucun candidat avec un contrat en cours.</div>
                        <?php endif; ?>
                        <?php foreach ($candidats as $c): ?>
                            <label data-cat="<?= $h($c['categorie']) ?>" data-search="<?= $h(mb_strtolower($c['nom'] . ' ' . $c['prenom'] . ' ' . $c['num_enregistrement'])) ?>">
                                <input type="checkbox" name="candidats[]" value="<?= $h($c['id_contrat']) ?>"
                                    <?= in_array((int)$c['id_contrat'], $old['candidats'], true) ? 'checked' : '' ?>>
                                <?= $h($c['nom'] . ' ' . $c['prenom']) ?>
                                <span class="pl-cat"><?= $h($c['categorie']) ?></span>
                                <small><?= $h($c['num_enregistrement']) ?></small>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <div class="pl-help" id="pickCount">0 candidat sélectionné</div>
                </section>
                <?php endif; ?>
            </div>

            <div class="pl-error" id="createError"></div>

            <div class="pl-form-actions">
                <a href="<?= BASE_URL ?>/planning" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Enregistrer les modifications' : 'Enregistrer la séance' ?></button>
            </div>
        </form>
    </main>

    <script>window.PLANNING_CREATE = <?= json_encode(['flash' => $flash], $jsonFlags) ?>;</script>
    <script src="<?= BASE_URL ?>/js/planningCreate.js"></script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>