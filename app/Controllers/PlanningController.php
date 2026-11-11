<?php
require_once __DIR__ . '/../Models/seance.php';
require_once __DIR__ . '/../Models/participation.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Vehicule.php';
require_once __DIR__ . '/../Models/contrat.php';
require_once __DIR__ . '/../Models/categories.php';

/**
 * UC08 - Planifier une séance      (Directeur, Secrétaire)
 * UC09 - Consulter le planning     (Directeur, Secrétaire, Moniteur, Candidat)
 * UC10 - Valider une séance        (Moniteur)
 */
class PlanningController {

    // Adapte ces valeurs à la table des rôles si besoin
    const ROLE_DIRECTEUR  = 1;
    const ROLE_SECRETAIRE = 2;
    const ROLE_MONITEUR   = 3;
    const ROLE_CANDIDAT   = 4;

    const GESTION  = [1, 2];
    const TOUS     = [1, 2, 3, 4];
    const MONITEUR = [3];

    const PRESENCES = ['En attente', 'Présent', 'Absent'];

    /* =====================================================
       UC09 - Consulter le planning (selon le rôle)
       ===================================================== */
    public function index() {
        authorize(self::TOUS);

        $user = $this->currentUser();
        $role = $user['role'];
        $canManage   = in_array($role, self::GESTION, true);
        $canValidate = ($role === self::ROLE_MONITEUR);
        $isCandidat  = ($role === self::ROLE_CANDIDAT);

        $db = (new Database())->getConnection();
        $seanceModel        = new Seance($db);
        $participationModel = new Participation($db);

        // Contrats du candidat connecté (pour filtrer son planning)
        $mesContrats = [];
        if ($isCandidat) {
            $contratModel = new Contrat($db);
            $mesContrats  = array_map('intval', array_column($contratModel->getContratsByStudent($user['id']) ?: [], 'id_contrat'));
        }

        // Filtrage selon le rôle
        $seances = [];
        foreach ($seanceModel->getAllSeances() as $s) {
            if ($role === self::ROLE_MONITEUR && (int)($s['id_moniteur'] ?? 0) !== $user['id']) {
                continue;
            }

            $s['participants'] = $participationModel->getParticipantsBySeance($s['id_seance']) ?: [];

            if ($isCandidat) {
                $mine = null;
                foreach ($s['participants'] as $p) {
                    if (in_array((int)$p['id_contrat'], $mesContrats, true)) { $mine = $p; break; }
                }
                if (!$mine) continue;
                $s['_ma_presence'] = $mine['presence'] ?? 'En attente';
                $s['_ma_remarque'] = $mine['remarque'] ?? '';
                $s['participants'] = []; // un candidat ne voit pas les autres candidats
            }

            $seances[] = $this->normalizeSeance($s, $user['id'], $role);
        }

        // Semaine affichée + statistiques
        $week = $this->buildWeek($seances, $_GET['week'] ?? '');

        $weekSeances = array_filter($seances, fn($s) => in_array($s['date'], $week['days'], true));
        $stats = [
            'total'    => count($weekSeances),
            'code'     => count(array_filter($weekSeances, fn($s) => $s['type'] === 'Code')),
            'conduite' => count(array_filter($weekSeances, fn($s) => $s['type'] !== 'Code')),
        ];
        if ($isCandidat) {
            $stats['fourth'] = ['label' => 'Séances réalisées', 'value' => count(array_filter($weekSeances, fn($s) => $s['statut'] === 'Réalisée'))];
        } else {
            $stats['fourth'] = ['label' => 'Candidats inscrits', 'value' => array_sum(array_column($weekSeances, 'nb'))];
        }

        // Liste (tri décroissant) + données JSON pour le tiroir
        $seancesList = $seances;
        usort($seancesList, fn($a, $b) => strcmp($b['date'] . $b['debut'], $a['date'] . $a['debut']));
        $seancesJs = [];
        foreach ($seances as $s) { $seancesJs[$s['id']] = $s; }

        // Données utiles seulement pour la gestion (UC08)
        $candidats = $candidatsJs = [];
        if ($canManage) {
            $candidats = $this->getCandidats($db);
            $candidatsJs = array_map(fn($c) => [
                'id' => $c['id_contrat'], 'num' => $c['num_enregistrement'],
                'nom' => $c['nom'], 'prenom' => $c['prenom'], 'cat' => $c['categorie'],
            ], $candidats);
        }

        $pageTitle = "Gestion du Planning";
        require_once __DIR__ . '/../Views/planning/index.php';
    }

