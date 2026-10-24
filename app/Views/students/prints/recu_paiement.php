<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de Paiement N° <?= htmlspecialchars($paiement['id_paiement']) ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f8fafc;
            color: #1e293b;
            padding: 30px 15px;
            display: flex;
            justify-content: center;
        }

        .receipt {
            background: #ffffff;
            width: 100%;
            max-width: 680px;
            padding: 30px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
        }

        /* En-tête */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand img {
            height: 55px;
            width: auto;
            object-fit: contain;
        }

        .brand-info h2 { font-size: 18px; color: #0f172a; }
        .brand-info p { font-size: 12px; color: #64748b; }

        .title-box { text-align: right; }
        .title-box h1 { font-size: 18px; color: #2563eb; text-transform: uppercase; }
        .title-box p { font-size: 12px; color: #64748b; margin-top: 2px; }

        /* Grille d'information */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 12px 15px;
            border-radius: 6px;
            font-size: 13px;
        }

        .box h3 {
            font-size: 11px;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 8px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
        }

        .row { display: flex; justify-content: space-between; margin-bottom: 4px; }
        .row:last-child { margin-bottom: 0; }
        .label { color: #64748b; }
        .val { font-weight: 600; color: #0f172a; }

        /* Tableau */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 13px;
        }

        th {
            background: #f1f5f9;
            color: #475569;
            padding: 10px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            border-bottom: 2px solid #cbd5e1;
        }

        td {
            padding: 12px 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        /* Montant Highlight */
        .total-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            padding: 12px 15px;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .total-box span { font-weight: 600; color: #1e40af; font-size: 13px; }
        .total-box strong { font-size: 20px; color: #1d4ed8; }

        /* Signatures */
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            font-size: 12px;
            color: #64748b;
        }

        .sig-box { width: 45%; text-align: center; }
        .sig-line { border-top: 1px dashed #cbd5e1; margin-top: 45px; }

        /* Boutons d'impression */
        .actions {
            position: fixed;
            top: 15px;
            right: 15px;
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 8px 14px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            border: none;
            text-decoration: none;
        }

        .btn-print { background: #2563eb; color: #fff; }
        .btn-back { background: #e2e8f0; color: #334155; }

        @media print {
            body { background: #fff; padding: 0; }
            .receipt { border: none; padding: 0; width: 100%; }
            .actions { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="actions">
        <button onclick="window.print()" class="btn btn-print">Imprimer</button>
    </div>

    <div class="receipt">
        <!-- En-tête avec Logo -->
        <div class="header">
            <div class="brand">
                <img src="<?= BASE_URL ?>/uploads/logo.png" alt="Logo Auto-École" onerror="this.style.display='none'">
                <div class="brand-info">
                    <h2><?= htmlspecialchars($schoolInfo['nom_auto_ecole'] ?? 'Smart Auto-École') ?></h2>
                    <p><?= htmlspecialchars($schoolInfo['telephone'] ?? '06 66 67 77 77') ?></p>
                    <p><?= htmlspecialchars($schoolInfo['adresse'] ?? '06 66 67 77 77') ?></p>

                </div>
            </div>
            <div class="title-box">
                <h1>Reçu de Paiement</h1>
                <p><strong>N° :</strong> <?= htmlspecialchars($paiement['reference'] ?? 'REC-' . str_pad($paiement['id_paiement'], 4, '0', STR_PAD_LEFT)) ?></p>
                <p><strong>Date :</strong> <?= date('d/m/Y', strtotime($paiement['date_paiement'])) ?></p>
            </div>
        </div>

        <!-- Informations Candidat & Contrat -->
        <div class="info-grid">
            <div class="box">
                <h3>Candidat</h3>
                <div class="row"><span class="label">Nom & Prénom:</span> <span class="val"><?= htmlspecialchars($paiement['nom'] . ' ' . $paiement['prenom']) ?></span></div>
                <div class="row"><span class="label">CIN:</span> <span class="val"><?= htmlspecialchars($paiement['cin'] ?? '-') ?></span></div>
            </div>
            <div class="box">
                <h3>Contrat</h3>
                <div class="row"><span class="label">N° Contrat:</span> <span class="val"><?= htmlspecialchars($paiement['num_enregistrement'] ?? '#' . $paiement['id_contrat']) ?></span></div>
                <div class="row"><span class="label">Catégorie:</span> <span class="val">Permis <?= htmlspecialchars($paiement['categorie_code'] ?? 'B') ?></span></div>
            </div>
        </div>

        <!-- Tableau des détails -->
        <table>
            <thead>
                <tr>
                    <th>Désignation</th>
                    <th>Mode de Paiement</th>
                    <th>Référence</th>
                    <th style="text-align: right;">Montant</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Versement sur formation de conduite</td>
                    <td><?= htmlspecialchars($paiement['mode_paiement']) ?></td>
                    <td><?= htmlspecialchars($paiement['reference'] ?? '-') ?></td>
                    <td style="text-align: right;"><strong><?= number_format($paiement['montant'], 2) ?> DH</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Total -->
        <div class="total-box">
            <span>MONTANT REÇU</span>
            <strong><?= number_format($paiement['montant'], 2) ?> DH</strong>
        </div>

        <!-- Signatures -->
        <div class="signatures">
            <div class="sig-box">
                <span>Signature du Candidat</span>
                <div class="sig-line"></div>
            </div>
            <div class="sig-box">
                <span>Cachet & Signature Établissement</span>
                <div class="sig-line"></div>
            </div>
        </div>
    </div>

</body>
</html>