<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>عقد التكوين - <?= htmlspecialchars(($candidat['nom'] ?? '') . ' ' . ($candidat['prenom'] ?? '')) ?></title>
    <style>
        @page {
            size: A4 portrait;
            margin: 8mm 12mm;
        }
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Traditional Arabic', 'Simplified Arabic', Tahoma, Arial, sans-serif;
            color: #000;
            line-height: 1.35;
            margin: 0;
            padding: 0;
            font-size: 11.5px;
            background: #fff;
        }
        .no-print-bar {
            background: #2563eb;
            color: #fff;
            padding: 8px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            border-radius: 4px;
            font-family: Arial, sans-serif;
        }
        .btn-print {
            background: #fff;
            color: #2563eb;
            border: none;
            padding: 6px 12px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
        }
        @media print {
            .no-print-bar { display: none !important; }
            html, body {
                height: 100%;
                overflow: hidden;
            }
        }

        /* Top Header Info */
        .top-meta {
            width: 100%;
            display: flex;
            justify-content: space-between;
            font-size: 11.5px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        /* Title Block */
        .title-block {
            text-align: center;
            margin-bottom: 10px;
        }
        .title-block .main-title {
            font-size: 19px;
            font-weight: bold;
            line-height: 1.1;
        }
        .title-block .sub-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 2px;
        }
        .title-block .num-title {
            font-size: 11px;
        }

        /* Section Header */
        .section-header {
            font-size: 13.5px;
            font-weight: bold;
            margin-bottom: 6px;
            display: flex;
            justify-content: flex-end;
            border-bottom: 1px solid #000;
            padding-bottom: 1px;
        }

        /* Detailed Key-Value Block Layout */
        .block-section {
            margin-bottom: 8px;
        }
        .row-line {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
            font-size: 11px;
            line-height: 2.2;
        }
        .row-line.right-align {
            justify-content: flex-start;
        }
        .label-bold {
            font-weight: bold;
        }

        .divider {
            border-bottom: 1px dashed #ccc;
            margin: 8px 0;
        }

        /* Articles Styling */
        .article {
            margin-bottom: 5px;
            text-align: justify;
        }
        .article-title {
            font-weight: bold;
            font-size: 11.5px;
            margin-bottom: 2px;
            color: #000;
        }
        .article-body {
            font-size: 10.5px;
            color: #555555; /* لون باهت للمواد */
            line-height: 1.35;
        }

        /* Bottom Footer Signatures */
        .footer-signatures {
            margin-top: 10px;
        }
        .city-date-line {
            display: flex;
            justify-content: space-around;
            font-size: 11px;
            margin-top: 3px;
        }
        .sig-line {
            text-align: center;
            font-size: 11px;
        }
    </style>
</head>
<body>

    <div class="no-print-bar">
        <span>معاينة طباعة عقد التكوين الرسمية</span>
        <button class="btn-print" onclick="window.print()">طباعة العقد</button>
    </div>

    <!-- Header Meta -->
    <div class="top-meta">
        <div>عقد التكوين</div>
        <div>بتاريخ : <?= htmlspecialchars($contrat['date_contrat'] ?? '') ?></div>
    </div>

    <!-- Title Block -->
    <div class="title-block">
        <div class="main-title">عقد التكوين</div>
