<?php
/* =========================================================
   Vue : Planning (vue semaine + liste + candidats)
   Données attendues du contrôleur :
     $seances   : séances (+ clé 'participants' => getParticipantsBySeance())
     $moniteurs : liste des moniteurs
     $vehicules : liste des véhicules
     $candidats : liste des contrats [id_contrat, num_enregistrement, nom, prenom]
   ========================================================= */
$h = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');

$seances   = $seances   ?? [];
$moniteurs = $moniteurs ?? [];
$vehicules = $vehicules ?? [];
$candidats = $candidats ?? [];

$joursCourts = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
$moisCourts  = ['janv.', 'févr.', 'mars', 'avr.', 'mai', 'juin', 'juil.', 'août', 'sept.', 'oct.', 'nov.', 'déc.'];
$toMin = fn($t) => intval(substr((string)$t, 0, 2)) * 60 + intval(substr((string)$t, 3, 2));
$hm    = fn($t) => substr((string)$t, 0, 5);

/* ---------- Semaine affichée ---------- */
$weekParam = $_GET['week'] ?? '';
$base   = preg_match('/^\d{4}-\d{2}-\d{2}$/', $weekParam) ? strtotime($weekParam) : time();
$monday = strtotime('monday this week', $base);
$today  = date('Y-m-d');
$days   = [];
for ($i = 0; $i < 7; $i++) { $days[] = date('Y-m-d', strtotime("+$i day", $monday)); }
$prevWeek = date('Y-m-d', strtotime('-7 day', $monday));
$nextWeek = date('Y-m-d', strtotime('+7 day', $monday));
$sunday   = strtotime('+6 day', $monday);
$weekLabel = date('j', $monday) . ' ' . $moisCourts[date('n', $monday) - 1]
           . ' – ' . date('j', $sunday) . ' ' . $moisCourts[date('n', $sunday) - 1] . ' ' . date('Y', $sunday);

/* ---------- Séances de la semaine, plage horaire, statistiques ---------- */
$weekSeances = array_values(array_filter($seances, fn($s) => in_array($s['date'], $days, true)));
$minMin = 7 * 60;
$maxMin = 20 * 60;
foreach ($weekSeances as $s) {
    $minMin = min($minMin, intdiv($toMin($s['heure_debut']), 60) * 60);
    $maxMin = max($maxMin, (int)ceil($toMin($s['heure_fin']) / 60) * 60);
}
$gridHeight = $maxMin - $minMin; // 1 minute = 1px

$stCode = 0; $stConduite = 0; $stCandidats = 0;
foreach ($weekSeances as $s) {
    if ($s['type'] === 'Code') { $stCode++; } else { $stConduite++; }
    $stCandidats += count($s['participants'] ?? []);
}

/* ---------- Placement des blocs (gestion des chevauchements) ---------- */
$eventsByDay = [];
foreach ($days as $d) {
    $evs = array_values(array_filter($weekSeances, fn($s) => $s['date'] === $d));
    usort($evs, fn($a, $b) => $toMin($a['heure_debut']) <=> $toMin($b['heure_debut']));
    $laneEnds = [];
    foreach ($evs as &$ev) {
        $st = $toMin($ev['heure_debut']);
        $en = max($toMin($ev['heure_fin']), $st + 30);
        $lane = null;
        foreach ($laneEnds as $i => $end) { if ($end <= $st) { $lane = $i; break; } }
        if ($lane === null) { $lane = count($laneEnds); }
        $laneEnds[$lane] = $en;
        $ev['_lane'] = $lane;
        $ev['_top']  = $st - $minMin;
        $ev['_h']    = $en - $st;
    }
    unset($ev);
    foreach ($evs as &$ev) { $ev['_lanes'] = max(count($laneEnds), 1); }
    unset($ev);
    $eventsByDay[$d] = $evs;
}

/* ---------- Liste (toutes les séances, triées) ---------- */
$listSeances = $seances;
usort($listSeances, fn($a, $b) => strcmp($b['date'] . $b['heure_debut'], $a['date'] . $a['heure_debut']));

