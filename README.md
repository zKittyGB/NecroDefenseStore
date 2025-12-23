# Projet : Necro Defense Store

## Contexte

Ce projet a été réalisé dans le cadre de la formation Développeur d'Application Web 2024/2025. L'objectif est de créer une application permettant de gérer et de consulter un magasin d'arme ayant vu le jour dans un contexte d'apocalypse zombie.

## Contraintes

Le projet a été conçu en tenant compte des contraintes suivantes :

- **Architecture MVC** : Utilisation du modèle de conception Model-View-Controller pour structurer l'application.
- **Technologies** : 
  - JavaScript (JS) pour l'interactivité.
  - Symfony pour la gestion côté serveur.
- **Gestion de médias** : Importation de polices, images.
- **Administration CRUD** : Fonctionnalités d'administration permettant de gérer les entités du projet (Monstre, Habitat, Zone, etc.).

## Description du projet

Le projet s'inscrit dans un contexte apocalyptique où les zombies sont mondialement présents. L'application permet aux utilisateurs de consulter les differentes armes que le magasin propose. L'application permet également la mise à jour des produits et catégories via une partie administration.

## Fonctionnement

### Côté Utilisateur

L'utilisateur peut :

- **Accéder aux armes** : Une galerie affichant les armes.
- **Créer un compte** : Inscription pour un accès personnalisé.
- **Se connecter / Se déconnecter** : Accès authentifié à certaines fonctionnalités.
- **Utiliser la recherche** : Rechercher des armes.

### Partie Administration

Si l'utilisateur possède un rôle **Administrateur**, il peut :

- **Ajouter / Modifier / Supprimer** des armes.
- **Ajouter / Modifier / Supprimer** des catégoories.

## Installation

1. Clonez ce dépôt sur votre machine locale :
   ```bash
   git clone https://github.com/zKittyGB/NecroDefenseStore/).git
