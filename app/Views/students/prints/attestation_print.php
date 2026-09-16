<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>شهادة نهاية التكوين في تعليم السياقة - <?= htmlspecialchars(($candidat['nom'] ?? '') . ' ' . ($candidat['prenom'] ?? '')) ?></title>
    <style>
        @page {
            size: A4;
            margin: 15mm;
        }
        body {
            font-family: Arial, sans-serif;
            color: #000;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            font-size: 13px;
        }
        .no-print-bar {
            background: #2563eb;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
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

        .cert-container {
            padding: 10px 20px;
        }

        .title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .grid-2col {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }

        .legal-box {
            border: 1px solid #777;
            padding: 10px;
            margin: 15px 0;
            width: 45%;
            margin-left: auto;
        }

        .section-text {
            margin-top: 15px;
            text-align: justify;
        }

        .field-val {
            font-weight: bold;
            margin: 0 4px;
        }

        .moniteurs-block {
            margin: 20px 0;
        }

        .signatures {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
            padding: 0 20px;
        }
        .sig-box {
            text-align: center;
            width: 45%;
        }

        .footer-date {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
            padding: 0 50px;
        }
    </style>
</head>
<body>

    <div class="no-print-bar">
        <span>معاينة طباعة شهادة نهاية التكوين</span>
        <button class="btn-print" onclick="window.print()">طباعة الشهادة</button>
    </div>

    <div class="cert-container">
        
        <div class="title">
            شهادة نهاية التكوين في تعليم السياقة
        </div>

        <!-- معلومات المؤسسة -->
        <div class="grid-2col">
            <div><strong>العلامة التجارية للمؤسسة أو الاسم التجاري للمؤسسة:</strong> <span class="field-val"><?= htmlspecialchars($school['nom_ecole'] ?? '') ?></span></div>
        </div>
        <div class="grid-2col">
            <div><strong>رقم الرخصة:</strong> <span class="field-val"><?= htmlspecialchars($school['num_autorisation'] ?? '') ?></span></div>
        </div>
        <div class="grid-2col">
            <div><strong>رقم القيد في السجل الوطني الخاص بمؤسسات تعليم السياقة:</strong> <span class="field-val"><?= htmlspecialchars($school['num_registre_national'] ?? '') ?></span></div>
        </div>
        <div class="grid-2col">
            <div><strong>رقم القيد في سجل الضريبة المهنية:</strong> <span class="field-val"><?= htmlspecialchars($school['patente'] ?? '') ?></span></div>
            <div><strong>رقم القيد في السجل التجاري:</strong> <span class="field-val"><?= htmlspecialchars($school['rc'] ?? '') ?></span></div>
            <div><strong>المدينة:</strong> <span class="field-val"><?= htmlspecialchars($school['ville'] ?? '') ?></span></div>
        </div>
        <div class="grid-2col">
            <div><strong>العنوان:</strong> <span class="field-val"><?= htmlspecialchars($school['adresse'] ?? '') ?></span></div>
        </div>
        <div class="grid-2col">
            <div><strong>الهاتف:</strong> <span class="field-val"><?= htmlspecialchars($school['telephone'] ?? '') ?></span></div>
            <div><strong>الفاكس:</strong> <span class="field-val"><?= htmlspecialchars($school['fax'] ?? '') ?></span></div>
        </div>
        <div class="grid-2col">
            <div><strong>البريد الإلكتروني:</strong> <span class="field-val"><?= htmlspecialchars($school['email'] ?? '') ?></span></div>
        </div>

        <!-- الممثل القانوني -->
        <div style="margin-top: 10px;"><strong>الممثل القانوني للمؤسسة</strong></div>
        <div class="legal-box">
            <div><strong>الإسم الشخصي:</strong> <span class="field-val"><?= htmlspecialchars($school['prenom_representant'] ?? '') ?></span></div>
            <div><strong>الإسم العائلي:</strong> <span class="field-val"><?= htmlspecialchars($school['nom_representant'] ?? '') ?></span></div>
            <div><strong>العنوان:</strong> <span class="field-val"><?= htmlspecialchars($school['adresse_representant'] ?? '') ?></span></div>
            <div><strong>رقم الهاتف:</strong> <span class="field-val"><?= htmlspecialchars($school['tel_representant'] ?? '') ?></span></div>
        </div>

        <!-- بيانات التكوين والمرشح -->
        <div class="section-text">
            أشهد أن السيد(ة) <span class="field-val"><?= htmlspecialchars(($candidat['nom'] ?? '') . ' ' . ($candidat['prenom'] ?? '')) ?></span><br>
            الحامل(ة) للبطاقة الوطنية التعريف رقم: <span class="field-val"><?= htmlspecialchars($candidat['cin'] ?? '') ?></span><br>
            الرقم الممنوح من طرف الإدارة (Référence web) : <span class="field-val"><?= htmlspecialchars($contrat['num_enregistrement'] ?? '') ?></span><br>
            بناء على عقد التكوين الموقع بين الطرفين بتاريخ: <span class="field-val"><?= htmlspecialchars($contrat['date_contrat'] ?? '') ?></span>
        </div>

        <div class="section-text">
            تلقى(تلقّت) بهذه المؤسسة دروسا نظرية و تطبيقية في تعليم سياقة المركبات من صنف <span class="field-val"><?= htmlspecialchars($contrat['code'] ?? 'B') ?></span><br>
            بما مجموعـه <span class="field-val"><?= htmlspecialchars($contrat['heures_theoriques'] ?? '35') ?></span> ساعة بالنسبة للتكوين النظرى و <span class="field-val"><?= htmlspecialchars($contrat['heures_pratiques'] ?? '25') ?></span> ساعة بالنسبة للتكوين التطبيقي طبقا للبرنامج الوطني لتعليم السياقة
        </div>

        <!-- المدربين -->
        <div class="moniteurs-block">
            <div class="grid-2col">
                <div>و قد أشرف على التكوين النظري المدرب الوارد إسمه بعده: <span class="field-val"><?= htmlspecialchars($moniteur_theorique['nom_complet'] ?? '-') ?></span></div>
                <div>رقم رخصته: <span class="field-val"><?= htmlspecialchars($moniteur_theorique['num_autorisation'] ?? '-') ?></span></div>
            </div>
            <div class="grid-2col" style="margin-top: 8px;">
                <div>و أشرف على التكوين التطبيقي المدرب الوارد إسمه بعده: <span class="field-val"><?= htmlspecialchars($moniteur_pratique['nom_complet'] ?? '-') ?></span></div>
                <div>رقم رخصته: <span class="field-val"><?= htmlspecialchars($moniteur_pratique['num_autorisation'] ?? '-') ?></span></div>
            </div>
        </div>

        <div class="section-text">
            كما تلقى(تلقّت) تكوينه(ها) بواسطة المركبة من صنف <span class="field-val"><?= htmlspecialchars($contrat['code'] ?? 'B') ?></span><br>
            في إسم المؤسسة <span class="field-val"><?= htmlspecialchars($school['nom_ecole'] ?? '') ?></span> المسجلة تحت رقم <span class="field-val"><?= htmlspecialchars($vehicule['immatriculation'] ?? '-') ?></span>
        </div>

        <!-- التوقيعات -->
        <div class="signatures">
            <div class="sig-box">
                <strong>طابع المؤسسة وإسم توقيع الممثل القانوني للمؤسسة</strong>
            </div>
            <div class="sig-box">
                <strong>إسم و توقيع المرشح</strong>
            </div>
        </div>

        <!-- التاريخ والمدينة -->
        <div class="footer-date">
            <div>حرر بـ <span class="field-val"><?= htmlspecialchars($school['ville'] ?? '') ?></span></div>
            <div>بتاريخ <span class="field-val"><?= date('Y-m-d') ?></span></div>
        </div>

    </div>

</body>
</html>