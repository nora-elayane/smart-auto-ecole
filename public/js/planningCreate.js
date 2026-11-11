/* =========================================================
   Smart Auto-École — Planning : formulaire "Programmer une séance"
   ========================================================= */
(function () {
  "use strict";

  const C = window.PLANNING_CREATE || {};
  const $ = (id) => document.getElementById(id);
  const esc = (s) =>
    String(s ?? "").replace(
      /[&<>"']/g,
      (c) =>
        ({
          "&": "&amp;",
          "<": "&lt;",
          ">": "&gt;",
          '"': "&quot;",
          "'": "&#39;",
        })[c],
    );

  /* ---------- Toast (toast.css) ---------- */
  function showToast(type, msg) {
    type = type === "error" ? "danger" : type || "info";
    const t = document.createElement("div");
    t.className = "custom-toast toast-" + type;
    t.innerHTML =
      '<span class="toast-indicator"></span><span>' + esc(msg) + "</span>";
    document.body.appendChild(t);
    setTimeout(() => t.classList.add("toast-hide"), 3500);
    setTimeout(() => t.remove(), 4000);
  }
  if (C.flash && C.flash.message) showToast(C.flash.type, C.flash.message);

  const form = $("createForm");
  const fDebut = $("fDebut"),
    fFin = $("fFin"),
    fMon = $("fMon"),
    fVeh = $("fVeh");
  const errorBox = $("createError");

  /* ---------- Type : le véhicule n'existe que pour la Conduite ---------- */
  function syncType() {
    const conduite =
      document.querySelector('input[name="type"]:checked').value === "Conduite";
    $("vehGroup").style.display = conduite ? "" : "none";
    fVeh.disabled = !conduite; // un champ désactivé n'est pas envoyé
    if (!conduite) fVeh.value = "";
    fVeh.required = conduite;
    fMon.required = true; // id_moniteur est obligatoire en base
  }
  document
    .querySelectorAll('input[name="type"]')
    .forEach((r) => r.addEventListener("change", syncType));
  syncType();

  /* ---------- Heure de fin par défaut = début + 1h ---------- */
  fDebut.addEventListener("change", () => {
    if (!fDebut.value || fFin.value) return;
    const [h, m] = fDebut.value.split(":").map(Number);
    fFin.value =
      String((h + 1) % 24).padStart(2, "0") + ":" + String(m).padStart(2, "0");
  });

  /* ---------- Validation côté client ---------- */
  form.addEventListener("submit", (e) => {
    if (fDebut.value && fFin.value && fFin.value <= fDebut.value) {
      e.preventDefault();
      errorBox.textContent =
        "L'heure de fin doit être postérieure à l'heure de début.";
      errorBox.style.display = "block";
      fFin.focus();
    }
  });

  /* ---------- Candidats : filtre par catégorie de permis + recherche + compteur (création seulement) ---------- */
  const pickList = $("pickList");
  if (pickList) {
    const catFilter = $("catFilter"),
      pickSearch = $("pickSearch");

    function updateCount() {
      const n = pickList.querySelectorAll("input:checked").length;
      $("pickCount").textContent =
        n +
        " candidat" +
        (n > 1 ? "s" : "") +
        " sélectionné" +
        (n > 1 ? "s" : "");
    }
    function filterPick() {
      const q = pickSearch.value.trim().toLowerCase();
      const cat = catFilter.value;
      pickList.querySelectorAll("label").forEach((l) => {
        const ok =
          (!cat || l.dataset.cat === cat) &&
          (!q || (l.dataset.search || "").includes(q));
        l.style.display = ok ? "" : "none";
      });
    }
    catFilter.addEventListener("change", () => {
      // on décoche les candidats d'une autre catégorie pour ne pas les envoyer sans les voir
      if (catFilter.value) {
        pickList.querySelectorAll("label").forEach((l) => {
          if (l.dataset.cat !== catFilter.value)
            l.querySelector("input").checked = false;
        });
      }
      filterPick();
      updateCount();
    });
    pickSearch.addEventListener("input", filterPick);
    pickList.addEventListener("change", updateCount);
    updateCount();
  }
})();
