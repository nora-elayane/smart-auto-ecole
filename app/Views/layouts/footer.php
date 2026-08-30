<!-- footer.html -->

        </section>
        <!-- End Page Content -->

        <!-- Footer -->
        <footer class="main-footer">
            <p>© 2026 Smart Auto-École - All Rights Reserved</p>
        </footer>

    </main>
    <!-- End Main Content -->

</div>
<!-- End App Layout -->


<script>
    document.addEventListener("DOMContentLoaded", function () {

        const sidebar = document.getElementById("sidebar");
        const sidebarToggle = document.getElementById("sidebarToggle");

        const userProfile = document.getElementById("userProfile");
        const profileDropdown = document.getElementById("profileDropdown");
        const userMenu = document.getElementById("userMenu");

        /*
         * Sidebar Toggle
         */
        if (sidebar && sidebarToggle) {
            sidebarToggle.addEventListener("click", function () {

                const isCollapsed = sidebar.classList.toggle("collapsed");

                sidebarToggle.setAttribute(
                    "aria-expanded",
                    String(!isCollapsed)
                );

            });
        }

        /*
         * Profile Dropdown
         */
        if (userProfile && profileDropdown) {
            userProfile.addEventListener("click", function (event) {

                event.stopPropagation();

                const isOpen =
                    profileDropdown.classList.toggle("show");

                userProfile.setAttribute(
                    "aria-expanded",
                    String(isOpen)
                );

            });
        }

        /*
         * Close dropdown when clicking outside
         */
        document.addEventListener("click", function (event) {

            if (
                userMenu &&
                !userMenu.contains(event.target)
            ) {
                profileDropdown.classList.remove("show");

                if (userProfile) {
                    userProfile.setAttribute(
                        "aria-expanded",
                        "false"
                    );
                }
            }

        });

        /*
         * Close dropdown with Escape
         */
        document.addEventListener("keydown", function (event) {

            if (event.key === "Escape") {

                profileDropdown.classList.remove("show");

                if (userProfile) {
                    userProfile.setAttribute(
                        "aria-expanded",
                        "false"
                    );
                }

            }

        });

        /*
         * Navigation Active State
         */
        const navLinks = document.querySelectorAll(".nav-link");

        navLinks.forEach(function (link) {

            link.addEventListener("click", function () {

                navLinks.forEach(function (item) {
                    item.parentElement.classList.remove("active");
                });

                link.parentElement.classList.add("active");

            });

        });

    });
</script>