<?php
$current_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$schoolName = !empty($schoolInfo['nom_ecole']) ? $schoolInfo['nom_ecole'] : 'Smart Auto-École';

$logoRaw = trim($schoolInfo['logo'] ?? '');
$logoFileName = !empty($logoRaw) ? basename($logoRaw) : 'logo.png';

$docRoot = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
$imagePath = $docRoot . '/smart-auto-ecole/public/uploads/' . $logoFileName;

$webLogoPath = '/smart-auto-ecole/public/uploads/' . $logoFileName;

$hasImage = !empty($logoFileName) && file_exists($imagePath);
?>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<aside class="sidebar" id="sidebar">

    <div class="sidebar-brand" style="display: flex; align-items: center; gap: 12px; padding: 15px;">
        <div class="brand-icon" style="width: 40px; height: 40px; min-width: 40px; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 8px; background: rgba(255, 255, 255, 0.05);">
            <?php if ($hasImage): ?>
                <img src="<?= htmlspecialchars($webLogoPath) ?>" alt="Logo" class="school-logo-img" style="width: 100%; height: 100%; object-fit: contain; display: block;">
            <?php else: ?>
                <svg viewBox="0 0 24 24" aria-hidden="true" width="24" height="24" style="color: #fff;">
                    <path d="M5 17h14l-1-6H6l-1 6Z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                    <path d="M7 11l2-5h6l2 5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="8" cy="18" r="2" fill="none" stroke="currentColor" stroke-width="2"/>
                    <circle cx="16" cy="18" r="2" fill="none" stroke="currentColor" stroke-width="2"/>
                </svg>
            <?php endif; ?>
        </div>

        <div class="brand-text" style="display: flex; flex-direction: column;">
            <span class="brand-name" title="<?= htmlspecialchars($schoolName) ?>" style="color: #fff; font-weight: 600; font-size: 0.95rem; line-height: 1.2;"><?= htmlspecialchars($schoolName) ?></span>
            <span class="brand-subtitle" style="color: #a0aec0; font-size: 0.75rem;">Gestion Auto-École</span>
        </div>

        <button class="sidebar-close-btn" onclick="toggleSidebar()" aria-label="Fermer le menu" style="margin-left: auto; background: transparent; border: none; color: #a0aec0; cursor: pointer;">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
    </div>

    <nav class="sidebar-navigation" aria-label="Main navigation">

        <p class="nav-section-title">MENU PRINCIPAL</p>

        <ul class="nav-list">

            <li class="nav-item <?php echo ($current_uri === '/smart-auto-ecole/public/' || $current_uri === '/smart-auto-ecole/public/dashboard') ? 'active' : ''; ?>">
                <a href="/smart-auto-ecole/public/dashboard" class="nav-link">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1" fill="none" stroke="currentColor" stroke-width="2"/><rect x="14" y="3" width="7" height="7" rx="1" fill="none" stroke="currentColor" stroke-width="2"/><rect x="3" y="14" width="7" height="7" rx="1" fill="none" stroke="currentColor" stroke-width="2"/><rect x="14" y="14" width="7" height="7" rx="1" fill="none" stroke="currentColor" stroke-width="2"/></svg>
                    <span>Tableau de Bord</span>
                </a>
            </li>

            <li class="nav-item <?php echo (strpos($current_uri, '/candidates') !== false) ? 'active' : ''; ?>">
                <a href="/smart-auto-ecole/public/candidates" class="nav-link">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8" r="3" fill="none" stroke="currentColor" stroke-width="2"/><path d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M16 5.5a3 3 0 0 1 0 5.8" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M18 14c1.8 1.1 3 3 3 5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    <span>Candidats</span>
                </a>
            </li>

            <li class="nav-item <?php echo (strpos($current_uri, '/contrats') !== false) ? 'active' : ''; ?>">
                <a href="/smart-auto-ecole/public/contrats" class="nav-link">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" fill="none" stroke="currentColor" stroke-width="2"/><polyline points="14 2 14 8 20 8" fill="none" stroke="currentColor" stroke-width="2"/><line x1="16" y1="13" x2="8" y2="13" stroke="currentColor" stroke-width="2"/><line x1="16" y1="17" x2="8" y2="17" stroke="currentColor" stroke-width="2"/></svg>
                    <span>Contrats</span>
                </a>
            </li>

            <li class="nav-item <?php echo (strpos($current_uri, '/lessons') !== false) ? 'active' : ''; ?>">
                <a href="/smart-auto-ecole/public/lessons" class="nav-link">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="5" width="16" height="16" rx="2" fill="none" stroke="currentColor" stroke-width="2"/><path d="M8 3v4M16 3v4M4 10h16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M8 14h3M8 18h6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    <span>Séances & Planning</span>
                </a>
            </li>

            <li class="nav-item <?php echo (strpos($current_uri, '/exams') !== false) ? 'active' : ''; ?>">
                <a href="/smart-auto-ecole/public/exams" class="nav-link">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="5" y="3" width="14" height="18" rx="2" fill="none" stroke="currentColor" stroke-width="2"/><path d="M8 8l1.5 1.5L12 7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 13h8M8 17h5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    <span>Examens</span>
                </a>
            </li>

            <li class="nav-item <?php echo (strpos($current_uri, '/payments') !== false) ? 'active' : ''; ?>">
                <a href="/smart-auto-ecole/public/payments" class="nav-link">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2" fill="none" stroke="currentColor" stroke-width="2"/><path d="M3 10h18" fill="none" stroke="currentColor" stroke-width="2"/><path d="M7 15h3" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    <span>Paiements & Finances</span>
                </a>
            </li>

            <li class="nav-item <?php echo (strpos($current_uri, '/instructors') !== false) ? 'active' : ''; ?>">
                <a href="/smart-auto-ecole/public/instructors" class="nav-link">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="7" r="3" fill="none" stroke="currentColor" stroke-width="2"/><path d="M5 21v-2a7 7 0 0 1 14 0v2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M5 12h14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    <span>Moniteurs</span>
                </a>
            </li>

            <li class="nav-item <?php echo (strpos($current_uri, '/vehicles') !== false) ? 'active' : ''; ?>">
                <a href="/smart-auto-ecole/public/vehicles" class="nav-link">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 17h14l-1-6H6l-1 6Z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M7 11l2-5h6l2 5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="8" cy="18" r="2" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="16" cy="18" r="2" fill="none" stroke="currentColor" stroke-width="2"/></svg>
                    <span>Véhicules</span>
                </a>
            </li>

            <p class="nav-section-title" style="margin-top: 15px;">CONFIGURATION</p>

            <li class="nav-item <?php echo (strpos($current_uri, '/settings') !== false || strpos($current_uri, '/school') !== false) ? 'active' : ''; ?>">
                <a href="/smart-auto-ecole/public/settings" class="nav-link">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="3" fill="none" stroke="currentColor" stroke-width="2"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" fill="none" stroke="currentColor" stroke-width="2"/></svg>
                    <span>Paramètres</span>
                </a>
            </li>

        </ul>

    </nav>

    <div class="sidebar-footer">
        <div class="system-status">
            <span class="status-dot"></span>
            <span>En ligne</span>
        </div>
    </div>

</aside>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    if (window.innerWidth <= 767) {
        sidebar.classList.toggle('active');
        if (overlay) overlay.classList.toggle('active');
    } else {
        sidebar.classList.toggle('collapsed');
        document.body.classList.toggle('sidebar-collapsed'); // مهم جداً للتأثير على الهيدر
    }
}
</script>