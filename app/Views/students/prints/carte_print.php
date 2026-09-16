<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>بطاقة المرشح(ة) - <?= htmlspecialchars(($candidat['nom'] ?? '') . ' ' . ($candidat['prenom'] ?? '')) ?></title>
    <style>
        @page {
            size: A4 portrait;
            margin: 6mm 10mm;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
            line-height: 1.3;
            margin: 0;
            padding: 0;
            font-size: 11px;
        }
        .no-print-bar {
            background: #2563eb;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .btn-print {
            background: #fff;
            color: #2563eb;
            border: none;
            padding: 6px 14px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
        }
        @media print {
            .no-print-bar { display: none !important; }
        }

        /* العنوان العلوي */
        .header-title {
            text-align: center;
            margin-bottom: 12px;
        }
        .header-title h3 {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
        }
        .header-title p {
            margin: 2px 0 0 0;
            font-size: 12px;
        }

        /* الجزء العلوي: تقسيم العمودين */
        .top-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        /* العمود الأيسر (الفرنسية LTR) */
        .col-left {
            width: 48%;
            direction: ltr;
            text-align: left;
        }
        .photo-box {
            width: 75px;
            height: 90px;
            border: 1px solid #777;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fdfdfd;
        }
        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* العمود الأيمن (العربية RTL) */
        .col-right {
            width: 48%;
            direction: rtl;
            text-align: right;
            padding-top: 15px;
        }

        .row-item {
            margin-bottom: 2px;
            white-space: nowrap;
        }
        .lbl-bold {
            font-weight: bold;
        }
        .val-bold {
            font-weight: bold;
        }

        /* قسم أصناف الرخصة المكررة */
        .permis-grid {
            margin: 4px 0;
        }
        .permis-row {
            display: flex;
            justify-content: space-between;
            font-size: 10.5px;
            margin-bottom: 2px;
        }

        /* الجداول المالية السفلية */
        .finance-container {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin-top: 10px;
        }
        .finance-box {
            width: 49%;
            border: 1px solid #ccc;
        }
        .finance-header {
            text-align: center;
            padding: 4px;
            font-weight: bold;
            font-size: 11px;
            background: #fff;
            border-bottom: 1px solid #ccc;
        }
        .finance-sub {
            text-align: center;
            padding: 2px;
            font-size: 10px;
            border-bottom: 1px solid #ccc;
        }

        table.pay-table {
            width: 100%;
            border-collapse: collapse;
        }
        table.pay-table th, table.pay-table td {
            border: 1px solid #eee;
            padding: 3px;
            text-align: center;
            height: 20px;
            font-size: 10px;
        }
        table.pay-table th {
            background: #fcfcfc;
            font-weight: bold;
        }

        .footer-brand {
            position: fixed;
            bottom: 3mm;
            right: 8mm;
            left: 8mm;
            display: flex;
            justify-content: space-between;
            font-size: 8px;
            color: #666;
        }
    </style>