    /* =====================================================
       UC08 - Formulaire "Programmer une séance"
       ===================================================== */
    public function create() {
        authorize(self::GESTION);

        $db = (new Database())->getConnection();
        [$moniteurs, $vehicules] = $this->formLists($db);
        $candidats  = $this->getCandidats($db);
        $categories = $this->getCategories($db);
        $isEdit = false;

        // Valeurs ressaisies après une erreur, ou pré-remplies depuis un créneau du calendrier
        $old = $_SESSION['old'] ?? [];
        unset($_SESSION['old']);
        $old = [
            'type'        => $old['type'] ?? 'Conduite',
            'date'        => $old['date'] ?? ($_GET['date'] ?? date('Y-m-d')),
            'heure_debut' => $old['heure_debut'] ?? ($_GET['debut'] ?? ''),
            'heure_fin'   => $old['heure_fin'] ?? ($_GET['fin'] ?? ''),
            'id_moniteur' => $old['id_moniteur'] ?? '',
            'id_vehicule' => $old['id_vehicule'] ?? '',
            'candidats'   => array_map('intval', (array)($old['candidats'] ?? [])),
        ];

        $pageTitle = "Programmer une séance";
        require_once __DIR__ . '/../Views/planning/create.php';
    }

    /* =====================================================
       UC08 - Modifier une séance (tant qu'elle n'est pas réalisée)
       ===================================================== */
    public function edit() {
        authorize(self::GESTION);

        $db = (new Database())->getConnection();
        $seance = $this->findSeance(new Seance($db), (int)($_GET['id'] ?? 0));
        if (!$seance) return $this->fail('Séance introuvable.');
        if ($this->estRealisee($seance)) {
            $this->flash('warning', 'Une séance réalisée ne peut plus être modifiée.');
            return $this->backToSeance($seance);
        }

        [$moniteurs, $vehicules] = $this->formLists($db, (int)($seance['id_vehicule'] ?? 0));
        $candidats = $categories = [];
        $isEdit = true;

        $old = $_SESSION['old'] ?? [];
        unset($_SESSION['old']);
        $old = [
            'type'        => $old['type'] ?? $seance['type'],
            'date'        => $old['date'] ?? $seance['date'],
            'heure_debut' => $old['heure_debut'] ?? substr((string)$seance['heure_debut'], 0, 5),
            'heure_fin'   => $old['heure_fin'] ?? substr((string)$seance['heure_fin'], 0, 5),
            'id_moniteur' => $old['id_moniteur'] ?? $seance['id_moniteur'],
            'id_vehicule' => $old['id_vehicule'] ?? $seance['id_vehicule'],
            'candidats'   => [],
        ];
        $nbCandidats = count((new Participation($db))->getParticipantsBySeance($seance['id_seance']) ?: []);

        $pageTitle = "Modifier la séance #" . (int)$seance['id_seance'];
        require_once __DIR__ . '/../Views/planning/create.php';
    }

    public function update() {
        authorize(self::GESTION);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('/planning'); return; }

        $id = (int)($_POST['id_seance'] ?? 0);
        $db = (new Database())->getConnection();
        $seanceModel = new Seance($db);

        $seance = $this->findSeance($seanceModel, $id);
        if (!$seance) return $this->fail('Séance introuvable.');
        if ($this->estRealisee($seance)) {
            $this->flash('warning', 'Une séance réalisée ne peut plus être modifiée.');
            return $this->backToSeance($seance);
        }

        [$in, $err] = $this->readSeanceInput();
        if ($err) return $this->failEdit($err, $id);

        $conflit = $this->findConflict($seanceModel->getAllSeances(), $in['date'], $in['heure_debut'], $in['heure_fin'],
                                       $in['id_moniteur'], $in['id_vehicule'], $id);
        if ($conflit) return $this->failEdit($conflit, $id);

        try {
            $ok = $seanceModel->updateSeance($id, $in);
        } catch (Throwable $e) {
            error_log('Planning update: ' . $e->getMessage());
            return $this->failEdit('Erreur lors de la modification : ' . $e->getMessage(), $id);
        }
        if (!$ok) return $this->failEdit('La séance n\'a pas pu être modifiée.', $id);

