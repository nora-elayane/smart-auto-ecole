# Diagramme de Cas d'Utilisation

# Smart Auto-Ecole

---

# 1. Introduction

Ce document décrit les différents cas d'utilisation de l'application Smart Auto-Ecole.

Il identifie les acteurs du système ainsi que les interactions possibles entre chaque acteur et l'application.

---

# 2. Acteurs

L'application comporte quatre acteurs principaux :

- Directeur
- Secrétaire
- Moniteur
- Candidat

---

# 3. Cas d'utilisation

## UC01 - Authentification

### Acteurs

- Directeur
- Secrétaire
- Moniteur
- Candidat

### Description

Permet à un utilisateur de se connecter à l'application à l'aide de son adresse e-mail et de son mot de passe.

---

## UC02 - Gérer les utilisateurs

### Acteur

Directeur

### Description

Le Directeur peut créer, modifier, désactiver ou supprimer un utilisateur.

---

## UC03 - Gérer les candidats

### Acteurs

Directeur

Secrétaire

### Description

Ajouter, modifier, consulter ou supprimer un candidat.

---

## UC04 - Gérer les moniteurs

### Acteur

Directeur

### Description

Ajouter, modifier, consulter ou supprimer un moniteur.

---

## UC05 - Gérer les véhicules

### Acteur

Directeur

### Description

Ajouter, modifier, consulter ou supprimer un véhicule.

---

## UC06 - Gérer les contrats

### Acteurs

Directeur

Secrétaire

### Description

Créer, modifier et consulter le contrat d'inscription d'un candidat.

---

## UC07 - Enregistrer un paiement

### Acteurs

Directeur

Secrétaire

### Description

Enregistrer un paiement effectué par un candidat et générer un reçu.

---

## UC08 - Planifier une séance

### Acteurs

Directeur

Secrétaire

### Description

Programmer une séance de conduite en affectant un moniteur et un véhicule.

---

## UC09 - Consulter le planning

### Acteurs

Directeur

Secrétaire

Moniteur

Candidat

### Description

Afficher les séances programmées selon le rôle de l'utilisateur.

---

## UC10 - Valider une séance

### Acteur

Moniteur

### Description

Confirmer qu'une séance de conduite a été réalisée et ajouter une remarque.

---

## UC11 - Planifier un examen

### Acteurs

Directeur

Secrétaire

### Description

Programmer un examen théorique ou pratique.

---

## UC12 - Consulter les examens

### Acteurs

Directeur

Secrétaire

Moniteur

Candidat

### Description

Consulter les examens programmés ainsi que leurs résultats.

---

## UC13 - Consulter les statistiques

### Acteur

Directeur

### Description

Consulter les statistiques générales de l'auto-école.

---

## UC14 - Gérer son profil

### Acteurs

Tous les utilisateurs

### Description

Modifier les informations personnelles et changer le mot de passe.

---

## UC15 - Déconnexion

### Acteurs

Tous les utilisateurs

### Description

Fermer la session utilisateur de manière sécurisée.

---

# 4. Diagramme UML

Le diagramme de cas d'utilisation sera réalisé à partir des cas d'utilisation décrits dans ce document.