<div class="sub-title">رخصة السياقة من صنف : <?= htmlspecialchars($contrat['category_code'] ?? $contrat['code'] ?? '') ?></div>        <div class="num-title">رقم : <?= htmlspecialchars($contrat['id_contrat'] ?? '') ?></div>
    </div>

    <!-- Section: الطرفين -->
    <div class="section-header">
        <span>طرفي العقد</span>
    </div>

    <!-- Party 1: School Info -->
    <div class="block-section">
        <div class="row-line right-align">
            <div><span class="label-bold">مؤسسة تعليم السياقة :</span> <?= htmlspecialchars($school['nom_ecole'] ?? '') ?></div>
        </div>
        <div class="row-line right-align">
            <div><span class="label-bold">رقم القيد في السجل الوطني الخاص بمؤسسات تعليم السياقة :</span> <?= htmlspecialchars($school['num_registre_national'] ?? '') ?></div>
        </div>
        <div class="row-line">
            <div><span class="label-bold">رقم القيد في سجل الضريبة المهنية :</span> <?= htmlspecialchars($school['patent'] ?? '') ?></div>
            <div><span class="label-bold">رقم القيد في سجل التجاري :</span> <?= htmlspecialchars($school['rc'] ?? '') ?></div>
            <div style="min-width: 150px;"><span class="label-bold">المدينة :</span> <?= htmlspecialchars($school['ville'] ?? '') ?></div>
        </div>
        <div class="row-line">
            <div><span class="label-bold">العنوان :</span> <?= htmlspecialchars($school['adresse'] ?? '') ?></div>
        </div>
        <div class="row-line">
            <div><span class="label-bold">الهاتف :</span> <?= htmlspecialchars($school['telephone'] ?? '') ?></div>
            <div><span class="label-bold">الفاكس :</span> <?= htmlspecialchars($school['fax'] ?? '') ?></div>
            <div style="min-width: 200px;"><span class="label-bold">البريد الالكتروني:</span> <?= htmlspecialchars($school['email'] ?? '') ?></div>
        </div>
        <div class="row-line" style="justify-content: flex-start; margin-top: 2px;">
            <div style="margin-right: 200px;"><span class="label-bold">المسماة المؤسسة</span></div>
        </div>
    </div>

    <div class="divider"></div>

    <!-- Party 2: Candidate Info -->
    <div class="block-section">
        <div class="row-line right-align">
            <div><span class="label-bold">والسيد(ة) :</span> <?= htmlspecialchars(trim(($candidat['nom'] ?? '') . ' ' . ($candidat['prenom'] ?? ''))) ?></div>
        </div>
        <div class="row-line">
            <div><span class="label-bold">رقم ب.و.ت.إ :</span> <?= htmlspecialchars($candidat['cin'] ?? '') ?></div>
            <div><span class="label-bold">المزدياد(ة) ب :</span> <?= htmlspecialchars($candidat['lieu_naissance'] ?? '') ?></div>
            <div style="min-width: 180px;"><span class="label-bold">بتاريخ :</span> <?= htmlspecialchars($candidat['date_naissance'] ?? '') ?></div>
        </div>
        <div class="row-line">
            <div><span class="label-bold">القاطن(ة) ب :</span> <?= htmlspecialchars($candidat['adresse'] ?? '') ?></div>
        </div>
        <div>
    <span class="label-bold">رقم تسجيل المرشح الممنوح من طرف الإدارة :</span> 
    <?= htmlspecialchars($contrat['num_enregistrement'] ?? '') ?>
