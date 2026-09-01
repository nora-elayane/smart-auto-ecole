<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<main class="main-content">
    <div class="page-content">

        <div class="card-header" style="margin-bottom: 24px;">
            <div>
                <h1 style="font-size: 20px; font-weight: 700;"><?php echo $pageTitle ?? 'Nouveau Utilisateur'; ?></h1>
                <p class="card-description">Remplissez les informations ci-dessous.</p>
            </div>
            <a href="<?php echo $backUrl ?? '/smart-auto-ecole/public/dashboard'; ?>" class="btn btn-secondary">
                Retour
            </a>
        </div>

        <div class="card" style="max-width: 900px; margin: 0 auto;">
            <form action="<?php echo $formAction; ?>" method="POST" enctype="multipart/form-data" id="studentForm">
                
                <input type="hidden" name="id_role" value="<?php echo $roleId; ?>">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($student['id_user']); ?>">

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                    <div class="form-group">
                        <label class="form-label" for="nom">Nom <span style="color: var(--danger);">*</span></label>
                        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($student['nom'] ?? '-'); ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="prenom">Prénom <span style="color: var(--danger);">*</span></label>
                        <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($student['prenom'] ?? '-'); ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="cin">N° CIN <span style="color: var(--danger);">*</span></label>
                        <input type="text" id="cin" name="cin" value="<?php echo htmlspecialchars($student['cin'] ?? '-'); ?>" class="form-control" required style="text-transform: uppercase;">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="date_naissance">Date de Naissance <span style="color: var(--danger);">*</span></label>
                        <input type="date" id="date_naissance" name="date_naissance" value="<?php echo htmlspecialchars($student['date_naissance'] ?? '-'); ?>" class="form-control" required>                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Adresse Email <span style="color: var(--danger);">*</span></label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email'] ?? '-'); ?>" class="form-control" required>
                    </div>

                   <div class="form-group">
    <label for="mot_de_passe" class="form-label">Nouveau mot de passe</label>
    <input type="password" id="mot_de_passe" name="mot_de_passe" class="form-control" placeholder="••••••••">
    <small style="color: var(--text-secondary, #666); display: block; margin-top: 4px;">
        Laissez ce champ vide pour conserver le mot de passe actuel.
    </small>
    
    <!-- حقل مخفي تحتفظي فيه بالباسوورد القديم المشفر (Hash) اللي جايباه من الموديل -->
    <input type="hidden" name="oldmot" value="<?php echo htmlspecialchars($student['mot_de_passe'] ?? ''); ?>">
</div>

                    <div class="form-group">
                        <label class="form-label" for="telephone">Téléphone <span style="color: var(--danger);">*</span></label>
                        <input type="tel" id="telephone" name="telephone" value="<?php echo htmlspecialchars($student['telephone'] ?? '-'); ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="etat">Statut</label>
                        <select id="etat" name="etat" value="<?php echo htmlspecialchars($student['etat'] ?? '-'); ?>" class="form-control">
                            <option value="Actif" selected>Actif</option>
                            <option value="Inactif">Inactif</option>
                        </select>
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label class="form-label" for="adresse">Adresse</label>
                        <input type="text" id="adresse" value="<?php echo htmlspecialchars($student['adress'] ?? '-'); ?>" name="adresse" class="form-control">
                    </div>

                  <div class="form-group" style="grid-column: span 2;">
    <label class="form-label">Photo de Profil</label>
    
    <div style="display: flex; align-items: center; gap: 16px; margin-top: 8px;">
        <div id="avatarPreview" style="width: 64px; height: 64px; border-radius: 50%; overflow: hidden; background: var(--bg-secondary, #f0f0f0); display: flex; align-items: center; justify-content: center; border: 2px solid var(--border-color, #e0e0e0); flex-shrink: 0;">
            <?php 
            $imagePath = __DIR__ . '/../../../public/uploads/' . $student['photo'];
            if (!empty($student['photo']) && file_exists($imagePath)): 
            ?>
                <img src="/smart-auto-ecole/public/uploads/<?php echo htmlspecialchars($student['photo']); ?>" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
            <?php else: ?>
                <span style="font-weight: 700; font-size: 20px; color: var(--text-secondary, #666);">
                    <?php echo strtoupper(substr($student['nom'] ?? 'C', 0, 1)); ?>
                </span>
            <?php endif; ?>
        </div>

        <div style="flex: 1;">
            <input type="file" id="photo" name="photo" class="form-control" accept="image/png, image/jpeg, image/jpg">
            
            <input type="hidden" id="oldphoto" name="oldphoto" value="<?php echo htmlspecialchars($student['photo'] ?? ''); ?>">
            
            <small style="color: var(--text-secondary, #666); display: block; margin-top: 6px;">
                Laissez ce champ vide pour conserver la photo actuelle.
            </small>
        </div>
    </div>
