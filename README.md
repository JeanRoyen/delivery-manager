# 🚚 Delivery Manager – Application de Gestion de Commandes & Livraisons

**Projet de fin d’étude**

Delivery Manager est une application web conçue pour simplifier et optimiser le processus de préparation de commandes au sein des entreprises, tout en offrant aux livreurs un outil dédié pour gérer efficacement leurs tournées.

Ce projet s’inspire du concept initial de *JYSK Delivery*, mais pousse l’idée plus loin avec une vraie séparation entre l’espace entreprise et l’espace livreur.

---

## 🎯 Objectifs du projet

- Faciliter la préparation des commandes en entreprise.
- Centraliser les informations liées aux livraisons.
- Optimiser la répartition et le suivi des livraisons.
- Fournir aux livreurs un outil simple et intuitif pour suivre leurs missions.
- Améliorer la communication entre entreprise, livreurs et clients.

---

## 🧩 Fonctionnalités principales

### 🔐 Espace Entreprise

- **Gestion des commandes**
    - Création, modification et suivi des commandes.
    - Association de chaque commande à un client et à une adresse de livraison.
- **Affectation des livraisons**
    - Attribution manuelle ou automatique d’une livraison à un livreur.
    - Visualisation du planning des livreurs.
- **Gestion des clients**
    - Informations complètes du client.
    - Historique des commandes et livraisons.
- **Tableau de bord**
    - Vue globale des commandes du jour.
    - Livraisons en attente, en cours ou réalisées.
- **Carte interactive**
    - Visualisation des adresses de livraison.
    - Optimisation du trajet (regroupement géographique).
- **Notifications et communication**
    - Possibilité de contacter le client (appel / SMS / email selon implémentation).
    - Système d’alertes si un problème est signalé par un livreur.

---

### 👤 Espace Livreur

- **Connexion à son espace personnel**
    - Accès uniquement aux livraisons qui lui sont attribuées.
- **Consultation de ses livraisons**
    - Informations essentielles : adresse, créneau, nom du client, détails de commande.
- **Navigation intégrée**
    - Accès direct au trajet via application GPS.
- **Signalement d’un problème**
    - Client absent, produit manquant, difficulté d’accès, etc.
    - Transmission instantanée au responsable.
- **Validation de la livraison**
    - Confirmation de livraison.
    - Possibilité de demander une signature ou une preuve photo (selon implémentation future).

---

### 🛠 Fonctionnalités transversales

- **Gestion des rôles et permissions**
    - Administrateur, préparateur, livreur.
- **Historique complet**
    - Traçabilité de chaque étape : préparation, départ, livraison, incidents.
- **Recherche et filtres avancés**
    - Par date, livreur, client, zone, statut…
- **Système de commentaires ou notes internes**
    - Communication interne entre préparateurs et livreurs.
- **Statistiques & rapports**
    - Volume de livraisons.
    - Retards, incidents, performance des livraisons.
    - Zones les plus desservies.

---

## 🚀 Vision à long terme

- Automatisation de l’optimisation des tournées.
- Application mobile dédiée pour les livreurs.
- Intégration avec des systèmes de caisse ou ERP.
- Système de preuve de livraison avancé (signature numérique, photo).
- Chat temps réel entre livreur et entreprise.

---

## ✅ État actuel du projet

La vision présentée ci-dessus correspond au point de départ et aux perspectives de Delivery Manager. Le projet a ensuite été recentré sur une application web de gestion interne fiable, simple à utiliser et adaptée à la présentation d’un projet de fin d’études.

L’application est actuellement déployée à l’adresse suivante :

### [Accéder à Delivery Manager](https://delivery-manager.buzz)

Le code source est disponible sur le dépôt GitHub [JeanRoyen/delivery-manager](https://github.com/JeanRoyen/delivery-manager).

### Fonctionnalités réalisées

- Authentification des employés avec Laravel Fortify.
- Tableau de bord avec indicateurs, raccourcis et dernières commandes.
- Gestion des clients : création, consultation, modification, recherche et suppression réservée aux administrateurs.
- Gestion des produits : création, consultation, modification, recherche et suppression réservée aux administrateurs.
- Création d’une commande avec :
    - recherche et sélection d’un client ;
    - accès rapide à la création d’un client manquant ;
    - ajout et suppression dynamique d’articles ;
    - choix des quantités ;
    - calcul du total en temps réel.
- Suivi des commandes selon cinq statuts : en attente, en préparation, en livraison, livrée et en incident.
- Historique des changements de statut d’une commande.
- Signalement d’un incident avec enregistrement et affichage de sa raison.
- Actions directes depuis une commande : envoyer un email, appeler le client et ouvrir son adresse dans Google Maps.
- Envoi d’emails au client :
    - lors du passage de la commande en livraison ;
    - lors d’un incident, avec sa raison et un message d’excuse.
- Traitement asynchrone des emails avec les queues Laravel.
- Interface disponible en français, anglais et néerlandais.
- Interface responsive avec navigation mobile et tableaux défilables horizontalement.
- Travail d’accessibilité : hiérarchie des titres, noms accessibles des navigations, libellés de formulaires et microdonnées pertinentes.

## 🧱 Choix techniques

| Besoin | Solution retenue |
| --- | --- |
| Framework serveur | Laravel 13 et PHP 8.3+ |
| Interface dynamique | Livewire 4 avec composants Volt |
| Bibliothèque d’interface | Flux UI |
| Mise en forme | Tailwind CSS 4 |
| Authentification | Laravel Fortify |
| Gestion des statuts | Spatie Laravel Model States |
| Tests | Pest 4 |
| Base de données locale | SQLite |
| Base de données en production | MySQL 8.4 |
| Hébergement | Laravel Cloud |
| Serveur SMTP | Infomaniak |
| Emails en développement | Mailpit |

### Cycle d’une commande

```text
En attente → En préparation → En livraison → Livrée
                                      └→ Incident
```

Chaque transition est centralisée par un état métier et enregistrée dans l’historique. Les notifications qui doivent partir par email sont ajoutées à la queue afin de ne pas ralentir l’interface.

## 🌐 Déploiement

La version publique utilise :

- un environnement de production Laravel Cloud ;
- une base de données MySQL managée ;
- un processus de fond `queue:work` pour traiter les emails ;
- le domaine `delivery-manager.buzz` ;
- l’adresse `noreply@delivery-manager.buzz` et le serveur SMTP Infomaniak.

Les identifiants et mots de passe de production ne sont pas enregistrés dans le dépôt. Ils sont configurés dans les variables sécurisées de Laravel Cloud.

## 💻 Installation locale

### Prérequis

- PHP 8.3 ou une version supérieure ;
- Composer ;
- Node.js et npm ;
- Mailpit pour visualiser les emails localement.

### Mise en place

```bash
git clone https://github.com/JeanRoyen/delivery-manager.git
cd delivery-manager
composer run setup
php artisan db:seed
composer run dev
```

La commande `composer run dev` lance l’application Laravel, Vite, le worker de queue, les logs et Mailpit. L’interface Mailpit est accessible sur `http://127.0.0.1:8025`.

Le seeder fournit un jeu de démonstration cohérent et reproductible :

- 5 comptes employés ;
- 60 clients ;
- 20 meubles avec des prix cohérents ;
- 200 commandes réparties entre les différents statuts.

Ces données sont fictives et utilisent exclusivement des adresses réservées aux exemples.

## 🧪 Tests

La suite de tests vérifie notamment l’authentification, les formulaires, les changements de statut, l’historique, les emails mis en queue, les traductions et certains éléments d’accessibilité.

```bash
php artisan test
```
