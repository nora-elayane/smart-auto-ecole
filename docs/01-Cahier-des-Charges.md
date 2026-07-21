# Cahier des Charges

# Smart Auto-Ecole

> **Version :** 1.0  
> **Date :** Juillet 2026  
> **Auteur :** Nora Elayane

---

# Table des matières

1. Présentation du projet
2. Objectifs
3. Description générale
4. Utilisateurs
5. Fonctionnalités principales
6. Technologies utilisées
7. Contraintes du projet
8. Glossaire

---

# 1. Présentation du projet

## 1.1 Contexte

Les auto-écoles gèrent quotidiennement un grand nombre d'informations liées aux candidats, aux moniteurs, aux véhicules, aux paiements et aux examens.

Dans de nombreuses structures, ces opérations sont encore réalisées manuellement ou à l'aide de plusieurs outils séparés, ce qui entraîne une perte de temps, des erreurs administratives et des difficultés de suivi.

Le projet **Smart Auto-Ecole** consiste à développer une application web permettant de centraliser l'ensemble de ces opérations dans une plateforme unique, intuitive et sécurisée.

---

## 1.2 Problématique

Les principales difficultés rencontrées par une auto-école sont :

- la gestion manuelle des dossiers des candidats ;
- le suivi des paiements ;
- l'organisation des séances de conduite ;
- la planification des examens ;
- la gestion des véhicules et des moniteurs ;
- le suivi des statistiques de l'activité.

Une application de gestion permet de résoudre ces problèmes tout en améliorant l'organisation de l'établissement.

---

# 2. Objectifs

L'application a pour objectif de :

- digitaliser la gestion d'une auto-école ;
- centraliser les données dans une base unique ;
- faciliter le travail administratif ;
- améliorer le suivi des candidats ;
- simplifier la gestion des paiements ;
- optimiser la planification des séances et des examens ;
- fournir des statistiques utiles au directeur.

---

# 3. Description générale

Smart Auto-Ecole est une application web développée selon l'architecture **MVC (Model – View – Controller)**.

Elle permet à chaque utilisateur d'accéder uniquement aux fonctionnalités correspondant à son rôle grâce à un système d'authentification et de gestion des permissions.

L'application sera accessible depuis un navigateur web.

---

# 4. Utilisateurs

L'application comporte quatre profils d'utilisateurs.

## Directeur

Le Directeur possède tous les droits d'administration.

Il peut :

- gérer les utilisateurs ;
- gérer les candidats ;
- gérer les moniteurs ;
- gérer les véhicules ;
- enregistrer les paiements ;
- créer les contrats ;
- programmer les séances ;
- programmer les examens ;
- consulter les statistiques ;
- gérer les paramètres de l'application.

---

## Secrétaire

La Secrétaire est responsable de la gestion administrative quotidienne.

Elle peut :

- inscrire un candidat ;
- modifier les informations d'un candidat ;
- enregistrer un paiement ;
- imprimer un reçu ;
- programmer une séance ;
- programmer un examen ;
- consulter le planning.

Elle ne peut pas gérer les utilisateurs ni modifier les paramètres de l'application.

---

## Moniteur

Le Moniteur assure le suivi pédagogique des candidats.

Il peut :

- consulter son planning ;
- consulter ses candidats ;
- valider les séances effectuées ;
- ajouter des remarques sur les candidats ;
- consulter le véhicule qui lui est attribué.

---

## Candidat

Le Candidat dispose d'un espace personnel.

Il peut :

- consulter son dossier ;
- consulter son planning ;
- consulter ses paiements ;
- consulter le montant restant à payer ;
- consulter les résultats de ses examens.

---

# 5. Fonctionnalités principales

L'application proposera les modules suivants :

- Authentification
- Tableau de bord
- Gestion des utilisateurs
- Gestion des candidats
- Gestion des moniteurs
- Gestion des véhicules
- Gestion des contrats
- Gestion des paiements
- Gestion des séances
- Gestion des examens
- Recherche multicritère
- Statistiques

---

# 6. Technologies utilisées

## Front-end

- HTML5
- CSS3
- JavaScript

## Back-end

- PHP 8 (Programmation Orientée Objet)

## Base de données

- MySQL

## Architecture

- MVC

## Accès aux données

- PDO

## Gestion de versions

- Git
- GitHub

---

# 7. Contraintes du projet

L'application devra :

- être responsive ;
- sécuriser les accès utilisateurs ;
- utiliser des requêtes préparées (PDO) ;
- respecter l'architecture MVC ;
- utiliser une base de données relationnelle ;
- garantir l'intégrité des données ;
- offrir une interface simple et ergonomique.

---

# 8. Glossaire

| Terme | Définition |
|--------|------------|
| Candidat | Personne inscrite à l'auto-école |
| Moniteur | Formateur chargé des séances de conduite |
| Directeur | Responsable de l'auto-école |
| Séance | Cours pratique de conduite |
| Contrat | Document d'inscription du candidat |
| Paiement | Somme versée par le candidat |
| MVC | Architecture Model – View – Controller |

---

**Fin du document**