</div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    document.getElementById('photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatarPreview');
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">`;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('studentForm');

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
            case 'nom':
                if (val.length < 2) {
                    showError(input, 'Le nom doit contenir au moins 2 caractères.');
                    isValid = false;
                } else if (val.length > 50) {
                    showError(input, 'Le nom ne doit pas dépasser 50 caractères.');
                    isValid = false;
                }
                break;

            case 'prenom':
                if (val.length < 2) {
                    showError(input, 'Le prénom doit contenir au moins 2 caractères.');
                    isValid = false;
                } else if (val.length > 50) {
                    showError(input, 'Le prénom ne doit pas dépasser 50 caractères.');
                    isValid = false;
                }
                break;

            case 'cin':
                const cinRegex = /^[A-Z]{1,2}[0-9]{5,6}$/i;
                if (!cinRegex.test(val)) {
                    showError(input, 'Format CIN invalide (ex: AB123456).');
                    isValid = false;
                } else if (val.length > 20) {
                    showError(input, 'Le CIN ne doit pas dépasser 20 caractères.');
                    isValid = false;
                }
                break;

            case 'date_naissance':
                if (!val) {
                    showError(input, 'La date de naissance est obligatoire.');
                    isValid = false;
                } else {
                    const birthDate = new Date(val);
                    const today = new Date();
                    let age = today.getFullYear() - birthDate.getFullYear();
                    const monthDiff = today.getMonth() - birthDate.getMonth();
                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }
                    if (age < 18) {
                        showError(input, 'Le candidat doit avoir au moins 18 ans.');
                        isValid = false;
                    }
                }
                break;

            case 'email':
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(val)) {
                    showError(input, 'Veuillez entrer une adresse email valide.');
                    isValid = false;
                } else if (val.length > 100) {
                    showError(input, 'L\'email ne doit pas dépasser 100 caractères.');
                    isValid = false;
                }
                break;

            // case 'mot_de_passe':
            //     if (val.length < 6) {
            //         showError(input, 'Le mot de passe doit contenir au moins 6 caractères.');
            //         isValid = false;
            //     }
            //     break;

            case 'telephone':
                const phoneRegex = /^(06|07|05)[0-9]{8}$/;
                if (!phoneRegex.test(val)) {
                    showError(input, 'Numéro invalide (ex: 0612345678).');
                    isValid = false;
                } else if (val.length > 15) {
                    showError(input, 'Le téléphone ne doit pas dépasser 15 caractères.');
                    isValid = false;
                }
                break;

            case 'adresse':
                if (val.length > 255) {
                    showError(input, 'L\'adresse ne doit pas dépasser 255 caractères.');
                    isValid = false;
                }
                break;

            case 'photo':
                if (input.files.length > 0) {
                    const file = input.files[0];
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    const maxSize = 2 * 1024 * 1024; // 2MB

                    if (!allowedTypes.includes(file.type)) {
                        showError(input, 'Format non supporté (Uniquement JPG, PNG).');
                        isValid = false;
                    } else if (file.size > maxSize) {
                        showError(input, 'La taille de l\'image ne doit pas dépasser 2MB.');
                        isValid = false;
                    }
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
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatarPreview');
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">`;
        }
        reader.readAsDataURL(file);
    }
});
</script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>