/* ---------- Données JSON pour le tiroir de détails ---------- */
$jsSeances = [];
foreach ($seances as $s) {
    $parts = [];
    foreach (($s['participants'] ?? []) as $p) {
        $parts[] = [
            'id_participation' => $p['id_participation'] ?? null,
            'id_contrat'       => $p['id_contrat'] ?? null,
            'presence'         => $p['presence'] ?? 'En attente',
            'remarque'         => $p['remarque'] ?? '',
            'num'              => $p['num_enregistrement'] ?? '',
            'nom'              => $p['nom'] ?? '',
            'prenom'           => $p['prenom'] ?? '',
            'tel'              => $p['telephone'] ?? '',
        ];
    }
    $jsSeances[$s['id_seance']] = [
        'id'        => $s['id_seance'],
        'type'      => $s['type'],
        'date'      => $s['date'],
        'dateFr'    => date('d/m/Y', strtotime($s['date'])),
        'debut'     => $hm($s['heure_debut']),
        'fin'       => $hm($s['heure_fin']),
        'moniteur'  => !empty($s['moniteur_nom']) ? trim($s['moniteur_nom'] . ' ' . $s['moniteur_prenom']) : '',
        'vehicule'  => !empty($s['immatriculation']) ? $s['marque'] . ' (' . $s['immatriculation'] . ')' : '',
        'participants' => $parts,
    ];
}
$jsCandidats = array_map(fn($c) => [
    'id'     => $c['id_contrat'],
    'num'    => $c['num_enregistrement'] ?? '',
    'nom'    => $c['nom'] ?? '',
    'prenom' => $c['prenom'] ?? '',
], $candidats);
$jsonFlags = JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE;

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion du Planning - Smart Auto-École</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/buttons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/toast.css">

    <style>
        /* Couleurs par type de séance */
        .pl-scope {
            --code-bg: #eff6ff;  --code-bd: #2563eb;  --code-tx: #1d4ed8;
            --drv-bg:  #f0fdf4;  --drv-bd:  #16a34a;  --drv-tx:  #166534;
            --hour-h: 60px;
        }

        /* ---------- Barre d'outils ---------- */
        .pl-toolbar {
            display: flex; align-items: center; justify-content: space-between;
            gap: 12px; flex-wrap: wrap; margin-bottom: 16px;
        }
        .pl-toolbar-left, .pl-toolbar-right { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .pl-week-label { font-size: 16px; font-weight: 700; letter-spacing: -.2px; min-width: 190px; text-align: center; }
        .pl-icon-btn { width: 40px; padding: 0; }

        .pl-seg { display: inline-flex; padding: 3px; gap: 2px; background: #e2e8f0; border-radius: var(--radius-md); }
        .pl-seg button {
            border: 0; background: transparent; padding: 7px 14px; border-radius: 8px;
            font-size: 13px; font-weight: 600; color: var(--text-secondary); transition: all var(--transition);
        }
        .pl-seg button.active { background: #fff; color: var(--primary); box-shadow: var(--shadow-sm); }

        .pl-legend { display: flex; gap: 14px; font-size: 12.5px; color: var(--text-secondary); }
        .pl-legend i { display: inline-block; width: 10px; height: 10px; border-radius: 3px; margin-right: 6px; vertical-align: -1px; }

        /* ---------- Calendrier ---------- */
        .pl-cal { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); overflow: auto; }
        .pl-cal-inner { min-width: 900px; }
        .pl-cal-head, .pl-cal-body { display: grid; grid-template-columns: 64px repeat(7, 1fr); }
        .pl-cal-head { position: sticky; top: 0; z-index: 5; background: #f8fafc; border-bottom: 1px solid var(--border-color); }
        .pl-dayhead { padding: 10px 8px; text-align: center; border-left: 1px solid var(--border-color); }
        .pl-dayhead .dn { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: var(--text-secondary); }
        .pl-dayhead .dd {
            display: inline-grid; place-items: center; width: 34px; height: 34px; margin-top: 2px;
            border-radius: 50%; font-size: 17px; font-weight: 700;
        }
        .pl-dayhead.today .dd { background: var(--primary); color: #fff; }
        .pl-dayhead.today .dn { color: var(--primary); }
        .pl-dayhead .cnt { display: block; font-size: 11px; color: var(--text-light); min-height: 16px; }

        .pl-hours { position: relative; }
        .pl-hour-label {
            position: absolute; right: 8px; transform: translateY(-50%);
            font-size: 11px; color: var(--text-light); font-variant-numeric: tabular-nums; background: var(--card-bg); padding: 0 2px;
        }
        .pl-col {
            position: relative; border-left: 1px solid var(--border-color); cursor: cell;
            background-image: linear-gradient(to bottom, transparent calc(var(--hour-h) - 1px), #eef2f7 calc(var(--hour-h) - 1px));
            background-size: 100% var(--hour-h);
        }
        .pl-col.today { background-color: #f8fbff; }
        .pl-col.past::after { content: ""; position: absolute; inset: 0; background: rgba(248,250,252,.55); pointer-events: none; }

        .pl-now { position: absolute; left: 0; right: 0; height: 2px; background: #ef4444; z-index: 4; pointer-events: none; }
        .pl-now::before { content: ""; position: absolute; left: -5px; top: -4px; width: 10px; height: 10px; border-radius: 50%; background: #ef4444; }

        .pl-ev {
            position: absolute; z-index: 2; padding: 6px 8px 6px 10px; overflow: hidden;
            border-radius: 8px; border-left: 4px solid; cursor: pointer; font-size: 12px; line-height: 1.3;
            box-shadow: 0 1px 2px rgba(15,23,42,.08); transition: transform .12s ease, box-shadow .12s ease;
        }
        .pl-ev:hover { transform: translateY(-1px); box-shadow: 0 6px 14px rgba(15,23,42,.14); z-index: 3; }
        .pl-ev.code    { background: var(--code-bg); border-color: var(--code-bd); color: var(--code-tx); }
        .pl-ev.conduite{ background: var(--drv-bg);  border-color: var(--drv-bd);  color: var(--drv-tx); }
        .pl-ev .t  { font-weight: 700; display: flex; justify-content: space-between; gap: 6px; }
        .pl-ev .tm { font-variant-numeric: tabular-nums; opacity: .85; font-weight: 600; }
        .pl-ev .m  { opacity: .9; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .pl-ev .pc {
            display: inline-flex; align-items: center; gap: 4px; margin-top: 3px; padding: 1px 7px;
            background: rgba(255,255,255,.75); border-radius: 999px; font-weight: 700; font-size: 11px;
        }

        /* ---------- Liste ---------- */
        #viewList { display: none; }
        .pl-list-tools { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 14px; }
        .pl-list-tools .form-control { max-width: 260px; }
        .pl-badge { min-height: 24px; padding: 2px 10px; display: inline-flex; align-items: center; border-radius: 999px; font-size: 12px; font-weight: 600; }
        .pl-badge.code     { background: var(--code-bg); color: var(--code-tx); }
        .pl-badge.conduite { background: var(--drv-bg);  color: var(--drv-tx); }
        .pl-badge.p-present { background: #f0fdf4; color: var(--success); }
        .pl-badge.p-absent  { background: #fef2f2; color: var(--danger); }
        .pl-badge.p-attente { background: #fffbeb; color: var(--warning); }
        .pl-dash { color: var(--text-light); }
        .pl-count { display: inline-flex; align-items: center; gap: 6px; font-weight: 600; }
        .pl-empty-row td { text-align: center; color: var(--text-secondary); padding: 40px !important; }

        /* ---------- Tiroir (détails d'une séance) ---------- */
        .pl-overlay {
            position: fixed; inset: 0; z-index: 1100; background: rgba(15,23,42,.5); backdrop-filter: blur(2px);
            opacity: 0; visibility: hidden; transition: opacity var(--transition), visibility var(--transition);
        }
        .pl-overlay.open { opacity: 1; visibility: visible; }
        .pl-drawer {
            position: fixed; top: 0; right: 0; bottom: 0; z-index: 1110; width: 460px; max-width: 100%;
            display: flex; flex-direction: column; background: #fff; box-shadow: -10px 0 40px rgba(15,23,42,.18);
            transform: translateX(100%); transition: transform .28s cubic-bezier(.4,0,.2,1);
        }
        .pl-drawer.open { transform: translateX(0); }
        .pl-drawer-head { padding: 20px 22px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; gap: 12px; }
        .pl-drawer-head h2 { font-size: 18px; margin-top: 8px; }
        .pl-drawer-head p { font-size: 13px; color: var(--text-secondary); margin-top: 2px; }
        .pl-x { width: 36px; height: 36px; border: 0; border-radius: var(--radius-md); background: var(--body-bg); color: var(--text-secondary); font-size: 22px; line-height: 1; flex-shrink: 0; cursor: pointer; }
        .pl-x:hover { background: #fee2e2; color: var(--danger); }
        .pl-drawer-body { flex: 1; overflow-y: auto; padding: 20px 22px; }
        .pl-drawer-foot { padding: 14px 22px; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; gap: 10px; }

        .pl-info { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 22px; }
        .pl-info > div { padding: 12px 14px; background: var(--body-bg); border: 1px solid var(--border-color); border-radius: var(--radius-md); }
        .pl-info small { display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .4px; color: var(--text-light); }
        .pl-info span { font-size: 14px; font-weight: 600; }

        .pl-sec-title { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; font-size: 14px; font-weight: 700; }
        .pl-sec-title em { font-style: normal; font-size: 12px; font-weight: 600; color: var(--primary); background: var(--primary-light); padding: 2px 10px; border-radius: 999px; }

        .pl-cand { padding: 12px; margin-bottom: 10px; border: 1px solid var(--border-color); border-radius: var(--radius-md); background: #fafafa; }
        .pl-cand-top { display: flex; align-items: center; gap: 10px; }
        .pl-av {
            width: 36px; height: 36px; flex-shrink: 0; display: grid; place-items: center; border-radius: 50%;
            background: var(--primary-light); color: var(--primary); font-size: 12px; font-weight: 700;
        }
        .pl-cand-name { font-size: 14px; font-weight: 600; }
        .pl-cand-sub { font-size: 12px; color: var(--text-secondary); }
        .pl-cand-top .grow { flex: 1; min-width: 0; }
        .pl-cand-form { display: flex; gap: 6px; margin-top: 10px; }
        .pl-cand-form select { flex: 0 0 120px; }
        .pl-cand-form input { flex: 1; min-width: 0; }
        .pl-cand-form .form-control { min-height: 36px; font-size: 13px; padding: 4px 10px; }
        .pl-mini { min-height: 36px; width: 36px; padding: 0; flex-shrink: 0; }
        .pl-rm { border: 0; background: transparent; color: var(--text-light); width: 30px; height: 30px; border-radius: 8px; font-size: 18px; cursor: pointer; }
        .pl-rm:hover { background: #fee2e2; color: var(--danger); }
        .pl-no-cand { padding: 22px; text-align: center; color: var(--text-secondary); font-size: 13px; background: var(--body-bg); border: 1px dashed var(--border-color); border-radius: var(--radius-md); margin-bottom: 14px; }
        .pl-add-box { display: flex; gap: 8px; padding-top: 14px; border-top: 1px dashed var(--border-color); }
        .pl-add-box select { flex: 1; min-width: 0; }

        /* ---------- Modal "Programmer une séance" ---------- */
        .pl-modal-wrap { position: fixed; inset: 0; z-index: 1200; display: none; align-items: center; justify-content: center; padding: 16px; background: rgba(15,23,42,.5); backdrop-filter: blur(2px); }
        .pl-modal-wrap.open { display: flex; }
        .pl-modal { width: 100%; max-width: 520px; max-height: 92vh; display: flex; flex-direction: column; background: #fff; border-radius: var(--radius-lg); box-shadow: 0 24px 60px rgba(15,23,42,.3); overflow: hidden; }
        .pl-modal-head { padding: 18px 22px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; }
        .pl-modal-head h2 { font-size: 18px; }
        .pl-modal-body { padding: 20px 22px; overflow-y: auto; }
        .pl-modal-foot { padding: 14px 22px; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 10px; }
        .pl-row2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .pl-type { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .pl-type input { display: none; }
        .pl-type label { padding: 11px; text-align: center; border: 2px solid var(--border-color); border-radius: var(--radius-md); font-weight: 600; font-size: 14px; color: var(--text-secondary); cursor: pointer; transition: all var(--transition); }
        .pl-type input:checked + label.l-conduite { border-color: var(--drv-bd); background: var(--drv-bg); color: var(--drv-tx); }
        .pl-type input:checked + label.l-code     { border-color: var(--code-bd); background: var(--code-bg); color: var(--code-tx); }
        .pl-pick { max-height: 170px; overflow-y: auto; margin-top: 8px; border: 1px solid var(--border-color); border-radius: var(--radius-md); }
        .pl-pick label { display: flex; align-items: center; gap: 10px; padding: 8px 12px; font-size: 13.5px; cursor: pointer; border-bottom: 1px solid #f1f5f9; }
        .pl-pick label:last-child { border-bottom: 0; }
        .pl-pick label:hover { background: var(--body-bg); }
        .pl-pick small { margin-left: auto; color: var(--text-light); }
        .pl-error { display: none; margin-bottom: 12px; padding: 10px 12px; border-radius: var(--radius-md); background: #fef2f2; color: var(--danger); font-size: 13px; font-weight: 600; }
        .pl-help { font-size: 12px; color: var(--text-light); margin-top: 4px; }

        .pl-stat-gap { margin-bottom: 20px; }

        @media (max-width: 767px) {
            .pl-week-label { min-width: 0; flex: 1; }
            .pl-toolbar-left { width: 100%; }
            .pl-row2 { grid-template-columns: 1fr; }
            .pl-drawer { width: 100%; }
            .pl-list-tools .form-control { max-width: none; }
        }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

    <main class="page-content pl-scope">
        <?php require_once __DIR__ . '/../layouts/header.php'; ?>

        <!-- En-tête de page -->
        <div class="card-header">
            <div>
                <h1 style="font-size: 22px;">Gestion du Planning</h1>
                <p class="card-description">Programmation des séances de Code et de Conduite, et suivi des candidats.</p>
            </div>
            <button type="button" onclick="openCreate()" class="btn btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Ajouter une séance
            </button>
        </div>

        <!-- Statistiques de la semaine -->
        <div class="dashboard-grid pl-stat-gap">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <div class="dashboard-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                </div>
                <div class="dashboard-card-value"><?= count($weekSeances) ?></div>
                <div class="dashboard-card-label">Séances cette semaine</div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <div class="dashboard-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                    </div>
                </div>
                <div class="dashboard-card-value"><?= $stCode ?></div>
                <div class="dashboard-card-label">Séances de Code</div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <div class="dashboard-card-icon" style="background:#f0fdf4;color:var(--success);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/><line x1="12" y1="2" x2="12" y2="9"/><line x1="4.9" y1="16.5" x2="9.9" y2="13.5"/><line x1="19.1" y1="16.5" x2="14.1" y2="13.5"/></svg>
                    </div>
                </div>
                <div class="dashboard-card-value"><?= $stConduite ?></div>
                <div class="dashboard-card-label">Séances de Conduite</div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <div class="dashboard-card-icon" style="background:#fffbeb;color:var(--warning);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                </div>
                <div class="dashboard-card-value"><?= $stCandidats ?></div>
                <div class="dashboard-card-label">Candidats inscrits</div>
            </div>
        </div>

        <!-- Barre d'outils -->
        <div class="pl-toolbar">
            <div class="pl-toolbar-left" id="weekNav">
                <a class="btn btn-secondary pl-icon-btn" href="<?= BASE_URL ?>/planning?week=<?= $prevWeek ?>" aria-label="Semaine précédente">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                </a>
                <span class="pl-week-label"><?= $h($weekLabel) ?></span>
                <a class="btn btn-secondary pl-icon-btn" href="<?= BASE_URL ?>/planning?week=<?= $nextWeek ?>" aria-label="Semaine suivante">
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
                        <?php foreach ($days as $i => $d):
                            $cnt = count($eventsByDay[$d]); ?>
                            <div class="pl-dayhead <?= $d === $today ? 'today' : '' ?>">
                                <div class="dn"><?= $joursCourts[$i] ?></div>
                                <div class="dd"><?= date('j', strtotime($d)) ?></div>
                                <span class="cnt"><?= $cnt ? $cnt . ' séance' . ($cnt > 1 ? 's' : '') : '' ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="pl-cal-body" style="height: <?= $gridHeight ?>px;">
                        <div class="pl-hours">
                            <?php for ($m = $minMin; $m <= $maxMin; $m += 60): ?>
                                <?php if ($m > $minMin && $m < $maxMin): ?>
                                    <span class="pl-hour-label" style="top: <?= $m - $minMin ?>px;"><?= sprintf('%02d:00', $m / 60) ?></span>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>

                        <?php foreach ($days as $d):
                            $cls = ($d === $today ? 'today' : '') . ($d < $today ? ' past' : ''); ?>
                            <div class="pl-col <?= $cls ?>" data-date="<?= $d ?>">
                                <?php if ($d === $today):
                                    $nowMin = intval(date('G')) * 60 + intval(date('i'));
                                    if ($nowMin >= $minMin && $nowMin <= $maxMin): ?>
                                        <div class="pl-now" style="top: <?= $nowMin - $minMin ?>px;"></div>
                                <?php endif; endif; ?>

                                <?php foreach ($eventsByDay[$d] as $ev):
                                    $w = 100 / $ev['_lanes'];
                                    $nb = count($ev['participants'] ?? []);
                                    $isCode = $ev['type'] === 'Code'; ?>
                                    <div class="pl-ev <?= $isCode ? 'code' : 'conduite' ?>"
                                         data-id="<?= $h($ev['id_seance']) ?>"
                                         style="top: <?= $ev['_top'] ?>px; height: <?= $ev['_h'] - 2 ?>px; left: calc(<?= $ev['_lane'] * $w ?>% + 2px); width: calc(<?= $w ?>% - 4px);">
                                        <div class="t">
                                            <span><?= $h($ev['type']) ?></span>
                                            <span class="tm"><?= $h($hm($ev['heure_debut'])) ?>–<?= $h($hm($ev['heure_fin'])) ?></span>
                                        </div>
                                        <?php if (!empty($ev['moniteur_nom'])): ?>
                                            <div class="m"><?= $h($ev['moniteur_nom'] . ' ' . $ev['moniteur_prenom']) ?></div>
                                        <?php endif; ?>
                                        <?php if (!empty($ev['immatriculation'])): ?>
                                            <div class="m"><?= $h($ev['marque']) ?></div>
                                        <?php endif; ?>
                                        <span class="pc">👥 <?= $nb ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <p class="pl-help" style="margin-top:10px;">Astuce : cliquez sur un créneau vide pour programmer une séance, ou sur une séance pour gérer ses candidats.</p>
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
                            <th>Candidats</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($listSeances)): ?>
                            <?php foreach ($listSeances as $s): ?>
                                <tr data-id="<?= $h($s['id_seance']) ?>" data-type="<?= $h($s['type']) ?>" style="cursor: pointer;">
                                    <td>#<?= $h($s['id_seance']) ?></td>
                                    <td><span class="pl-badge <?= $s['type'] === 'Code' ? 'code' : 'conduite' ?>"><?= $h($s['type']) ?></span></td>
                                    <td><?= $h(date('d/m/Y', strtotime($s['date']))) ?></td>
                                    <td><?= $h($hm($s['heure_debut'])) ?> – <?= $h($hm($s['heure_fin'])) ?></td>
                                    <td><?= !empty($s['moniteur_nom']) ? $h($s['moniteur_nom'] . ' ' . $s['moniteur_prenom']) : '<span class="pl-dash">—</span>' ?></td>
                                    <td><?= !empty($s['immatriculation']) ? $h($s['marque'] . ' (' . $s['immatriculation'] . ')') : '<span class="pl-dash">—</span>' ?></td>
                                    <td><span class="pl-count">👥 <?= count($s['participants'] ?? []) ?></span></td>
                                    <td><button type="button" class="btn btn-secondary" style="min-height:32px;padding:0 12px;font-size:13px;">Détails</button></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr class="pl-empty-row"><td colspan="8">Aucune séance programmée pour le moment.</td></tr>
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
            <button type="button" class="pl-x" onclick="closeDrawer()" aria-label="Fermer">&times;</button>
        </div>
        <div class="pl-drawer-body" id="dBody"></div>
        <div class="pl-drawer-foot">
            <form id="dDeleteForm" action="<?= BASE_URL ?>/planning/delete" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette séance ?');">
                <input type="hidden" name="id_seance" id="dDeleteId">
                <button type="submit" class="btn btn-danger">Supprimer la séance</button>
            </form>
            <button type="button" class="btn btn-secondary" onclick="closeDrawer()">Fermer</button>
        </div>
    </aside>

    <!-- ================= MODAL : NOUVELLE SÉANCE ================= -->
    <div class="pl-modal-wrap" id="createModal">
        <div class="pl-modal" role="dialog" aria-modal="true">
            <div class="pl-modal-head">
                <h2>Programmer une séance</h2>
                <button type="button" class="pl-x" onclick="closeCreate()" aria-label="Fermer">&times;</button>
            </div>
            <form action="<?= BASE_URL ?>/planning/store" method="POST" id="createForm" style="display:flex;flex-direction:column;min-height:0;">
                <div class="pl-modal-body">
                    <div class="form-group">
                        <label class="form-label">Type de séance</label>
                        <div class="pl-type">
                            <input type="radio" name="type" id="ty-conduite" value="Conduite" checked>
                            <label for="ty-conduite" class="l-conduite">🚗 Conduite</label>
                            <input type="radio" name="type" id="ty-code" value="Code">
                            <label for="ty-code" class="l-code">📘 Code</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="fDate">Date</label>
                        <input type="date" name="date" id="fDate" class="form-control" required>
                    </div>

                    <div class="pl-row2 form-group">
                        <div>
                            <label class="form-label" for="fDebut">Heure début</label>
                            <input type="time" name="heure_debut" id="fDebut" class="form-control" required>
                        </div>
                        <div>
                            <label class="form-label" for="fFin">Heure fin</label>
                            <input type="time" name="heure_fin" id="fFin" class="form-control" required>
                        </div>
                    </div>

                    <div class="pl-row2 form-group">
                        <div>
                            <label class="form-label" for="fMon">Moniteur</label>
                            <select name="id_moniteur" id="fMon" class="form-control">
                                <option value="">-- Sélectionner --</option>
                                <?php foreach ($moniteurs as $m): ?>
                                    <option value="<?= $h($m['id_user']) ?>"><?= $h($m['nom'] . ' ' . $m['prenom']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="form-label" for="fVeh">Véhicule</label>
                            <select name="id_vehicule" id="fVeh" class="form-control">
                                <option value="">-- Sélectionner --</option>
                                <?php foreach ($vehicules as $v): ?>
                                    <option value="<?= $h($v['id_vehicule']) ?>"><?= $h($v['marque'] . ' (' . $v['immatriculation'] . ')') ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:6px;">
                        <label class="form-label">Candidats <span style="font-weight:400;color:var(--text-light);">(optionnel)</span></label>
                        <input type="text" id="pickSearch" class="form-control" placeholder="Rechercher un candidat…">
                        <div class="pl-pick" id="pickList">
                            <?php if (empty($candidats)): ?>
                                <div style="padding:14px;text-align:center;color:var(--text-light);font-size:13px;">Aucun candidat disponible.</div>
                            <?php endif; ?>
                            <?php foreach ($candidats as $c): ?>
                                <label data-search="<?= $h(mb_strtolower($c['nom'] . ' ' . $c['prenom'] . ' ' . ($c['num_enregistrement'] ?? ''))) ?>">
                                    <input type="checkbox" name="candidats[]" value="<?= $h($c['id_contrat']) ?>">
                                    <?= $h($c['nom'] . ' ' . $c['prenom']) ?>
                                    <small><?= $h($c['num_enregistrement'] ?? '') ?></small>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <div class="pl-help" id="pickCount">0 candidat sélectionné</div>
                    </div>

                    <div class="pl-error" id="createError"></div>
                </div>
                <div class="pl-modal-foot">
                    <button type="button" class="btn btn-secondary" onclick="closeCreate()">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const BASE = <?= json_encode(BASE_URL) ?>;
        const SEANCES = <?= json_encode($jsSeances, $jsonFlags) ?>;
        const CANDIDATS = <?= json_encode($jsCandidats, $jsonFlags) ?>;
        const GRID_START = <?= (int)$minMin ?>;
        const FLASH = <?= json_encode($flash, $jsonFlags) ?>;

        const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
        const initials = (n, p) => ((n || '?').charAt(0) + (p || '').charAt(0)).toUpperCase();
        const pad = n => String(n).padStart(2, '0');

        /* ---------- Toast ---------- */
        function showToast(type, msg) {
            type = (type === 'error') ? 'danger' : (type || 'info');
            const t = document.createElement('div');
            t.className = 'custom-toast toast-' + type;
            t.innerHTML = '<span class="toast-indicator"></span><span>' + esc(msg) + '</span>';
            document.body.appendChild(t);
            setTimeout(() => t.classList.add('toast-hide'), 3500);
            setTimeout(() => t.remove(), 4000);
        }
        if (FLASH && FLASH.message) showToast(FLASH.type, FLASH.message);

        /* ---------- Bascule Semaine / Liste ---------- */
        const viewWeek = document.getElementById('viewWeek');
        const viewList = document.getElementById('viewList');
        const weekNav  = document.getElementById('weekNav');
        function setView(v) {
            viewWeek.style.display = v === 'week' ? 'block' : 'none';
            viewList.style.display = v === 'list' ? 'block' : 'none';
            weekNav.style.visibility = v === 'week' ? 'visible' : 'hidden';
            document.querySelectorAll('#viewSwitch button').forEach(b => b.classList.toggle('active', b.dataset.view === v));
            try { localStorage.setItem('planningView', v); } catch (e) {}
        }
        document.querySelectorAll('#viewSwitch button').forEach(b => b.addEventListener('click', () => setView(b.dataset.view)));
        let savedView = 'week';
        try { savedView = localStorage.getItem('planningView') || 'week'; } catch (e) {}
        if (window.innerWidth < 768) savedView = 'list';
        setView(savedView);

        /* ---------- Clic : séance / créneau vide ---------- */
        document.querySelectorAll('.pl-ev').forEach(el => el.addEventListener('click', e => { e.stopPropagation(); openDrawer(el.dataset.id); }));
        document.querySelectorAll('#listTable tbody tr[data-id]').forEach(tr => tr.addEventListener('click', () => openDrawer(tr.dataset.id)));
        document.querySelectorAll('.pl-col').forEach(col => col.addEventListener('click', e => {
            if (e.target !== col) return;
            const mins = GRID_START + Math.floor(e.offsetY / 30) * 30;
            openCreate(col.dataset.date, mins);
        }));

        /* ---------- Filtres liste ---------- */
        function filterList() {
            const t = document.getElementById('fType').value;
            const q = document.getElementById('fSearch').value.trim().toLowerCase();
            document.querySelectorAll('#listTable tbody tr[data-id]').forEach(tr => {
                const ok = (!t || tr.dataset.type === t) && (!q || tr.textContent.toLowerCase().includes(q));
                tr.style.display = ok ? '' : 'none';
            });
        }
        document.getElementById('fType').addEventListener('change', filterList);
        document.getElementById('fSearch').addEventListener('input', filterList);

        /* ---------- Tiroir ---------- */
        const drawer = document.getElementById('drawer');
        const overlay = document.getElementById('drawerOverlay');

        function presenceClass(p) { return p === 'Présent' ? 'p-present' : (p === 'Absent' ? 'p-absent' : 'p-attente'); }

        function openDrawer(id) {
            const s = SEANCES[id];
            if (!s) return;
            const isCode = s.type === 'Code';
            document.getElementById('dBadge').innerHTML = '<span class="pl-badge ' + (isCode ? 'code' : 'conduite') + '">' + esc(s.type) + '</span>';
            document.getElementById('dTitle').textContent = 'Séance #' + s.id;
            document.getElementById('dSub').textContent = s.dateFr + ' · ' + s.debut + ' – ' + s.fin;
            document.getElementById('dDeleteId').value = s.id;

            const taken = new Set(s.participants.map(p => String(p.id_contrat)));
            const available = CANDIDATS.filter(c => !taken.has(String(c.id)));

            let html = '<div class="pl-info">'
                + '<div><small>Moniteur</small><span>' + (s.moniteur ? esc(s.moniteur) : '<span class="pl-dash">Non assigné</span>') + '</span></div>'
                + '<div><small>Véhicule</small><span>' + (s.vehicule ? esc(s.vehicule) : '<span class="pl-dash">—</span>') + '</span></div>'
                + '</div>';

            html += '<div class="pl-sec-title"><span>Candidats</span><em>' + s.participants.length + ' inscrit' + (s.participants.length > 1 ? 's' : '') + '</em></div>';

            if (!s.participants.length) {
                html += '<div class="pl-no-cand">Aucun candidat inscrit à cette séance.</div>';
            }
            s.participants.forEach(p => {
                html += '<div class="pl-cand">'
                    + '<div class="pl-cand-top">'
                    +   '<div class="pl-av">' + esc(initials(p.nom, p.prenom)) + '</div>'
                    +   '<div class="grow"><div class="pl-cand-name">' + esc(p.nom + ' ' + p.prenom) + '</div>'
                    +   '<div class="pl-cand-sub">' + esc(p.num) + (p.tel ? ' · ' + esc(p.tel) : '') + '</div></div>'
                    +   '<span class="pl-badge ' + presenceClass(p.presence) + '">' + esc(p.presence) + '</span>'
                    +   '<form action="' + BASE + '/planning/removeParticipant" method="POST" onsubmit="return confirm(\'Retirer ce candidat de la séance ?\');">'
                    +     '<input type="hidden" name="id_participation" value="' + esc(p.id_participation) + '">'
                    +     '<button type="submit" class="pl-rm" title="Retirer">&times;</button></form>'
                    + '</div>'
                    + '<form class="pl-cand-form" action="' + BASE + '/planning/updatePresence" method="POST">'
                    +   '<input type="hidden" name="id_participation" value="' + esc(p.id_participation) + '">'
                    +   '<select name="presence" class="form-control">'
                    +     ['En attente', 'Présent', 'Absent'].map(o => '<option' + (o === p.presence ? ' selected' : '') + '>' + o + '</option>').join('')
                    +   '</select>'
                    +   '<input type="text" name="remarque" class="form-control" placeholder="Remarque…" value="' + esc(p.remarque) + '">'
                    +   '<button type="submit" class="btn btn-primary pl-mini" title="Enregistrer">✓</button>'
                    + '</form>'
                    + '</div>';
            });

            if (available.length) {
                html += '<form class="pl-add-box" action="' + BASE + '/planning/addParticipant" method="POST">'
                    + '<input type="hidden" name="id_seance" value="' + esc(s.id) + '">'
                    + '<select name="id_contrat" class="form-control" required>'
                    +   '<option value="">+ Ajouter un candidat…</option>'
                    +   available.map(c => '<option value="' + esc(c.id) + '">' + esc(c.nom + ' ' + c.prenom + (c.num ? ' (' + c.num + ')' : '')) + '</option>').join('')
                    + '</select>'
                    + '<button type="submit" class="btn btn-primary">Ajouter</button>'
                    + '</form>';
            } else if (!CANDIDATS.length) {
                html += '<div class="pl-help">Aucun candidat (contrat) disponible à ajouter.</div>';
            }

            document.getElementById('dBody').innerHTML = html;
            drawer.classList.add('open');
            overlay.classList.add('open');
            drawer.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }
        function closeDrawer() {
            drawer.classList.remove('open');
            overlay.classList.remove('open');
            drawer.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }
        overlay.addEventListener('click', closeDrawer);

        /* ---------- Modal création ---------- */
        const createModal = document.getElementById('createModal');
        const createError = document.getElementById('createError');

        function openCreate(date, mins) {
            if (date) document.getElementById('fDate').value = date;
            if (typeof mins === 'number') {
                document.getElementById('fDebut').value = pad(Math.floor(mins / 60)) + ':' + pad(mins % 60);
                const end = mins + 60;
                document.getElementById('fFin').value = pad(Math.floor(end / 60) % 24) + ':' + pad(end % 60);
            }
            createError.style.display = 'none';
            createModal.classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeCreate() {
            createModal.classList.remove('open');
            document.body.style.overflow = '';
        }
        createModal.addEventListener('click', e => { if (e.target === createModal) closeCreate(); });
        document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeCreate(); closeDrawer(); } });

        document.getElementById('createForm').addEventListener('submit', e => {
            const d = document.getElementById('fDebut').value, f = document.getElementById('fFin').value;
            if (d && f && f <= d) {
                e.preventDefault();
                createError.textContent = "L'heure de fin doit être postérieure à l'heure de début.";
                createError.style.display = 'block';
            }
        });

        /* Sélection de candidats : recherche + compteur */
        const pickList = document.getElementById('pickList');
        document.getElementById('pickSearch').addEventListener('input', e => {
            const q = e.target.value.trim().toLowerCase();
            pickList.querySelectorAll('label').forEach(l => { l.style.display = (!q || l.dataset.search.includes(q)) ? '' : 'none'; });
        });
        pickList.addEventListener('change', () => {
            const n = pickList.querySelectorAll('input:checked').length;
            document.getElementById('pickCount').textContent = n + ' candidat' + (n > 1 ? 's' : '') + ' sélectionné' + (n > 1 ? 's' : '');
        });
    </script>
</body>
</html>