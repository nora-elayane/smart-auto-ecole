# Dépendances Fonctionnelles

# Smart Auto-Ecole

---

## Objectif

Les dépendances fonctionnelles permettent de montrer les relations entre les attributs d'une même relation.

Elles servent à vérifier la cohérence du modèle de données et à préparer la normalisation de la base de données.

---

# ROLE

## Dépendance Fonctionnelle

```text
id_role → nom_role
```

---

# UTILISATEUR

## Dépendances Fonctionnelles

```text
id_user → nom
id_user → prenom
id_user → email
id_user → mot_de_passe
id_user → telephone
id_user → adresse
id_user → cin
id_user → date_naissance
id_user → photo
id_user → etat
id_user → id_role
```

ou de manière condensée :

```text
id_user →
(nom, prenom, email, mot_de_passe, telephone,
adresse, cin, date_naissance, photo, etat, id_role)
```

---

# CATEGORIE

```text
id_categorie →
(code, prix_base, description)
```

---

# VEHICULE

```text
id_vehicule →
(immatriculation, marque, modele,
date_assurance, date_visite_technique, etat)
```

---

# CONTRAT

```text
id_contrat →
(date_contrat, prix_final, statut,
id_user, id_categorie)
```

---

# SEANCE

```text
id_seance →
(type, date, heure_debut,
heure_fin, id_moniteur, id_vehicule)
```

---

# PARTICIPATION

```text
id_participation →
(presence, remarque,
id_seance, id_contrat)
```

---

# PAIEMENT

```text
id_paiement →
(montant, date_paiement,
mode_paiement, reference,
id_contrat)
```

---

# EXAMEN

```text
id_examen →
(type, date, resultat,
numero_tentative, id_contrat)
```

---

# Dépendances Fonctionnelles Globales

| Relation | Dépendance Fonctionnelle |
|----------|--------------------------|
| ROLE | id_role → nom_role |
| UTILISATEUR | id_user → tous les autres attributs |
| CATEGORIE | id_categorie → tous les autres attributs |
| VEHICULE | id_vehicule → tous les autres attributs |
| CONTRAT | id_contrat → tous les autres attributs |
| SEANCE | id_seance → tous les autres attributs |
| PARTICIPATION | id_participation → tous les autres attributs |
| PAIEMENT | id_paiement → tous les autres attributs |
| EXAMEN | id_examen → tous les autres attributs |

---

# Conclusion

Toutes les relations du système utilisent une clé primaire unique.

Chaque clé primaire détermine fonctionnellement l'ensemble des attributs de sa relation.

Le modèle respecte les principes de normalisation et constitue une base cohérente pour la conception de la base de données relationnelle.

---

## Version

**Version : 1.0**

**Statut : Validé**
