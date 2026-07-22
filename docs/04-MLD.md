# Modèle Logique de Données (MLD)

# Smart Auto-Ecole

---

## Objectif

Le Modèle Logique de Données (MLD) est la traduction du MCD en modèle relationnel.

Il présente les tables, les clés primaires (PK) et les clés étrangères (FK), sans préciser les types de données SQL.

---

# Schéma Relationnel

## ROLE

```text
ROLE(
    #id_role,
    nom_role
)
```

---

## UTILISATEUR

```text
UTILISATEUR(
    #id_user,
    nom,
    prenom,
    email,
    mot_de_passe,
    telephone,
    adresse,
    cin,
    date_naissance,
    photo,
    etat,
    id_role*
)
```

---

## CATEGORIE

```text
CATEGORIE(
    #id_categorie,
    code,
    prix_base,
    description
)
```

---

## VEHICULE

```text
VEHICULE(
    #id_vehicule,
    immatriculation,
    marque,
    modele,
    date_assurance,
    date_visite_technique,
    etat
)
```

---

## CONTRAT

```text
CONTRAT(
    #id_contrat,
    date_contrat,
    prix_final,
    statut,
    id_user*,
    id_categorie*
)
```

---

## SEANCE

```text
SEANCE(
    #id_seance,
    type,
    date,
    heure_debut,
    heure_fin,
    id_moniteur*,
    id_vehicule*
)
```

> **Remarque :**
> `id_vehicule` est nullable lorsque la séance est de type **Code**.

---

## PARTICIPATION

```text
PARTICIPATION(
    #id_participation,
    presence,
    remarque,
    id_seance*,
    id_contrat*
)
```

---

## PAIEMENT

```text
PAIEMENT(
    #id_paiement,
    montant,
    date_paiement,
    mode_paiement,
    reference,
    id_contrat*
)
```

---

## EXAMEN

```text
EXAMEN(
    #id_examen,
    type,
    date,
    resultat,
    numero_tentative,
    id_contrat*
)
```

---

# Légende

- `#` : Clé primaire (Primary Key)
- `*` : Clé étrangère (Foreign Key)

---

# Remarques

- Un utilisateur possède un seul rôle.
- Un candidat peut signer plusieurs contrats.
- Un contrat appartient à une seule catégorie de permis.
- Un contrat peut recevoir plusieurs paiements.
- Un contrat peut comporter plusieurs examens.
- Une séance est animée par un seul moniteur.
- Une séance pratique utilise un véhicule.
- La relation plusieurs-à-plusieurs entre **Contrat** et **Séance** est représentée par la table **PARTICIPATION**.

---

## Version

**Version : 1.0**

**Statut : Validé**
