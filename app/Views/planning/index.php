<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
/* =========================================================
   Vue : Planning
   Variables fournies par PlanningController::index() :
     $week, $stats, $seancesList, $seancesJs,
     $candidatsJs,
     $canManage, $canValidate, $isCandidat
   (aucune logique métier ici : affichage uniquement)
   ========================================================= */
$h = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
$joursCourts = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
$jsonFlags = JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE;

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$presenceCls = fn($p) => $p === 'Présent' ? 'p-present' : ($p === 'Absent' ? 'p-absent' : 'p-attente');

$description = $canManage
    ? 'Programmation des séances de Code et de Conduite, et suivi des candidats.'
    : ($canValidate ? 'Vos séances programmées. Validez-les une fois réalisées.' : 'Vos séances programmées.');

$planningConfig = [
    'base'        => BASE_URL,
    'seances'     => $seancesJs,
    'candidats'   => $candidatsJs,
    'gridStart'   => $week['minMin'],
    'today'       => $week['today'],
    'canManage'   => $canManage,
    'canValidate' => $canValidate,
    'isCandidat'  => $isCandidat,
    'openId'      => isset($_GET['open']) ? (int)$_GET['open'] : null,
    'flash'       => $flash,
];
?>
<link rel="stylesheet" href="<?= BASE_URL ?>/css/planning.css">

    <main class="page-content pl-scope">
        <!-- En-tête de page -->
        <div class="card-header">
            <div>
                <h1 style="font-size: 22px;">Gestion du Planning</h1>
            </div>
            <?php if ($canManage): ?>
                <a href="<?= BASE_URL ?>/planning/create" class="btn btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Ajouter une séance
                </a>
            <?php endif; ?>
        </div>

        <!-- Statistiques de la semaine -->
        <div class="dashboard-grid pl-stat-gap">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <div class="dashboard-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                </div>
                <div class="dashboard-card-value"><?= (int)$stats['total'] ?></div>
                <div class="dashboard-card-label">Séances cette semaine</div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <div class="dashboard-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                    </div>
                </div>
                <div class="dashboard-card-value"><?= (int)$stats['code'] ?></div>
                <div class="dashboard-card-label">Séances de Code</div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <div class="dashboard-card-icon" style="background:#f0fdf4;color:var(--success);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/><line x1="12" y1="2" x2="12" y2="9"/><line x1="4.9" y1="16.5" x2="9.9" y2="13.5"/><line x1="19.1" y1="16.5" x2="14.1" y2="13.5"/></svg>
                    </div>
                </div>
                <div class="dashboard-card-value"><?= (int)$stats['conduite'] ?></div>
                <div class="dashboard-card-label">Séances de Conduite</div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <div class="dashboard-card-icon" style="background:#fffbeb;color:var(--warning);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                </div>
                <div class="dashboard-card-value"><?= (int)$stats['fourth']['value'] ?></div>
                <div class="dashboard-card-label"><?= $h($stats['fourth']['label']) ?></div>
            </div>
        </div>

        <!-- Barre d'outils -->
        <div class="pl-toolbar">
            <div class="pl-toolbar-left" id="weekNav">
                <a class="btn btn-secondary pl-icon-btn" href="<?= BASE_URL ?>/planning?week=<?= $h($week['prev']) ?>" aria-label="Semaine précédente">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                </a>
                <span class="pl-week-label"><?= $h($week['label']) ?></span>
                <a class="btn btn-secondary pl-icon-btn" href="<?= BASE_URL ?>/planning?week=<?= $h($week['next']) ?>" aria-label="Semaine suivante">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
                <a class="btn btn-secondary" href="<?= BASE_URL ?>/planning">Aujourd'hui</a>
            </div>
            <div class="pl-toolbar-right">
                <div class="pl-legend">
                    <span><i style="background:var(--code-bd)"></i>Code</span>
                    <span><i style="background:var(--drv-bd)"></i>Conduite</span>
                </div>
                <div class="pl-seg" id="viewSwitch">
                    <button type="button" class="active" data-view="week">Semaine</button>
                    <button type="button" data-view="list">Liste</button>
                </div>
            </div>
        </div>

        <!-- ================= VUE SEMAINE ================= -->
        <div id="viewWeek">
            <div class="pl-cal">
                <div class="pl-cal-inner">
                    <div class="pl-cal-head">
                        <div></div>
                        <?php foreach ($week['days'] as $i => $d): $cnt = count($week['events'][$d]); ?>
                            <div class="pl-dayhead <?= $d === $week['today'] ? 'today' : '' ?>">
                                <div class="dn"><?= $joursCourts[$i] ?></div>
                                <div class="dd"><?= date('j', strtotime($d)) ?></div>
                                <span class="cnt"><?= $cnt ? $cnt . ' séance' . ($cnt > 1 ? 's' : '') : '' ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="pl-cal-body" style="height: <?= (int)$week['gridHeight'] ?>px;">
                        <div class="pl-hours">
                            <?php for ($m = $week['minMin'] + 60; $m < $week['maxMin']; $m += 60): ?>
                                <span class="pl-hour-label" style="top: <?= $m - $week['minMin'] ?>px;"><?= sprintf('%02d:00', $m / 60) ?></span>
                            <?php endfor; ?>
                        </div>

                        <?php foreach ($week['days'] as $d):
                            $cls = trim(($d === $week['today'] ? 'today' : '') . ($d < $week['today'] ? ' past' : '') . ($canManage ? ' can-add' : '')); ?>
                            <div class="pl-col <?= $cls ?>" data-date="<?= $h($d) ?>">
                                <?php if ($d === $week['today'] && $week['nowTop'] !== null): ?>
                                    <div class="pl-now" style="top: <?= (int)$week['nowTop'] ?>px;"></div>
                                <?php endif; ?>

                                <?php foreach ($week['events'][$d] as $ev):
                                    $w = 100 / $ev['_lanes'];
                                    $isCode = $ev['type'] === 'Code';
                                    $done = $ev['statut'] === 'Réalisée'; ?>
                                    <div class="pl-ev <?= $isCode ? 'code' : 'conduite' ?> <?= $done ? 'done' : '' ?>"
                                         data-id="<?= (int)$ev['id'] ?>"
                                         style="top: <?= (int)$ev['_top'] ?>px; height: <?= (int)$ev['_h'] - 2 ?>px; left: calc(<?= $ev['_lane'] * $w ?>% + 2px); width: calc(<?= $w ?>% - 4px);">
                                        <div class="t">
                                            <span><?= $h($ev['type']) ?><?= $done ? ' ✓' : '' ?></span>
                                            <span class="tm"><?= $h($ev['debut']) ?>–<?= $h($ev['fin']) ?></span>
                                        </div>
                                        <?php if ($ev['moniteur'] !== ''): ?><div class="m"><?= $h($ev['moniteur']) ?></div><?php endif; ?>
                                        <?php if ($ev['marque'] !== ''): ?><div class="m"><?= $h($ev['marque']) ?></div><?php endif; ?>
                                        <?php if (!$isCandidat): ?><span class="pc">👥 <?= (int)$ev['nb'] ?></span><?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <p class="pl-help" style="margin-top:10px;">
                <?= $canManage
                    ? 'Astuce : cliquez sur un créneau vide pour programmer une séance, ou sur une séance pour gérer ses candidats.'
                    : 'Cliquez sur une séance pour voir ses détails.' ?>
            </p>
        </div>

        <!-- ================= VUE LISTE ================= -->
        <div id="viewList">
            <div class="pl-list-tools">
                <select id="fType" class="form-control">
                    <option value="">Tous les types</option>
                    <option value="Code">Code</option>
                    <option value="Conduite">Conduite</option>
                </select>
                <input type="text" id="fSearch" class="form-control" placeholder="Rechercher (moniteur, véhicule, date…)">
            </div>
            <div class="table-wrapper">
                <table class="table" id="listTable">
                    <thead>
                        <tr>
                            <th># ID</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Horaire</th>
                            <th>Moniteur</th>
                            <th>Véhicule</th>
                            <th><?= $isCandidat ? 'Ma présence' : 'Candidats' ?></th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($seancesList)): ?>
                            <?php foreach ($seancesList as $s): ?>
                                <tr data-id="<?= (int)$s['id'] ?>" data-type="<?= $h($s['type']) ?>">
                                    <td>#<?= (int)$s['id'] ?></td>
                                    <td><span class="pl-badge <?= $s['type'] === 'Code' ? 'code' : 'conduite' ?>"><?= $h($s['type']) ?></span></td>
                                    <td><?= $h($s['dateFr']) ?></td>
                                    <td><?= $h($s['debut']) ?> – <?= $h($s['fin']) ?></td>
                                    <td><?= $s['moniteur'] !== '' ? $h($s['moniteur']) : '<span class="pl-dash">—</span>' ?></td>
                                    <td><?= $s['vehicule'] !== '' ? $h($s['vehicule']) : '<span class="pl-dash">—</span>' ?></td>
                                    <td>
                                        <?php if ($isCandidat): ?>
                                            <span class="pl-badge <?= $presenceCls($s['maPresence']) ?>"><?= $h($s['maPresence'] ?: 'En attente') ?></span>
                                        <?php else: ?>
                                            <span class="pl-count">👥 <?= (int)$s['nb'] ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><span class="pl-badge <?= $s['statut'] === 'Réalisée' ? 'done' : 'planned' ?>"><?= $h($s['statut']) ?></span></td>
                                    <td><button type="button" class="btn btn-secondary pl-btn-sm">Détails</button></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr class="pl-empty-row"><td colspan="9">Aucune séance programmée pour le moment.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- ================= TIROIR : DÉTAILS SÉANCE ================= -->
    <div class="pl-overlay" id="drawerOverlay"></div>
    <aside class="pl-drawer" id="drawer" aria-hidden="true">
        <div class="pl-drawer-head">
            <div>
                <span id="dBadge"></span>
                <h2 id="dTitle"></h2>
                <p id="dSub"></p>
            </div>
            <button type="button" class="pl-x" data-close-drawer aria-label="Fermer">&times;</button>
        </div>
        <div class="pl-drawer-body" id="dBody"></div>
        <div class="pl-drawer-foot">
            <?php if ($canManage): ?>
                <div class="pl-foot-left">
                    <form action="<?= BASE_URL ?>/planning/delete" method="POST" data-confirm="Voulez-vous vraiment supprimer cette séance ?">
                        <input type="hidden" name="id_seance" id="dDeleteId">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                    <a href="#" id="dEditLink" class="btn btn-secondary">Modifier</a>
                </div>
            <?php else: ?>
                <span></span>
            <?php endif; ?>
            <button type="button" class="btn btn-secondary" data-close-drawer>Fermer</button>
        </div>
    </aside>

    <script>window.PLANNING = <?= json_encode($planningConfig, $jsonFlags) ?>;</script>
    <script src="<?= BASE_URL ?>/js/planning.js"></script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>