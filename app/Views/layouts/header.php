<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Smart Auto-École System'; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/smart-auto-ecole/public/css/style.css">
</head>
<body>

<div class="app-layout">
    <?php require_once __DIR__ . '/sidebar.php'; ?>
    <main class="main-content">
        <header class="top-navbar">

            <div class="navbar-left">
                <button
                    class="sidebar-toggle"
                    id="sidebarToggle"
                    type="button"
                    aria-label="Basculer le menu"
                    aria-expanded="true"
                >
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M4 6h16M4 12h16M4 18h16"
                              fill="none"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"/>
                    </svg>
                </button>

                <div class="page-title">
                    <h1><?php echo $pageTitle ?? 'Tableau de Bord'; ?></h1>
                </div>
            </div>

            <div class="user-menu" id="userMenu">

                <button
                    class="user-profile"
                    id="userProfile"
                    type="button"
                    aria-expanded="false"
                    aria-haspopup="true"
                >
                    <span class="user-avatar">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="8" r="4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"/>
                            <path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"
                                  fill="none"
                                  stroke="currentColor"
                                  stroke-width="2"
                                  stroke-linecap="round"/>
                        </svg>
                    </span>

                    <span class="username">Administrateur</span>

                    <svg class="chevron-icon" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="m6 9 6 6 6-6"
                              fill="none"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </button>

                <div class="profile-dropdown" id="profileDropdown">

                    <a href="/smart-auto-ecole/public/profile" class="dropdown-item">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="8" r="4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"/>
                            <path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"
                                  fill="none"
                                  stroke="currentColor"
                                  stroke-width="2"
                                  stroke-linecap="round"/>
                        </svg>
                        <span>Mon Profil</span>
                    </a>

                    <a href="/smart-auto-ecole/public/logout" class="dropdown-item" style="color: var(--danger);">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M10 17l5-5-5-5"
                                  fill="none"
                                  stroke="currentColor"
                                  stroke-width="2"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M15 12H3"
                                  fill="none"
                                  stroke="currentColor"
                                  stroke-width="2"
                                  stroke-linecap="round"/>
                            <path d="M21 3v18"
                                  fill="none"
                                  stroke="currentColor"
                                  stroke-width="2"
                                  stroke-linecap="round"/>
                        </svg>
                        <span>Déconnexion</span>
                    </a>

                </div>
            </div>

        </header>

        <section class="page-content">