        $this->flash('info', 'Séance modifiée avec succès.');
        redirect('/planning?week=' . $in['date'] . '&open=' . $id);
    }

    /* =====================================================
       UC08 - Enregistrer la séance
       ===================================================== */
    public function store() {
        authorize(self::GESTION);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('/planning/create'); return; }

        [$in, $err] = $this->readSeanceInput();
        if ($err) return $this->failCreate($err);
        $type = $in['type']; $date = $in['date']; $debut = $in['heure_debut']; $fin = $in['heure_fin'];
        $id_moniteur = $in['id_moniteur']; $id_vehicule = $in['id_vehicule'];
        $ids = array_values(array_unique(array_map('intval', (array)($_POST['candidats'] ?? []))));

        $db = (new Database())->getConnection();
        $seanceModel        = new Seance($db);
        $participationModel = new Participation($db);

        // Conflits moniteur / véhicule
        $conflit = $this->findConflict($seanceModel->getAllSeances(), $date, $debut, $fin, $id_moniteur, $id_vehicule);
        if ($conflit) return $this->failCreate($conflit);

        // Candidats autorisés uniquement
        $valides = array_map(fn($c) => (int)$c['id_contrat'], $this->getCandidats($db));
        $ids = array_values(array_intersect($ids, $valides));

        try {
            $db->beginTransaction();
            $id_seance = $seanceModel->createSeance([
                'type' => $type, 'date' => $date, 'heure_debut' => $debut, 'heure_fin' => $fin,
                'id_moniteur' => $id_moniteur, 'id_vehicule' => $id_vehicule,
            ]);
            if (!$id_seance) throw new Exception("La séance n'a pas pu être créée.");

            foreach ($ids as $id_contrat) {
                if (!$participationModel->addParticipation($id_seance, $id_contrat)) {
                    throw new Exception("Impossible d'ajouter le candidat (contrat #$id_contrat).");
                }
            }
            $db->commit();
        } catch (Throwable $e) {
            if ($db->inTransaction()) $db->rollBack();
            error_log('Planning store: ' . $e->getMessage());
            // Détail technique affiché pendant le développement : à retirer en production
            return $this->failCreate('Erreur lors de la planification : ' . $e->getMessage());
        }

        $this->flash('success', 'Séance planifiée avec succès.');
        redirect('/planning?week=' . $date . '&open=' . $id_seance);
    }

    public function delete() {
        authorize(self::GESTION);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('/planning'); return; }

        $id = (int)($_POST['id_seance'] ?? 0);
        if ($id) {
            $db = (new Database())->getConnection();
            $seanceModel = new Seance($db);
            $ok = $seanceModel->deleteSeance($id);
            $this->flash('danger', $ok ? 'Séance supprimée avec succès.' : 'Erreur lors de la suppression.');
        }
        redirect('/planning');
    }

    /* ---------- Candidats d'une séance (UC08) ---------- */
    public function addParticipant() {
        authorize(self::GESTION);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('/planning'); return; }

        $id_seance  = (int)($_POST['id_seance'] ?? 0);
        $id_contrat = (int)($_POST['id_contrat'] ?? 0);

        $db = (new Database())->getConnection();
        $seanceModel        = new Seance($db);
        $participationModel = new Participation($db);

        $seance = $this->findSeance($seanceModel, $id_seance);
        if (!$seance) return $this->fail('Séance introuvable.');
        if ($this->estRealisee($seance)) {
            $this->flash('warning', "Séance réalisée : l'ajout de candidats n'est plus possible.");
            return $this->backToSeance($seance);
        }

        $valides = array_map(fn($c) => (int)$c['id_contrat'], $this->getCandidats($db));
        if (!in_array($id_contrat, $valides, true)) {
            $this->flash('danger', 'Candidat invalide.');
        } elseif ($participationModel->exists($id_seance, $id_contrat)) {
            $this->flash('warning', 'Ce candidat est déjà inscrit à la séance.');
        } elseif ($participationModel->addParticipation($id_seance, $id_contrat)) {
            $this->flash('success', 'Candidat ajouté à la séance.');
        } else {
            $this->flash('danger', "Impossible d'ajouter le candidat.");
        }
        $this->backToSeance($seance);
    }

    public function removeParticipant() {
        authorize(self::GESTION);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('/planning'); return; }

        $id_participation = (int)($_POST['id_participation'] ?? 0);
        $db = (new Database())->getConnection();
        $seanceModel        = new Seance($db);
        $participationModel = new Participation($db);

        $id_seance = (int)$participationModel->getSeanceId($id_participation);
        $seance    = $this->findSeance($seanceModel, $id_seance);
        if (!$seance) return $this->fail('Participation introuvable.');

        $ok = $participationModel->deleteParticipation($id_participation);
        $this->flash($ok ? 'warning' : 'danger', $ok ? 'Candidat retiré de la séance.' : 'Erreur lors du retrait.');
        $this->backToSeance($seance);
    }

    /* =====================================================
       UC10 - Valider une séance (Moniteur)
       ===================================================== */
    public function updatePresence() {
        authorize(self::MONITEUR);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('/planning'); return; }

        $id_participation = (int)($_POST['id_participation'] ?? 0);
        $presence = $_POST['presence'] ?? '';
        $remarque = mb_substr(trim($_POST['remarque'] ?? ''), 0, 255);
        if (!in_array($presence, self::PRESENCES, true)) return $this->fail('Présence invalide.');

        $db = (new Database())->getConnection();
        $seanceModel        = new Seance($db);
        $participationModel = new Participation($db);

        $seance = $this->findSeance($seanceModel, (int)$participationModel->getSeanceId($id_participation));
        if (!$this->moniteurPeutValider($seance)) return;

        $ok = $participationModel->updatePresence($id_participation, $presence, $remarque);
        $this->flash($ok ? 'info' : 'danger', $ok ? 'Présence enregistrée.' : "Erreur lors de l'enregistrement.");
        $this->backToSeance($seance);
    }

    public function validate() {
        authorize(self::MONITEUR);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('/planning'); return; }

        $id_seance = (int)($_POST['id_seance'] ?? 0);
        $remarque  = mb_substr(trim($_POST['remarque'] ?? ''), 0, 500);

        $db = (new Database())->getConnection();
        $seanceModel = new Seance($db);
        $seance = $this->findSeance($seanceModel, $id_seance);
        if (!$this->moniteurPeutValider($seance)) return;

        $ok = $seanceModel->validerSeance($id_seance, $remarque);
        $this->flash($ok ? 'success' : 'danger', $ok ? 'Séance validée.' : 'Erreur lors de la validation.');
        $this->backToSeance($seance);
    }

    /* =====================================================
       Méthodes privées
       ===================================================== */

    private function currentUser(): array {
        return [
            'id'   => (int)($_SESSION['user_id'] ?? 0),
            'role' => (int)($_SESSION['user_role'] ?? 0),
        ];
    }

    private function flash(string $type, string $message): void {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    private function fail(string $message) {
        $this->flash('danger', $message);
        redirect('/planning');
        return;
    }

    private function estRealisee(array $seance): bool {
        return ($seance['statut'] ?? 'Planifiée') === 'Réalisée';
    }

    /** Erreur de saisie à la modification : retour au formulaire d'édition */
    private function failEdit(string $message, int $id) {
        $_SESSION['old'] = $_POST;
        $this->flash('danger', $message);
        redirect('/planning/edit?id=' . $id);
        return;
    }

    /** Lit et valide le formulaire de séance (création et modification) : [données, erreur] */
    private function readSeanceInput(): array {
        $type  = $_POST['type'] ?? 'Conduite';
        $date  = $_POST['date'] ?? '';
        $debut = $_POST['heure_debut'] ?? '';
        $fin   = $_POST['heure_fin'] ?? '';
        $mon   = !empty($_POST['id_moniteur']) ? (int)$_POST['id_moniteur'] : null;
        $veh   = !empty($_POST['id_vehicule']) ? (int)$_POST['id_vehicule'] : null;
        if ($type === 'Code') $veh = null; // le véhicule ne concerne que la conduite

        $data = ['type' => $type, 'date' => $date, 'heure_debut' => $debut, 'heure_fin' => $fin,
                 'id_moniteur' => $mon, 'id_vehicule' => $veh];

        $d = DateTime::createFromFormat('Y-m-d', $date);
        $err = null;
        if (!in_array($type, ['Code', 'Conduite'], true))                                   $err = 'Type de séance invalide.';
        elseif (!$d || $d->format('Y-m-d') !== $date)                                       $err = 'Date invalide.';
        elseif (!preg_match('/^\d{2}:\d{2}$/', $debut) || !preg_match('/^\d{2}:\d{2}$/', $fin)) $err = 'Horaires invalides.';
        elseif ($fin <= $debut)                                                             $err = "L'heure de fin doit être postérieure à l'heure de début.";
        elseif (!$mon)                                                                      $err = 'Le moniteur est obligatoire.';
        elseif ($type === 'Conduite' && !$veh)                                              $err = 'Une séance de conduite nécessite un véhicule.';
        return [$data, $err];
    }

    /** Moniteurs + véhicules disponibles (+ le véhicule déjà affecté, même s'il est en panne) */
    private function formLists($db, int $vehiculeActuel = 0): array {
        $moniteurs = (new User($db))->getUsersByRole(self::ROLE_MONITEUR) ?: [];
        $vehicules = array_values(array_filter(
            (new Vehicule($db))->getAll() ?: [],
            fn($v) => ($v['etat'] ?? 'Disponible') === 'Disponible' || (int)$v['id_vehicule'] === $vehiculeActuel
        ));
        return [$moniteurs, $vehicules];
    }

    /** Erreur de saisie : retour au formulaire en gardant ce que l'utilisateur a saisi */
    private function failCreate(string $message) {
        $_SESSION['old'] = $_POST;
        $this->flash('danger', $message);
        redirect('/planning/create');
        return;
    }

    private function backToSeance(array $seance): void {
        redirect('/planning?week=' . $seance['date'] . '&open=' . $seance['id_seance']);
    }

    private function findSeance(Seance $model, int $id): ?array {
        foreach ($model->getAllSeances() as $s) {
            if ((int)$s['id_seance'] === $id) return $s;
        }
        return null;
    }

    /** Le moniteur ne valide que ses séances, à partir du jour J */
    private function moniteurPeutValider(?array $seance): bool {
        $user = $this->currentUser();
        if (!$seance) {
            $this->fail("Séance introuvable (participation inexistante).");
            return false;
        }
        if ((int)($seance['id_moniteur'] ?? 0) !== $user['id']) {
            // Détail technique pour le développement : à simplifier en production
            $this->fail("Cette séance est affectée à un autre moniteur (séance #{$seance['id_seance']} : moniteur n°"
                . (int)$seance['id_moniteur'] . ", vous : n°{$user['id']}).");
            return false;
        }
        if ($seance['date'] > date('Y-m-d')) {
            $this->fail("Cette séance n'a pas encore eu lieu.");
            return false;
        }
        return true;
    }

    /** Catégories de permis : [id => libellé] */
    private function getCategories($db): array {
        $categorieModel = new Categorie($db);
        $out = [];
        foreach (($categorieModel->getAllCategories() ?: []) as $c) {
            $id = $c['id_categorie'] ?? $c['id'] ?? null;
            if ($id === null) continue;
            $out[$id] = $this->categorieLabel($c, $id);
        }
        return $out;
    }

    private function categorieLabel(array $c, $id): string {
        foreach (['libelle', 'nom_categorie', 'nom', 'type', 'code', 'categorie'] as $k) {
            if (!empty($c[$k])) return (string)$c[$k];
        }
        return 'Cat. ' . $id;
    }

    /** Contrats en cours + catégorie de permis du contrat */
    private function getCandidats($db): array {
        $contratModel = new Contrat($db);
        $categories   = $this->getCategories($db);
        $out = [];
        foreach (($contratModel->getAllWithCandidat() ?: []) as $r) {
            if (isset($r['statut']) && $r['statut'] !== 'En cours') continue;
            $cat = $r['id_categorie'] ?? null;
            $out[] = [
                'id_contrat'         => $r['id_contrat'],
                'num_enregistrement' => $r['num_enregistrement'] ?? '',
                'nom'                => $r['nom'] ?? '',
                'prenom'             => $r['prenom'] ?? '',
                'id_categorie'       => $cat,
                'categorie'          => $r['categorie_code'] ?? ($categories[$cat] ?? '—'),
            ];
        }
        return $out;
    }

    private function findConflict(array $seances, string $date, string $debut, string $fin, ?int $mon, ?int $veh, ?int $excludeId = null): ?string {
        foreach ($seances as $s) {
            if ($excludeId && (int)$s['id_seance'] === $excludeId) continue;
            if ($s['date'] !== $date) continue;
            $sd = substr($s['heure_debut'], 0, 5);
            $sf = substr($s['heure_fin'], 0, 5);
            if ($debut >= $sf || $fin <= $sd) continue; // pas de chevauchement
            if ($mon && (int)($s['id_moniteur'] ?? 0) === $mon) return "Ce moniteur a déjà une séance de $sd à $sf.";
            if ($veh && (int)($s['id_vehicule'] ?? 0) === $veh) return "Ce véhicule est déjà utilisé de $sd à $sf.";
        }
        return null;
    }

    private function normalizeSeance(array $s, int $userId, int $role): array {
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
        return [
            'id'          => (int)$s['id_seance'],
            'type'        => $s['type'],
            'date'        => $s['date'],
            'dateFr'      => date('d/m/Y', strtotime($s['date'])),
            'debut'       => substr((string)$s['heure_debut'], 0, 5),
            'fin'         => substr((string)$s['heure_fin'], 0, 5),
            'moniteur'    => trim(($s['moniteur_nom'] ?? '') . ' ' . ($s['moniteur_prenom'] ?? '')),
            'marque'      => $s['marque'] ?? '',
            'vehicule'    => !empty($s['immatriculation']) ? ($s['marque'] ?? '') . ' (' . $s['immatriculation'] . ')' : '',
            'statut'      => $s['statut'] ?? 'Planifiée',
            'remarque'    => $s['remarque_moniteur'] ?? '',
            'mine'        => ($role === self::ROLE_MONITEUR && (int)($s['id_moniteur'] ?? 0) === $userId),
            'maPresence'  => $s['_ma_presence'] ?? '',
            'maRemarque'  => $s['_ma_remarque'] ?? '',
            'participants'=> $parts,
            'nb'          => count($parts),
        ];
    }

    /** Calcule la semaine affichée et le placement des blocs (chevauchements) */
    private function buildWeek(array $seances, string $weekParam): array {
        $moisCourts = ['janv.', 'févr.', 'mars', 'avr.', 'mai', 'juin', 'juil.', 'août', 'sept.', 'oct.', 'nov.', 'déc.'];
        $toMin = fn($t) => intval(substr($t, 0, 2)) * 60 + intval(substr($t, 3, 2));

        $base   = preg_match('/^\d{4}-\d{2}-\d{2}$/', $weekParam) ? strtotime($weekParam) : time();
        $monday = strtotime('monday this week', $base);
        $sunday = strtotime('+6 day', $monday);
        $today  = date('Y-m-d');

        $days = [];
        for ($i = 0; $i < 7; $i++) $days[] = date('Y-m-d', strtotime("+$i day", $monday));

        $weekSeances = array_values(array_filter($seances, fn($s) => in_array($s['date'], $days, true)));

        $minMin = 7 * 60;
        $maxMin = 20 * 60;
        foreach ($weekSeances as $s) {
            $minMin = min($minMin, intdiv($toMin($s['debut']), 60) * 60);
            $maxMin = max($maxMin, (int)ceil($toMin($s['fin']) / 60) * 60);
        }

        $events = [];
        foreach ($days as $d) {
            $evs = array_values(array_filter($weekSeances, fn($s) => $s['date'] === $d));
            usort($evs, fn($a, $b) => $toMin($a['debut']) <=> $toMin($b['debut']));
            $laneEnds = [];
            foreach ($evs as &$ev) {
                $st = $toMin($ev['debut']);
                $en = max($toMin($ev['fin']), $st + 30);
                $lane = null;
                foreach ($laneEnds as $i => $end) { if ($end <= $st) { $lane = $i; break; } }
                if ($lane === null) $lane = count($laneEnds);
                $laneEnds[$lane] = $en;
                $ev['_lane'] = $lane;
                $ev['_top']  = $st - $minMin;
                $ev['_h']    = $en - $st;
            }
            unset($ev);
            foreach ($evs as &$ev) { $ev['_lanes'] = max(count($laneEnds), 1); }
            unset($ev);
            $events[$d] = $evs;
        }

        $nowMin = intval(date('G')) * 60 + intval(date('i'));

        return [
            'days'       => $days,
            'today'      => $today,
            'prev'       => date('Y-m-d', strtotime('-7 day', $monday)),
            'next'       => date('Y-m-d', strtotime('+7 day', $monday)),
            'label'      => date('j', $monday) . ' ' . $moisCourts[date('n', $monday) - 1]
                          . ' – ' . date('j', $sunday) . ' ' . $moisCourts[date('n', $sunday) - 1] . ' ' . date('Y', $sunday),
            'minMin'     => $minMin,
            'maxMin'     => $maxMin,
            'gridHeight' => $maxMin - $minMin,
            'events'     => $events,
            'nowTop'     => ($nowMin >= $minMin && $nowMin <= $maxMin) ? $nowMin - $minMin : null,
        ];
    }
}