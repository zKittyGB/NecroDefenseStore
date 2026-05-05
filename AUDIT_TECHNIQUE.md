# Audit technique — NecroDefenseStore

## 1) Défauts d'architecture

### 1.1 Logique d'authentification dispersée
- Le contrôle de connexion est fait via un service `UserManager` avec un état mutable, puis consommé dans les contrôleurs.
- Risque: duplication de logique, état non fiable si le service évolue, couplage inutile entre contrôleurs et service.

**Correction proposée**
- Centraliser les vérifications d'accès via `security.yaml` (`access_control`) et les helpers Symfony (`$this->getUser()`, `isGranted()`).
- Garder `UserManager` stateless (ou le supprimer à terme).

### 1.2 Couplage fort de la vue à l'URL absolue
- Dans `templates/base.html.twig`, les CSS sont chargées selon des comparaisons d'URL absolues (`https://127.0.0.1:8000/...`).
- Risque: casse en production, en staging, avec un autre host/port, derrière reverse proxy.

**Correction proposée**
- Remplacer les comparaisons d'URI par `_route` ou par blocs Twig dédiés.
- À moyen terme: migrer vers Asset Mapper/Encore avec un bundle CSS principal et CSS par page.

### 1.3 Contrôleur `ContactController` trop chargé
- Le contrôleur gère deux cas métiers (contact mail + avis) dans une seule action.
- Risque: maintenance difficile, tests complexes, régressions.

**Correction proposée**
- Extraire deux services applicatifs (`ContactMailService`, `ReviewSubmissionService`) et/ou deux routes dédiées.

## 2) Défauts CSS

### 2.1 Multiplication de fichiers CSS chargés conditionnellement
- Le layout charge de nombreux fichiers conditionnés à l'URL.
- Risque: dette technique, performances, ordre de cascade imprévisible.

**Correction proposée**
- Définir un socle (`app.css`) + fichiers par domaine (auth, catalog, admin).
- Utiliser des classes de namespace (`.page-admin`, `.page-product`) plutôt que des sélecteurs globaux.

### 2.2 Style global minimaliste dans `assets/styles/app.css`
- Le fichier actuel ne contient qu'un `background-color` global.

**Correction proposée**
- Ajouter variables CSS (`:root`), typographie globale, spacing system, et règles d'accessibilité (contraste, focus visibles).

## 3) Défauts de sécurité

### 3.1 Règles d'accès absentes
- Les règles `access_control` étaient commentées.
- Risque: pages sensibles potentiellement accessibles sans rôle attendu.

**Correction proposée**
- Ajouter des règles explicites pour `/admin` et `/customer`.

### 3.2 Rôle non standard à l'inscription
- Le rôle enregistré était `customer` (sans préfixe `ROLE_`).
- Risque: incohérence avec les checks Symfony basés sur `ROLE_*`.

**Correction proposée (appliquée)**
- Utiliser `ROLE_CUSTOMER`.

### 3.3 Flux contact: redirection non retournée
- Une redirection était appelée sans `return`.
- Risque: exécution qui continue après branche invalide.

**Correction proposée (appliquée)**
- Retourner explicitement la redirection.

## 4) Corrections déjà appliquées dans cette passe
- Normalisation du rôle à l'inscription.
- Fiabilisation de `UserManager` (état privé + API booléenne typée).
- Simplification de `ContactController` (suppression dépendance inutile + redirection correcte).

## 5) Plan d'amélioration recommandé (priorisé)
1. **Priorité haute (sécurité):** ajouter tests fonctionnels d'accès (`/admin`, `/customer`) selon rôles.
2. **Priorité haute (archi):** refactor `base.html.twig` en logique basée sur `_route`.
3. **Priorité moyenne (archi):** extraire la logique métier du `ContactController` en services.
4. **Priorité moyenne (front):** rationaliser les feuilles de style et mettre en place une convention (BEM/ITCSS).
5. **Priorité moyenne (qualité):** activer PHPStan/Psalm + PHP-CS-Fixer + tests CI.
