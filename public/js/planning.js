/* =========================================================
   Smart Auto-École — Module Planning (JS)
   Configuration fournie par la vue : window.PLANNING
   ========================================================= */
(function () {
  "use strict";

  const C = window.PLANNING || {};
  const BASE = C.base || "";
  const SEANCES = C.seances || {};
  const CANDIDATS = C.candidats || [];
  const GRID_START = C.gridStart || 0;
  const TODAY = C.today || "";
  const CAN_MANAGE = !!C.canManage;
  const CAN_VALIDATE = !!C.canValidate;
  const IS_CANDIDAT = !!C.isCandidat;

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
  const initials = (n, p) =>
    ((n || "?").charAt(0) + (p || "").charAt(0)).toUpperCase();
  const pad = (n) => String(n).padStart(2, "0");
  const presenceClass = (p) =>
    p === "Présent" ? "p-present" : p === "Absent" ? "p-absent" : "p-attente";

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

  /* ---------- Confirmations (formulaires data-confirm, y compris dynamiques) ---------- */
  document.addEventListener("submit", (e) => {
    const msg = e.target.getAttribute && e.target.getAttribute("data-confirm");
    if (msg && !confirm(msg)) e.preventDefault();
  });

  /* ---------- Bascule Semaine / Liste ---------- */
  const viewWeek = $("viewWeek"),
    viewList = $("viewList"),
    weekNav = $("weekNav");
  function setView(v) {
    viewWeek.style.display = v === "week" ? "block" : "none";
    viewList.style.display = v === "list" ? "block" : "none";
    weekNav.style.visibility = v === "week" ? "visible" : "hidden";
    document
      .querySelectorAll("#viewSwitch button")
      .forEach((b) => b.classList.toggle("active", b.dataset.view === v));
    try {
      localStorage.setItem("planningView", v);
    } catch (e) {}
  }
  document
    .querySelectorAll("#viewSwitch button")
    .forEach((b) => b.addEventListener("click", () => setView(b.dataset.view)));
  let savedView = "week";
  try {
    savedView = localStorage.getItem("planningView") || "week";
  } catch (e) {}
  if (window.innerWidth < 768) savedView = "list";
  setView(savedView);

  /* ---------- Clics : séance / créneau vide ---------- */
  document.querySelectorAll(".pl-ev").forEach((el) =>
    el.addEventListener("click", (e) => {
      e.stopPropagation();
      openDrawer(el.dataset.id);
    }),
  );
  document
    .querySelectorAll("#listTable tbody tr[data-id]")
    .forEach((tr) =>
      tr.addEventListener("click", () => openDrawer(tr.dataset.id)),
    );
  if (CAN_MANAGE) {
    document.querySelectorAll(".pl-col").forEach((col) =>
      col.addEventListener("click", (e) => {
        if (e.target !== col) return;
        const mins = GRID_START + Math.floor(e.offsetY / 30) * 30;
        const t = (m) => pad(Math.floor(m / 60) % 24) + ":" + pad(m % 60);
        window.location.href =
          BASE +
          "/planning/create?date=" +
          col.dataset.date +
          "&debut=" +
          t(mins) +
          "&fin=" +
          t(mins + 60);
      }),
    );
  }

  /* ---------- Filtres de la liste ---------- */
  function filterList() {
    const t = $("fType").value;
    const q = $("fSearch").value.trim().toLowerCase();
    document.querySelectorAll("#listTable tbody tr[data-id]").forEach((tr) => {
      const ok =
        (!t || tr.dataset.type === t) &&
        (!q || tr.textContent.toLowerCase().includes(q));
      tr.style.display = ok ? "" : "none";
    });
  }
  $("fType").addEventListener("change", filterList);
  $("fSearch").addEventListener("input", filterList);

  /* =======================================================
     TIROIR : détails d'une séance
     ======================================================= */
  const drawer = $("drawer"),
    overlay = $("drawerOverlay");

  function candidateCard(s, p, canEditPresence) {
    let h =
      '<div class="pl-cand"><div class="pl-cand-top">' +
      '<div class="pl-av">' +
      esc(initials(p.nom, p.prenom)) +
      "</div>" +
      '<div class="grow"><div class="pl-cand-name">' +
      esc(p.nom + " " + p.prenom) +
      "</div>" +
      '<div class="pl-cand-sub">' +
      esc(p.num) +
      (p.tel ? " · " + esc(p.tel) : "") +
      "</div></div>" +
      '<span class="pl-badge ' +
      presenceClass(p.presence) +
      '">' +
      esc(p.presence) +
      "</span>";

    if (CAN_MANAGE) {
      h +=
        '<form action="' +
        BASE +
        '/planning/removeParticipant" method="POST" data-confirm="Retirer ce candidat de la séance ?">' +
        '<input type="hidden" name="id_participation" value="' +
        esc(p.id_participation) +
        '">' +
        '<button type="submit" class="pl-rm" title="Retirer">&times;</button></form>';
    }
    h += "</div>";

    if (canEditPresence) {
      h +=
        '<form class="pl-cand-form" action="' +
        BASE +
        '/planning/updatePresence" method="POST">' +
        '<input type="hidden" name="id_participation" value="' +
        esc(p.id_participation) +
        '">' +
        '<select name="presence" class="form-control">' +
        ["En attente", "Présent", "Absent"]
          .map(
            (o) =>
              "<option" +
              (o === p.presence ? " selected" : "") +
              ">" +
              o +
              "</option>",
          )
          .join("") +
        "</select>" +
        '<input type="text" name="remarque" class="form-control" maxlength="255" placeholder="Remarque…" value="' +
        esc(p.remarque) +
        '">' +
        '<button type="submit" class="btn btn-primary pl-mini" title="Enregistrer">✓</button></form>';
    } else if (p.remarque) {
      h += '<div class="pl-cand-note">' + esc(p.remarque) + "</div>";
    }
    return h + "</div>";
  }

  function validateBox(s) {
    if (!CAN_VALIDATE || !s.mine) return "";
    if (s.date > TODAY) {
      return '<div class="pl-help" style="margin-top:16px;">La validation sera possible à partir du jour de la séance.</div>';
    }
    const done = s.statut === "Réalisée";
    return (
      '<form class="pl-validate" action="' +
      BASE +
      '/planning/validate" method="POST">' +
      '<div class="pl-sec-title"><span>' +
      (done ? "Séance validée" : "Valider la séance") +
      "</span></div>" +
      '<input type="hidden" name="id_seance" value="' +
      esc(s.id) +
      '">' +
      '<textarea name="remarque" class="form-control" maxlength="500" placeholder="Remarque sur la séance (optionnel)…">' +
      esc(s.remarque) +
      "</textarea>" +
      '<button type="submit" class="btn btn-primary">' +
      (done
        ? "Mettre à jour la validation"
        : "✓ Confirmer que la séance a été réalisée") +
      "</button>" +
      "</form>"
    );
  }

  function openDrawer(id) {
    const s = SEANCES[id];
    if (!s) return;
    const isCode = s.type === "Code";
    const done = s.statut === "Réalisée";
    const canEditPresence = CAN_VALIDATE && s.mine && s.date <= TODAY;

    $("dBadge").innerHTML =
      '<span class="pl-badge ' +
      (isCode ? "code" : "conduite") +
      '">' +
      esc(s.type) +
      "</span> " +
      '<span class="pl-badge ' +
      (done ? "done" : "planned") +
      '">' +
      esc(s.statut) +
      "</span>";
    $("dTitle").textContent = "Séance #" + s.id;
    $("dSub").textContent = s.dateFr + " · " + s.debut + " – " + s.fin;
    const delId = $("dDeleteId");
    if (delId) delId.value = s.id;
    const editLink = $("dEditLink");
    if (editLink) {
      // modification impossible une fois la séance réalisée
      editLink.href = BASE + "/planning/edit?id=" + s.id;
      editLink.style.display = done ? "none" : "";
    }

    let html =
      '<div class="pl-info">' +
      "<div><small>Moniteur</small><span>" +
      (s.moniteur
        ? esc(s.moniteur)
        : '<span class="pl-dash">Non assigné</span>') +
      "</span></div>" +
      "<div><small>Véhicule</small><span>" +
      (s.vehicule ? esc(s.vehicule) : '<span class="pl-dash">—</span>') +
      "</span></div>" +
      "</div>";

    if (done && !CAN_VALIDATE) {
      html +=
        '<div class="pl-note"><strong>Séance réalisée.</strong>' +
        (s.remarque ? " " + esc(s.remarque) : "") +
        "</div>";
    }

    if (IS_CANDIDAT) {
      html +=
        '<div class="pl-sec-title"><span>Ma présence</span>' +
        '<span class="pl-badge ' +
        presenceClass(s.maPresence) +
        '">' +
        esc(s.maPresence || "En attente") +
        "</span></div>";
      if (s.maRemarque)
        html += '<div class="pl-cand-note">' + esc(s.maRemarque) + "</div>";
    } else {
      const taken = new Set(s.participants.map((p) => String(p.id_contrat)));
      const available = CANDIDATS.filter((c) => !taken.has(String(c.id)));

      html +=
        '<div class="pl-sec-title"><span>Candidats</span><em>' +
        s.participants.length +
        " inscrit" +
        (s.participants.length > 1 ? "s" : "") +
        "</em></div>";
      if (!s.participants.length)
        html +=
          '<div class="pl-no-cand">Aucun candidat inscrit à cette séance.</div>';
      s.participants.forEach((p) => {
        html += candidateCard(s, p, canEditPresence);
      });

      if (CAN_MANAGE && done) {
        html +=
          "<div class=\"pl-help\">Séance réalisée : l'ajout de candidats n'est plus possible.</div>";
      } else if (CAN_MANAGE) {
        if (available.length) {
          html +=
            '<form class="pl-add-box" action="' +
            BASE +
            '/planning/addParticipant" method="POST">' +
            '<input type="hidden" name="id_seance" value="' +
            esc(s.id) +
            '">' +
            '<select name="id_contrat" class="form-control" required>' +
            '<option value="">+ Ajouter un candidat…</option>' +
            available
              .map(
                (c) =>
                  '<option value="' +
                  esc(c.id) +
                  '">' +
                  esc(
                    c.nom + " " + c.prenom + (c.num ? " (" + c.num + ")" : ""),
                  ) +
                  "</option>",
              )
              .join("") +
            '</select><button type="submit" class="btn btn-primary">Ajouter</button></form>';
        } else if (!CANDIDATS.length) {
          html +=
            '<div class="pl-help">Aucun candidat (contrat en cours) disponible à ajouter.</div>';
        }
      }
      html += validateBox(s);
    }

    $("dBody").innerHTML = html;
    drawer.classList.add("open");
    overlay.classList.add("open");
    drawer.setAttribute("aria-hidden", "false");
    document.body.style.overflow = "hidden";
  }

  function closeDrawer() {
    drawer.classList.remove("open");
    overlay.classList.remove("open");
    drawer.setAttribute("aria-hidden", "true");
    document.body.style.overflow = "";
  }
  overlay.addEventListener("click", closeDrawer);
  document
    .querySelectorAll("[data-close-drawer]")
    .forEach((b) => b.addEventListener("click", closeDrawer));

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      closeDrawer();
    }
  });

  /* ---------- Réouverture automatique après une action (?open=ID) ---------- */
  if (C.openId) openDrawer(String(C.openId));
})();