</head>
<body>

    <div class="no-print-bar">
        <span>معاينة طباعة بطاقة المرشح(ة)</span>
        <button class="btn-print" onclick="window.print()">طباعة البطاقة</button>
    </div>

    <!-- العنوان العلوي -->
    <div class="header-title">
        <h3>بطاقة المرشح(ة) Carte Candidat(e)</h3>
        <p>Ecole de Conduite: <?= htmlspecialchars($school['nom_ecole'] ?? 'auto-ecole') ?></p>
    </div>

    <div class="top-section">
        
        <!-- العمود الأيسر: الصورة والبيانات بالفرنسية -->
        <div class="col-left">
            <div class="photo-box">
                <?php 
                    $photoName = $candidat['photo'] ?? '';
                    // مسار الصور في مشروع Smart Auto-Ecole
                    $uploadPath = '/smart-auto-ecole/public/uploads/';
                    $fullPath = $_SERVER['DOCUMENT_ROOT'] . $uploadPath . $photoName;
                ?>
                <?php if (!empty($photoName) && file_exists($fullPath)): ?>
                    <img src="<?= $uploadPath . htmlspecialchars($photoName) ?>" alt="Photo">
                <?php elseif (!empty($photoName) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads/candidates/' . $photoName)): ?>
                    <img src="/uploads/candidates/<?= htmlspecialchars($photoName) ?>" alt="Photo">
                <?php else: ?>
                    <span style="color:#aaa; font-size:9px;">صورة / Photo</span>
                <?php endif; ?>
            </div>

            <div class="row-item"><span class="lbl-bold">Nom :</span> <span class="val-bold"><?= htmlspecialchars($candidat['nom'] ?? '') ?></span></div>
            <div class="row-item"><span class="lbl-bold">Prénom :</span> <span class="val-bold"><?= htmlspecialchars($candidat['prenom'] ?? '') ?></span></div>
            <div class="row-item"><span class="lbl-bold">N° Cin :</span> <span class="val-bold"><?= htmlspecialchars($candidat['cin'] ?? '') ?></span></div>
            <div class="row-item"><span class="lbl-bold">Numéro D'indcription National:</span> <span class="val-bold"><?= htmlspecialchars($contrat['num_enregistrement'] ?? '') ?></span></div>
            <div class="row-item"><span class="lbl-bold">Adresse:</span> <span class="val-bold"><?= htmlspecialchars($candidat['adresse'] ?? '') ?></span></div>
            <div class="row-item"><span class="lbl-bold">Tél:</span> <span class="val-bold"><?= htmlspecialchars($candidat['telephone'] ?? '') ?></span></div>
            <div class="row-item"><span class="lbl-bold">E-mail:</span> <span class="val-bold"><?= htmlspecialchars($candidat['email'] ?? '') ?></span></div>
            <div class="row-item"><span class="lbl-bold">Date de Naissance:</span> <span class="val-bold"><?= htmlspecialchars($candidat['date_naissance'] ?? '') ?></span></div>
            <div class="row-item"><span class="lbl-bold">Profession:</span> <span class="val-bold"><?= htmlspecialchars($candidat['profession'] ?? '') ?></span></div>
            
            <div class="row-item" style="margin-top: 5px;">
                <span class="lbl-bold">Catégorie de permis de Conduite Désirée:</span> <span class="val-bold"><?= htmlspecialchars($contrat['code'] ?? 'B') ?></span>
            </div>

            <div style="height: 85px;"></div> <!-- مسافة تعويضية لأصناف الرخصة بالعربية -->

            <div class="row-item"><span class="lbl-bold">Véhicule de Formation :</span> <span class="val-bold"><?= htmlspecialchars($vehicule['marque'] ?? '') ?> (<?= htmlspecialchars($vehicule['immatriculation'] ?? '') ?>)</span></div>
            <div class="row-item"><span class="lbl-bold">Moniteur Code de Route :</span> <span class="val-bold"><?= htmlspecialchars($moniteur_theorique['nom_complet'] ?? '') ?></span></div>
            <div class="row-item"><span class="lbl-bold">Moniteur de Conduite :</span> <span class="val-bold"><?= htmlspecialchars($moniteur_pratique['nom_complet'] ?? '') ?></span></div>
            <div class="row-item"><span class="lbl-bold">Date de début de la Formation :</span> <span class="val-bold"><?= htmlspecialchars($contrat['date_contrat'] ?? '') ?></span></div>
            <div class="row-item"><span class="lbl-bold">Date Fin de la Formation :</span> <span class="val-bold"><?= htmlspecialchars($contrat['date_fin'] ?? '') ?></span></div>
        </div>

        <!-- العمود الأيمن: البيانات بالعربية وأصناف الرخصة -->
        <div class="col-right">
            <div class="row-item"><span class="lbl-bold">الاسم العائلي:</span> <span class="val-bold"><?= htmlspecialchars($candidat['nom'] ?? '') ?></span></div>
            <div class="row-item"><span class="lbl-bold">الاسم الشخصي:</span> <span class="val-bold"><?= htmlspecialchars($candidat['prenom'] ?? '') ?></span></div>
            <div class="row-item"><span class="lbl-bold">رقم البطاقة الوطنية:</span> <span class="val-bold"><?= htmlspecialchars($candidat['cin'] ?? '') ?></span></div>
            <div class="row-item"><span class="lbl-bold">رقم التسجيل الوطني:</span> <span class="val-bold"><?= htmlspecialchars($contrat['num_enregistrement'] ?? '') ?></span></div>
            <div class="row-item"><span class="lbl-bold">العنوان:</span> <span class="val-bold"><?= htmlspecialchars($candidat['adresse'] ?? '') ?></span></div>
            <div class="row-item"><span class="lbl-bold">الهاتف:</span> <span class="val-bold"><?= htmlspecialchars($candidat['telephone'] ?? '') ?></span></div>
            <div class="row-item"><span class="lbl-bold">البريد الالكتروني:</span> <span class="val-bold"><?= htmlspecialchars($candidat['email'] ?? '') ?></span></div>
            <div class="row-item"><span class="lbl-bold">تاريخ الازدياد:</span> <span class="val-bold"><?= htmlspecialchars($candidat['date_naissance'] ?? '') ?></span></div>
            <div class="row-item"><span class="lbl-bold">المهنة:</span> <span class="val-bold"><?= htmlspecialchars($candidat['profession'] ?? '') ?></span></div>
            
            <div class="row-item" style="margin-top: 5px;">
                <span class="lbl-bold">صنف رخصة السياقة المرغوب في الحصول عليها:</span>
            </div>

            <!-- أسطر أصناف الرخصة المكررة كما في الصورة -->
            <div class="permis-grid">
                <?php for($k = 0; $k < 5; $k++): ?>
                    <div class="permis-row">
                        <span>صنف الرخصة المحصل عليها:</span>
                        <span>رقمها:</span>
                        <span>بتاريخ:</span>
                    </div>
                <?php endfor; ?>
            </div>

            <div class="row-item"><span class="lbl-bold">عربة التكوين:</span></div>
            <div class="row-item"><span class="lbl-bold">مدرب التكوين النظري:</span> <span class="val-bold"><?= htmlspecialchars($moniteur_theorique['nom_complet'] ?? '') ?></span></div>
            <div class="row-item"><span class="lbl-bold">مدرب التكوين التطبيقي:</span> <span class="val-bold"><?= htmlspecialchars($moniteur_pratique['nom_complet'] ?? '') ?></span></div>
            <div class="row-item"><span class="lbl-bold">تاريخ الشروع في التكوين:</span> <span class="val-bold"><?= htmlspecialchars($contrat['date_contrat'] ?? '') ?></span></div>
            <div class="row-item"><span class="lbl-bold">تاريخ الانتهاء من التكوين:</span> <span class="val-bold"><?= htmlspecialchars($contrat['date_fin'] ?? '') ?></span></div>
        </div>

    </div>

    <!-- الجداول المالية السفلية -->
    <div class="finance-container">
        
        <!-- العمود الأيسر: ثمن التكوين المتفق عليه -->
        <div class="finance-box">
            <div class="finance-header">ثمن التكوين المتفق عليه: <?= number_format($contrat['prix_final'] ?? 5000, 0, '', '') ?></div>
            <div class="finance-sub">الدفوعات</div>
            <table class="pay-table">
                <thead>
                    <tr>
                        <th style="width: 35%;">رقم التوصيل</th>
                        <th style="width: 30%;">المبلغ</th>
                        <th style="width: 35%;">التاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < 10; $i++): ?>
                        <tr>
                            <td><?= isset($payments[$i]) ? htmlspecialchars($payments[$i]['num_recu'] ?? '-') : '' ?></td>
                            <td><?= isset($payments[$i]) ? number_format($payments[$i]['montant'], 2) : '' ?></td>
                            <td><?= isset($payments[$i]) ? htmlspecialchars($payments[$i]['date_paiement']) : '' ?></td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>

        <!-- العمود الأيمن: مصاريف الملف -->
        <div class="finance-box">
            <div class="finance-header">مصاريف الملف:</div>
            <div class="finance-sub">الدفوعات</div>
            <table class="pay-table">
                <thead>
                    <tr>
                        <th style="width: 35%;">رقم التوصيل</th>
                        <th style="width: 30%;">المبلغ</th>
                        <th style="width: 35%;">التاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < 10; $i++): ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>

    </div>

    <div class="footer-brand">
        <span>GAE*</span>
        <span style="direction: ltr;">Design by GAE<br>www.gestionautoecole.com</span>
    </div>

</body>
</html>