<!-- header.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/smart-auto-ecole/public/css/style.css">
</head>
<body>
    

<div class="app-layout">

    <!-- Main Content Wrapper -->
    <main class="main-content">

        <!-- Top Navigation -->
        <header class="top-navbar">

            <div class="navbar-left">
                <button
                    class="sidebar-toggle"
                    id="sidebarToggle"
                    type="button"
                    aria-label="Toggle sidebar"
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
                    <h1>Dashboard</h1>
                </div>
            </div>

            <!-- User Profile -->
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

                    <span class="username">Admin User</span>

                    <svg class="chevron-icon" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="m6 9 6 6 6-6"
                              fill="none"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </button>

                <!-- Static Dropdown -->
                <div class="profile-dropdown" id="profileDropdown">

                    <a href="#" class="dropdown-item">
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
                        <span>Profile</span>
                    </a>

                    <a href="#" class="dropdown-item">
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
                        <span>Logout</span>
                    </a>

                </div>
            </div>

        </header>

        <!-- Page Content Starts Here -->
        <section class="page-content">
            </body>
</html>