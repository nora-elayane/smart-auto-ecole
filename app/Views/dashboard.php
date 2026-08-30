<?php require_once __DIR__ . '/layouts/header.php'; ?>
<?php require_once __DIR__ . '/layouts/sidebar.php'; ?>

<main class="main-content">
    <div class="page-content">

        <!-- Page Header -->
        <div style="margin-bottom: 24px;">
            <h1 style="font-size: 24px; font-weight: 700; letter-spacing: -0.4px;">Tableau de Bord</h1>
            <p class="card-description">Bienvenue dans le système de gestion Smart Auto-École</p>
        </div>

        <!-- Dashboard Stat Cards Grid -->
        <div class="dashboard-grid" style="margin-bottom: 28px;">
            
            <!-- Total Candidats -->
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <div>
                        <div class="dashboard-card-label">Total Candidats</div>
                        <div class="dashboard-card-value"><?php echo $totalStudents; ?></div>
                    </div>
                    <div class="dashboard-card-icon">
                        <svg width="21" height="21" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Séances du Jour -->
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <div>
                        <div class="dashboard-card-label">Séances d'Aujourd'hui</div>
                        <div class="dashboard-card-value" style="color: var(--primary);">8</div>
                    </div>
                    <div class="dashboard-card-icon">
                        <svg width="21" height="21" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    </div>
                </div>
            </div>

            <!-- Véhicules Actifs -->
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <div>
                        <div class="dashboard-card-label">Véhicules Actifs</div>
                        <div class="dashboard-card-value" style="color: var(--success);">5</div>
                    </div>
                    <div class="dashboard-card-icon" style="background: #f0fdf4; color: var(--success);">
                        <svg width="21" height="21" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    </div>
                </div>
            </div>

            <!-- Examens -->
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <div>
                        <div class="dashboard-card-label">Examens de la Semaine</div>
                        <div class="dashboard-card-value" style="color: var(--warning);">3</div>
                    </div>
                    <div class="dashboard-card-icon" style="background: #fffbeb; color: var(--warning);">
                        <svg width="21" height="21" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    </div>
                </div>
            </div>

        </div>

        <!-- Quick Table Example -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Planning des Séances d'Aujourd'hui</h3>
                <a href="#" style="color: var(--primary); font-size: 14px; font-weight: 500;">Voir tout →</a>
            </div>
            
            <div class="table-wrapper" style="border: 0;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Candidat</th>
                            <th>Type de Séance</th>
                            <th>Horaire</th>
                            <th>Moniteur</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="font-weight: 600;">Ahmed El Alami</td>
                            <td>
                                <span class="badge" style="background: #e0f2fe; color: #0369a1;">Conduite</span>
                            </td>
                            <td style="font-family: monospace; font-weight: 500;">10:00 - 11:00</td>
                            <td>Mustapha</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600;">Sara Bennani</td>
                            <td>
                                <span class="badge" style="background: #f3f4f6; color: #4b5563;">Code</span>
                            </td>
                            <td style="font-family: monospace; font-weight: 500;">11:30 - 12:30</td>
                            <td>Khalid</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>