</div>
        <div class="row-line" style="justify-content: flex-start; margin-top: 2px;">
            <div style="margin-right: 150px;"><span class="label-bold">المسمى(ة) المرشح(ة)</span></div>
        </div>
    </div>

    <!-- Articles Section -->
    <div class="article">
        <div class="article-title">المادة الأولى : موضوع العقد</div>
        <div class="article-body">
            يهدف هذا العقد الى تكوين المرشح وتمكينه من اكتساب المعارف والمهارات الضرورية اللازمة التي تمكنه من سياقة مركبة تتطلب قيادتها رخصة السياقة من صنف <?= htmlspecialchars($contrat['category_code'] ?? $contrat['code'] ?? '') ?>، طبقا للبرامج المحددة من طرف الإدارة.<br>
            كما يحدد حقوق وواجبات كلا الطرفين مع مراعاة القوانين والأنظمة الجاري بها العمل في هذا الشأن.
        </div>
    </div>

    <div class="article">
        <div class="article-title">المادة 2 : مدة العقد</div>
        <div class="article-body">
            يمتد هذا العقد لمدة ستة أشهر ومن تاريخ توقيعه، ويمكن تمديده، في حالة الاتفاق بين الطرفين، لمدة لا تتعدى ثلاثة أشهر.
        </div>
    </div>

    <div class="article">
        <div class="article-title">المادة 3 : التزامات المؤسسة</div>
        <div class="article-body">
            تلتزم المؤسسة بتكوين المرشح طبقا للبرنامج الوطني لتعليم السياقة.<br>
            تلقن الدروس النظرية والتطبيقية، تحت إشراف مدير المؤسسة، من طرف مدرب أو مدربي تعليم السياقة مرخص لهم، تشغلهم المؤسسة لهذا الغرض وبواسطة مركبات لتعليم السياقة في ملكيتها.<br>
            تلتزم المؤسسة بتوفير المركبة التي يتم بواسطتها إجراء الاختبار التطبيقي.<br>
            لا يمكن الشروع في التكوين النظري إلا بعد حصول المرشح على رقم التسجيل الممنوح من طرف الإدارة.<br>
            تلتزم المؤسسة بإخبار المرشح فورا بحصوله على هذا الرقم، كما تلتزم بتسليم المرشح شهادة نهاية التكوين فور إنهائه له.<br>
            تحتفظ المؤسسة بحق إرجاء دروس التكوين إلى تاريخ لاحق في حالة قوة قاهرة وفي كل الحالات التي تكون فيها السلامة غير متوفرة.<br>
            بعد استفادة المرشح من عدد ساعات التكوين النظري والتطبيقي المتفق عليها، تلتزم المؤسسة بتقديمه لاجتياز الامتحانات لنيل رخصة السياقة في حدود المقاعد الممنوحة من طرف الإدارة.
        </div>
    </div>

    <div class="article">
        <div class="article-title">المادة 4 : التزامات المرشح</div>
        <div class="article-body">
            إذا توقف المرشح عن التكوين، سواء بصفة مؤقتة أو نهائية، م كيفما كانت الأسباب، يلتزم بإخبار المؤسسة كتابيا.<br>
            في حالة التوقف لأكثر من ثلاثة (3) أشهر متتالية، يحق للمؤسسة مطالبة المرشح بأداء مبالغ الخدمات المتبقية، وغير المؤداة، إذا انقطع المرشح عن التكوين لمدة تفوق سنة (6) أشهر، يعتبر متخليا عن التكوين ولا يحق له أن يسترجع ما دفعه من أجله.<br>
            إذا تخلى المرشح عن التكوين لسبب يعود له، تؤدي التعريفة كاملة.<br>
            في حالة عدم النجاح في الامتحان، يلتزم المرشح بأداء مصاريف إعادة تكوينه وفقا لنفس التعريفة.
        </div>
    </div>

    <div class="article">
        <div class="article-title">المادة 5 : مدة التكوين</div>
        <div class="article-body">
            اتفق الطرفان على تحديد عدد ساعات التكوين في 20 ساعة بالنسبة للتكوين النظري و 30 ساعة بالنسبة للتكوين التطبيقي' لا يقل هذا العدد عن العدد الأدنى المحدد بالمادة 32 من دفتر التحملات الخاص بفتح واستغلال مؤسسات تعليم السياقة.
        </div>
    </div>

    <div class="article">
        <div class="article-title">المادة 6 : تعريفة التكوين</div>
        <div class="article-body">
            تحتسب التعريفة الإجمالية للتكوين على أساس تعريفة ساعة التكوين النظري والتطبيقي المحدد في المادة 1 من القرار الذي يحدد تعريفة ساعة التكوين النظري والتطبيقي.
        </div>
    </div>

    <div class="article">
        <div class="article-title">المادة 7 : كيفيات الأداء</div>
        <div class="article-body">
            تسلم للمرشح فاتورة تحدد المبالغ المدفوعة للمؤسسة، تكون هذه الفاتورة مؤرخة م موقعة من طرف صاحب المؤسسة تحمل هذه الفاتورة اسم وطابع المؤسسة، وفقا للتشريعات الجاري بها العمل.<br>
            في حالة الاتفاق بين الطرفين، يمكن أداء مبلغ التكوين على أقساط.
        </div>
    </div>

    <!-- Signatures -->
    <div class="footer-signatures">
        <div class="sig-line">عقد محرر في نظيرين أصليين.</div>
        <div class="city-date-line">
            <div>في : <strong><?= htmlspecialchars($school['ville'] ?? '') ?></strong></div>
            <div>بتاريخ : <strong><?= htmlspecialchars($contrat['date_contrat'] ?? '') ?></strong></div>
        </div>
    </div>

</body>
</html>