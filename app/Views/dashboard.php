

<?php require_once __DIR__ . '/layouts/header.php'; ?>
<?php require_once __DIR__ . '/layouts/sidebar.php'; ?>

<main class="main-content">
    <div class="container">


        <!-- Title -->
        <div class="page-header" style="margin-bottom: 2rem;">
            <h1>لوحة التحكم (Dashboard)</h1>
            <p style="color: #64748b;">مرحباً بك في نظام إدارة سيارة التعليم Smart Auto-École</p>
        </div>

        <!-- Stat Cards Grid -->
        <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            
            <div class="card" style="background: #ffffff; padding: 1.5rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <span style="font-size: 0.875rem; color: #64748b;">إجمالي المرشحين</span>
                <h2 style="font-size: 1.875rem; margin-top: 0.5rem; color: #1e293b;">42</h2>
            </div>

            <div class="card" style="background: #ffffff; padding: 1.5rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <span style="font-size: 0.875rem; color: #64748b;">حصص اليوم</span>
                <h2 style="font-size: 1.875rem; margin-top: 0.5rem; color: #2563eb;">8</h2>
            </div>

            <div class="card" style="background: #ffffff; padding: 1.5rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <span style="font-size: 0.875rem; color: #64748b;">السيارات الخدامة</span>
                <h2 style="font-size: 1.875rem; margin-top: 0.5rem; color: #16a34a;">5</h2>
            </div>

            <div class="card" style="background: #ffffff; padding: 1.5rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <span style="font-size: 0.875rem; color: #64748b;">امتحانات هذا الأسبوع</span>
                <h2 style="font-size: 1.875rem; margin-top: 0.5rem; color: #d97706;">3</h2>
            </div>

        </div>

        <!-- Quick Table Example -->
        <div class="card" style="background: #ffffff; padding: 1.5rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <h3 style="margin-bottom: 1rem; font-size: 1.1rem; color: #1e293b;">جدول حصص اليوم</h3>
            <table style="width: 100%; border-collapse: collapse; text-align: right;">
                <thead>
                    <tr style="border-bottom: 2px solid #e2e8f0; color: #64748b;">
                        <th style="padding: 0.75rem;">المرشح</th>
                        <th style="padding: 0.75rem;">نوع الحصة</th>
                        <th style="padding: 0.75rem;">التوقيت</th>
                        <th style="padding: 0.75rem;">المدرب</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 0.75rem;">أحمد العالمي</td>
                        <td style="padding: 0.75rem;">تطبيقي (Conduite)</td>
                        <td style="padding: 0.75rem;">10:00 - 11:00</td>
                        <td style="padding: 0.75rem;">مصطفى</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 0.75rem;">سارة بناني</td>
                        <td style="padding: 0.75rem;">نظري (Code)</td>
                        <td style="padding: 0.75rem;">11:30 - 12:30</td>
                        <td style="padding: 0.75rem;">خالد</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>
</body>
</html>