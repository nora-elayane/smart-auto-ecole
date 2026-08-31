<?php
$current_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<aside class="sidebar" id="sidebar">

    <!-- Brand -->
    <div class="sidebar-brand">
        <div class="brand-icon">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M5 17h14l-1-6H6l-1 6Z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                <path d="M7 11l2-5h6l2 5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="8" cy="18" r="2" fill="none" stroke="currentColor" stroke-width="2"/>
                <circle cx="16" cy="18" r="2" fill="none" stroke="currentColor" stroke-width="2"/>
            </svg>
        </div>

        <div class="brand-text">
            <span class="brand-name">Smart Auto-École</span>
            <span class="brand-subtitle">Système de Gestion</span>
        </div>
    </div>

    <nav class="sidebar-navigation" aria-label="Main navigation">

        <p class="nav-section-title">MENU PRINCIPAL</p>

        <ul class="nav-list">

            <li class="nav-item <?php echo ($current_uri === '/smart-auto-ecole/public/' || $current_uri === '/smart-auto-ecole/public/dashboard') ? 'active' : ''; ?>">
                <a href="/smart-auto-ecole/public/dashboard" class="nav-link">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="3" y="3" width="7" height="7" rx="1" fill="none" stroke="currentColor" stroke-width="2"/>
                        <rect x="14" y="3" width="7" height="7" rx="1" fill="none" stroke="currentColor" stroke-width="2"/>
                        <rect x="3" y="14" width="7" height="7" rx="1" fill="none" stroke="currentColor" stroke-width="2"/>
                        <rect x="14" y="14" width="7" height="7" rx="1" fill="none" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    <span>Tableau de Bord</span>
                </a>
            </li>

            <li class="nav-item <?php echo (strpos($current_uri, '/candidates') !== false) ? 'active' : ''; ?>">
                <a href="/smart-auto-ecole/public/candidates" class="nav-link">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="9" cy="8" r="3" fill="none" stroke="currentColor" stroke-width="2"/>
                        <path d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M16 5.5a3 3 0 0 1 0 5.8" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M18 14c1.8 1.1 3 3 3 5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span>Candidats</span>
                </a>
            </li>

            <li class="nav-item <?php echo (strpos($current_uri, '/instructors') !== false) ? 'active' : ''; ?>">
                <a href="/smart-auto-ecole/public/instructors" class="nav-link">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="12" cy="7" r="3" fill="none" stroke="currentColor" stroke-width="2"/>
                        <path d="M5 21v-2a7 7 0 0 1 14 0v2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M5 12h14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span>Moniteurs</span>
                </a>
            </li>

            <li class="nav-item <?php echo (strpos($current_uri, '/vehicles') !== false) ? 'active' : ''; ?>">
                <a href="/smart-auto-ecole/public/vehicles" class="nav-link">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M5 17h14l-1-6H6l-1 6Z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                        <path d="M7 11l2-5h6l2 5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="8" cy="18" r="2" fill="none" stroke="currentColor" stroke-width="2"/>
                        <circle cx="16" cy="18" r="2" fill="none" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    <span>Véhicules</span>
                </a>
            </li>

            <li class="nav-item <?php echo (strpos($current_uri, '/lessons') !== false) ? 'active' : ''; ?>">
                <a href="/smart-auto-ecole/public/lessons" class="nav-link">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="4" y="5" width="16" height="16" rx="2" fill="none" stroke="currentColor" stroke-width="2"/>
                        <path d="M8 3v4M16 3v4M4 10h16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M8 14h3M8 18h6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span>Séances & Planning</span>
                </a>
            </li>

            <li class="nav-item <?php echo (strpos($current_uri, '/exams') !== false) ? 'active' : ''; ?>">
                <a href="/smart-auto-ecole/public/exams" class="nav-link">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="5" y="3" width="14" height="18" rx="2" fill="none" stroke="currentColor" stroke-width="2"/>
                        <path d="M8 8l1.5 1.5L12 7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8 13h8M8 17h5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span>Examens</span>
                </a>
            </li>

            <li class="nav-item <?php echo (strpos($current_uri, '/payments') !== false) ? 'active' : ''; ?>">
                <a href="/smart-auto-ecole/public/payments" class="nav-link">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="3" y="5" width="18" height="14" rx="2" fill="none" stroke="currentColor" stroke-width="2"/>
                        <path d="M3 10h18" fill="none" stroke="currentColor" stroke-width="2"/>
                        <path d="M7 15h3" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span>Paiements & Finances</span>
                </a>
            </li>

        </ul>

    </nav>

    <div class="sidebar-footer">
        <div class="system-status">
            <span class="status-dot"></span>
            <span>Système en ligne</span>
        </div>
    </div>

</aside>