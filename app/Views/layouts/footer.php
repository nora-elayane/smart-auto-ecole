</section>
        <!-- End Page Content Area -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <p>&copy; <?php echo date('Y'); ?> <strong>Smart Auto-École</strong>. Tous droits réservés.</p>
        </footer>

    </main>
    <!-- End Main Content Wrapper -->

</div>
<!-- End App Layout -->

<!-- JS Scripts -->
<script>
    // Toggle Sidebar
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            const isCollapsed = sidebar.classList.contains('collapsed');
            sidebarToggle.setAttribute('aria-expanded', !isCollapsed);
        });
    }

    // Toggle User Profile Dropdown
    const userProfile = document.getElementById('userProfile');
    const profileDropdown = document.getElementById('profileDropdown');

    if (userProfile && profileDropdown) {
        userProfile.addEventListener('click', (e) => {
            e.stopPropagation();
            profileDropdown.classList.toggle('show');
            const isExpanded = profileDropdown.classList.contains('show');
            userProfile.setAttribute('aria-expanded', isExpanded);
        });

        document.addEventListener('click', () => {
            if (profileDropdown.classList.contains('show')) {
                profileDropdown.classList.remove('show');
                userProfile.setAttribute('aria-expanded', 'false');
            }
        });
    }
</script>

</body>
</html>