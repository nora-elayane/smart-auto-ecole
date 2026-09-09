class TableActionsManager {
  constructor() {
    this.container = document.querySelector(".table-container");
    if (!this.container) return;

    this.tableRows = this.container.querySelectorAll("tbody tr");
    this.selectAll = this.container.querySelector("#selectAll");
    this.actionBar = document.getElementById("actionBar");
    this.selectedCount = document.getElementById("selectedCount");

    this.btnEdit = document.getElementById("btnEdit");
    this.btnDelete = document.getElementById("btnDelete");
    this.btnArchive = document.getElementById("btnArchive");
    this.btnActivate = document.getElementById("btnActivate");
    this.btnPrintDropdown = document.getElementById("btnPrintDropdown");
    this.printMenu = document.getElementById("printMenu");

    this.init();
  }

  init() {
    this.bindRowClicks();
    this.bindSelectAll();
    this.bindOutsideClick();
    this.bindKeyboardEsc();
    this.bindPrintDropdown();
    this.bindPrintActions();
    this.bindDynamicActions();
  }

  updateToolbar() {
    const checkedBoxes = this.container.querySelectorAll(".select-row:checked");
    const count = checkedBoxes.length;

    // Highlighting
    this.container.querySelectorAll(".select-row").forEach((cb) => {
      const row = cb.closest("tr");
      if (row) row.classList.toggle("selected-row", cb.checked);
    });

    if (count > 0) {
      if (this.selectedCount)
        this.selectedCount.textContent = `${count} sélectionné(s)`;
      if (this.actionBar) this.actionBar.classList.add("show");

      const selectedEtats = Array.from(checkedBoxes).map((cb) => {
        const row = cb.closest("tr");
        return row ? row.dataset.etat : null;
      });

      const hasActif = selectedEtats.includes("actif");
      const hasInactif =
        selectedEtats.includes("archivé") || selectedEtats.includes("inactif");

      if (this.btnEdit) {
        if (count > 1) {
          this.btnEdit.disabled = true;
          this.btnEdit.title = "Sélectionnez un seul élément pour l'éditer";
        } else {
          this.btnEdit.disabled = false;
          this.btnEdit.title = "";
        }
      }

      if (this.btnArchive) {
        this.btnArchive.style.display = hasActif ? "inline-flex" : "none";
        this.btnArchive.innerHTML =
          count > 1
            ? `<i class="bi bi-archive"></i> Archiver (${count})`
            : `<i class="bi bi-archive"></i> Archiver`;
      }

      if (this.btnActivate) {
        this.btnActivate.style.display = hasInactif ? "inline-flex" : "none";
        this.btnActivate.innerHTML =
          count > 1
            ? `<i class="bi bi-check-circle"></i> Activer (${count})`
            : `<i class="bi bi-check-circle"></i> Activer`;
      }

      if (this.btnDelete) {
        this.btnDelete.innerHTML =
          count > 1
            ? `<i class="bi bi-trash"></i> Supprimer (${count})`
            : `<i class="bi bi-trash"></i> Supprimer`;
      }
    } else {
      if (this.actionBar) this.actionBar.classList.remove("show");
      if (this.selectAll) this.selectAll.checked = false;
      if (this.printMenu) this.printMenu.classList.remove("active");
    }
  }

  bindRowClicks() {
    this.tableRows.forEach((row) => {
      row.addEventListener("click", (e) => {
        if (
          e.target.closest(
            "a, button, input, .dropdown-wrapper, .custom-dropdown-menu",
          )
        )
          return;

        const checkbox = row.querySelector(".select-row");
        if (checkbox) {
          if (e.target !== checkbox) checkbox.checked = !checkbox.checked;
          this.updateToolbar();
        }
      });
    });
  }

  bindSelectAll() {
    if (this.selectAll) {
      this.selectAll.addEventListener("change", (e) => {
        this.container
          .querySelectorAll(".select-row")
          .forEach((cb) => (cb.checked = e.target.checked));
        this.updateToolbar();
      });
    }
  }

  bindOutsideClick() {
    document.addEventListener("click", (e) => {
      if (
        !this.container.contains(e.target) &&
        !e.target.closest(".custom-dropdown-menu")
      ) {
        this.clearSelection();
      }
    });
  }

  bindKeyboardEsc() {
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") this.clearSelection();
    });
  }

  bindPrintDropdown() {
    if (this.btnPrintDropdown && this.printMenu) {
      this.btnPrintDropdown.addEventListener("click", (e) => {
        e.stopPropagation();
        this.printMenu.classList.toggle("active");
      });

      document.addEventListener("click", (e) => {
        if (
          !this.printMenu.contains(e.target) &&
          e.target !== this.btnPrintDropdown
        ) {
          this.printMenu.classList.remove("active");
        }
      });
    }
  }

  bindPrintActions() {
    document.querySelectorAll(".print-action").forEach((btn) => {
      btn.addEventListener("click", (e) => {
        e.preventDefault();
        const ids = this.getSelectedIds();
        if (ids.length === 0) return;

        const printType = btn.dataset.type;
        const baseUrl =
          btn.getAttribute("data-action-url") ||
          "/smart-auto-ecole/public/candidates/contrats/print";
        window.open(
          `${baseUrl}?type=${printType}&ids=${ids.join(",")}`,
          "_blank",
        );
      });
    });
  }

  bindDynamicActions() {
    // 1. Éditer
    if (this.btnEdit) {
      this.btnEdit.addEventListener("click", () => {
        const ids = this.getSelectedIds();
        const baseUrl = this.btnEdit.getAttribute("data-action-url");
        if (ids.length !== 1 || !baseUrl) return;
        window.location.href = `${baseUrl}?id=${ids[0]}`;
      });
    }

    // 2. Archiver
    if (this.btnArchive) {
      this.btnArchive.addEventListener("click", () => {
        this.handleBulkAction(
          this.btnArchive,
          "Voulez-vous vraiment archiver la sélection ?",
        );
      });
    }

    // 3. Activer
    if (this.btnActivate) {
      this.btnActivate.addEventListener("click", () => {
        this.handleBulkAction(
          this.btnActivate,
          "Voulez-vous vraiment réactiver la sélection ?",
        );
      });
    }

    // 4. Supprimer
    if (this.btnDelete) {
      this.btnDelete.addEventListener("click", () => {
        this.handleBulkAction(
          this.btnDelete,
          "Attention ! Voulez-vous supprimer définitivement la sélection ?",
        );
      });
    }
  }

  handleBulkAction(buttonElement, confirmMessage) {
    const ids = this.getSelectedIds();
    const baseUrl = buttonElement.getAttribute("data-action-url");
    if (ids.length === 0 || !baseUrl) return;

    if (confirm(confirmMessage)) {
      window.location.href = `${baseUrl}?ids=${ids.join(",")}`;
    }
  }

  getSelectedIds() {
    return Array.from(
      this.container.querySelectorAll(".select-row:checked"),
    ).map((cb) => cb.value);
  }

  clearSelection() {
    this.container
      .querySelectorAll(".select-row")
      .forEach((cb) => (cb.checked = false));
    if (this.selectAll) this.selectAll.checked = false;
    this.updateToolbar();
  }
}

document.addEventListener("DOMContentLoaded", () => {
  window.tableApp = new TableActionsManager();
});
