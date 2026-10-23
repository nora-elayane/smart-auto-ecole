
    
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Smart Auto-École</title>
   <link rel="stylesheet" href="/smart-auto-ecole/public/css/style.css">
    <link rel="stylesheet" href="/smart-auto-ecole/public/css/toast.css">
    <link rel="stylesheet" href="/smart-auto-ecole/public/css/buttons.css">

    <style>
        body.login-body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(rgba(15, 23, 42, 0.55), rgba(15, 23, 42, 0.55)), 
                        url('<?= BASE_URL ?>/assets/images/driving-school.webp') no-repeat center center fixed;
            background-size: cover;
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 32px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: var(--radius-lg, 14px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
        }
        .login-header {
            text-align: center;
            margin-bottom: 28px;
        }
        .login-header h2 {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-primary, #0f172a);
            margin-bottom: 6px;
        }
        .login-header p {
            color: var(--text-secondary, #64748b);
            font-size: 13.5px;
        }
        .alert {
            padding: 12px 16px;
            border-radius: var(--radius-md, 10px);
            font-size: 13.5px;
            margin-bottom: 20px;
        }
        .alert-danger {
            background-color: #fef2f2;
            color: var(--danger, #dc2626);
            border: 1px solid #fee2e2;
        }
        .alert-success {
            background-color: #f0fdf4;
            color: var(--success, #16a34a);
            border: 1px solid #dcfce7;
        }
        .btn-block {
            width: 100%;
            margin-top: 8px;
            min-height: 44px;
        }
    </style>
</head>
<body class="login-body">

    <div class="login-card">
        <div class="login-header">
            <h2>Smart Auto-École</h2>
            <p>Connectez-vous pour accéder à votre espace</p>
        </div>

        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?= $_SESSION['flash']['type'] ?>">
                <?= $_SESSION['flash']['message']; ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/login/submit" method="POST">
            <div class="form-group">
                <label class="form-label" for="email">Adresse e-mail</label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="nom@exemple.com" autocomplete="email">
            </div>

            <div class="form-group">
                <label class="form-label" for="mot_de_passe">Mot de passe</label>
                <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required placeholder="••••••••">
            </div>

            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
        </form>
    </div>

</body>
</html>