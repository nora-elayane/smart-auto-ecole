<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<main class="main-content">
    <div class="page-content">

        <div class="card-header" style="margin-bottom: 24px;">
            <div>
                <h1 style="font-size: 20px; font-weight: 700;"><?php echo $pageTitle ?? 'Modifier la Véhicule'; ?></h1>
                <p class="card-description">Mettre à jour les informations de la véhicule.</p>
            </div>
            <a href="<?php echo $backUrl ?? '/smart-auto-ecole/public/vehicules'; ?>" class="btn btn-secondary">
                Retour
            </a>
        </div>

        <div class="card" style="max-width: 900px; margin: 0 auto;">
            <form action="<?php echo $formAction ?? '/smart-auto-ecole/public/vehicules/update'; ?>" method="POST" id="vehiculeForm">
                
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($vehicule['id_vehicule'] ?? ''); ?>">

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                    <div class="form-group">
                        <label class="form-label" for="immatriculation">Immatriculation <span style="color: var(--danger);">*</span></label>
                        <input type="text" id="immatriculation" name="immatriculation" class="form-control" value="<?php echo htmlspecialchars($vehicule['immatriculation'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="marque">Marque <span style="color: var(--danger);">*</span></label>
                        <input type="text" id="marque" name="marque" class="form-control" value="<?php echo htmlspecialchars($vehicule['marque'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="modele">Modèle <span style="color: var(--danger);">*</span></label>
                        <input type="text" id="modele" name="modele" class="form-control" value="<?php echo htmlspecialchars($vehicule['modele'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="etat">Statut / État</label>
                        <select id="etat" name="etat" class="form-control">
                            <option value="Disponible" <?php echo (($vehicule['etat'] ?? '') === 'Disponible') ? 'selected' : ''; ?>>Disponible</option>
                            <option value="Maintenance" <?php echo (($vehicule['etat'] ?? '') === 'Maintenance') ? 'selected' : ''; ?>>Maintenance</option>
                            <option value="En panne" <?php echo (($vehicule['etat'] ?? '') === 'En panne') ? 'selected' : ''; ?>>En panne</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="date_assurance">Date Fin Assurance</label>
                        <input type="date" id="date_assurance" name="date_assurance" class="form-control" value="<?php echo htmlspecialchars($vehicule['date_assurance'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="date_visite_technique">Date Visite Technique</label>
                        <input type="date" id="date_visite_technique" name="date_visite_technique" class="form-control" value="<?php echo htmlspecialchars($vehicule['date_visite_technique'] ?? ''); ?>">
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
                    <a href="<?php echo $backUrl ?? '/smart-auto-ecole/public/vehicules'; ?>" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('vehiculeForm');

    function showError(input, message) {
        input.style.borderColor = 'var(--danger)';
        
        let errorEl = input.parentElement.querySelector('.error-message');
        if (!errorEl) {
            errorEl = document.createElement('span');
            errorEl.className = 'error-message';
            errorEl.style.color = 'var(--danger)';
            errorEl.style.fontSize = '12px';
            errorEl.style.marginTop = '4px';
            errorEl.style.display = 'block';
            input.parentElement.appendChild(errorEl);
        }
        errorEl.textContent = message;
    }

    function clearError(input) {
        input.style.borderColor = '';
        const errorEl = input.parentElement.querySelector('.error-message');
        if (errorEl) {
            errorEl.remove();
        }
    }

    function validateField(input) {
        clearError(input);
        let isValid = true;
        const val = input.value.trim();

        switch (input.id) {
            case 'immatriculation':
                if (val.length < 3) {
                    showError(input, 'L\'immatriculation doit contenir au moins 3 caractères.');
                    isValid = false;
                } else if (val.length > 20) {
                    showError(input, 'L\'immatriculation ne doit pas dépasser 20 caractères.');
                    isValid = false;
                }
                break;

            case 'marque':
                if (val.length < 2) {
                    showError(input, 'La marque doit contenir au moins 2 caractères.');
                    isValid = false;
                } else if (val.length > 50) {
                    showError(input, 'La marque ne doit pas dépasser 50 caractères.');
                    isValid = false;
                }
                break;

            case 'modele':
                if (val.length < 1) {
                    showError(input, 'Le modèle est obligatoire.');
                    isValid = false;
                } else if (val.length > 50) {
                    showError(input, 'Le modèle ne doit pas dépasser 50 caractères.');
                    isValid = false;
                }
                break;
        }

        return isValid;
    }

    const inputs = form.querySelectorAll('.form-control');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function () {
            validateField(this);
        });

        input.addEventListener('input', function () {
            clearError(this);
        });
    });

    form.addEventListener('submit', function (e) {
        let isFormValid = true;

        inputs.forEach(input => {
            const isInputValid = validateField(input);
            if (!isInputValid) {
                isFormValid = false;
            }
        });

        if (!isFormValid) {
            e.preventDefault();
        }
    });
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>