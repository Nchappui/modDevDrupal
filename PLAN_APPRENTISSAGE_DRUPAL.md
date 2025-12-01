# Plan d'Apprentissage Drupal - Du Débutant Avancé au Développeur Confirmé

## Évaluation de ton niveau actuel

### Ce que tu maîtrises
- Structure modulaire Drupal (fichiers .info.yml, .routing.yml, .services.yml)
- Création de contrôleurs avec routing et paramètres
- Formulaires basiques (FormBase, ConfigFormBase)
- Plugins : Block, FieldType, FieldWidget, FieldFormatter, Condition
- Service custom simple avec injection de dépendances
- Hooks basiques (hook_theme, hook_form_alter, hook_schema)
- Permissions et contrôle d'accès
- Requêtes base de données simples

### Ce qui doit être consolidé
- Cohérence dans l'injection de dépendances (mélange `\Drupal::` et DI)
- Validation des données
- Gestion des erreurs
- Cache et performance
- Tests unitaires

### Ce qui te manque
- Entités custom et Entity API
- Views (No-Code) et Views programmatiques
- Events et Event Subscribers
- Queue API et Batch API
- REST API et JSON:API
- Multilinguisme
- Modules contrib majeurs (Webform, Paragraphs, etc.)
- Tests automatisés
- Déploiement et configuration management

---

## PHASE 1 : CONSOLIDATION DES BASES (2-3 semaines)

### 1.1 - Nettoyage et bonnes pratiques [CODE]
**Objectif** : Standardiser ton code existant selon les best practices Drupal

- [ ] Refactoriser pour utiliser l'injection de dépendances partout
- [ ] Nettoyer le code commenté
- [ ] Ajouter la documentation PHPDoc
- [ ] Implémenter les coding standards Drupal (phpcs)

### 1.2 - Validation et sécurité [CODE]
**Objectif** : Sécuriser les entrées utilisateur

- [ ] Validation avancée des formulaires
- [ ] Contraintes sur les entités
- [ ] Protection XSS et CSRF
- [ ] Sanitization des données

### 1.3 - Gestion des erreurs et logging [CODE]
**Objectif** : Rendre le code robuste et debuggable

- [ ] Utilisation du Logger Drupal
- [ ] Exceptions personnalisées
- [ ] Messages d'erreur utilisateur vs développeur

### 1.4 - Base de données avancée [CODE]
**Objectif** : Maîtriser l'API Database

- [ ] Requêtes complexes (JOIN, subqueries)
- [ ] Transactions
- [ ] hook_update_N pour les migrations
- [ ] Schema alterations

---

## PHASE 2 : MAÎTRISE DU NO-CODE DRUPAL (2-3 semaines)

### 2.1 - Views [NO-CODE]
**Objectif** : Créer des listes et rapports sans coder

- [ ] Créer des Views basiques (liste, tableau, grille)
- [ ] Filtres exposés et contextuels
- [ ] Relations et jointures
- [ ] Affichages multiples (page, block, feed)
- [ ] Views avec agrégation

### 2.2 - Content Types et Fields [NO-CODE]
**Objectif** : Modéliser des données complexes

- [ ] Créer des types de contenu avancés
- [ ] Field types natifs (Entity Reference, Media, etc.)
- [ ] Form display et View display
- [ ] Gestion des révisions

### 2.3 - Taxonomies et Menus [NO-CODE]
**Objectif** : Organiser le contenu

- [ ] Vocabulaires et termes
- [ ] Hiérarchies de taxonomies
- [ ] Menus dynamiques
- [ ] Breadcrumbs

### 2.4 - Blocks et Layout [NO-CODE]
**Objectif** : Gérer la mise en page

- [ ] Block Layout natif
- [ ] Conditions de visibilité
- [ ] Layout Builder (introduction)

---

## PHASE 3 : MODULES CONTRIB ESSENTIELS (2-3 semaines)

### 3.1 - Webform [MODULE]
**Objectif** : Créer des formulaires complexes sans coder

- [ ] Installation et configuration
- [ ] Création de formulaires multi-étapes
- [ ] Handlers (email, submission)
- [ ] Conditions et logique
- [ ] Intégration avec ton module RSVP

### 3.2 - Paragraphs [MODULE]
**Objectif** : Créer du contenu flexible

- [ ] Concept des paragraphes
- [ ] Types de paragraphes
- [ ] Nested paragraphs
- [ ] Intégration avec les content types

### 3.3 - Pathauto et Metatag [MODULE]
**Objectif** : SEO et URLs propres

- [ ] Patterns d'URL automatiques
- [ ] Tokens
- [ ] Méta-données SEO

### 3.4 - Admin Toolbar et autres outils [MODULE]
**Objectif** : Améliorer l'expérience admin

- [ ] Admin Toolbar
- [ ] Coffee
- [ ] Devel et Kint

---

## PHASE 4 : ENTITY API ET ARCHITECTURE AVANCÉE (3-4 semaines)

### 4.1 - Entités Custom [CODE]
**Objectif** : Créer tes propres types d'entités

- [ ] Content Entity vs Config Entity
- [ ] Annotations d'entité
- [ ] Base fields et bundle fields
- [ ] Entity handlers (form, list builder, access)
- [ ] Convertir ta table `rsvplist` en entité custom

### 4.2 - Entity API avancée [CODE]
**Objectif** : Manipuler les entités comme un pro

- [ ] Entity Query
- [ ] Entity hooks (presave, insert, update, delete)
- [ ] Entity validation
- [ ] Computed fields

### 4.3 - Services avancés [CODE]
**Objectif** : Architecture service-oriented

- [ ] Services avec multiples dépendances
- [ ] Service decoration
- [ ] Tagged services
- [ ] Service collectors

### 4.4 - Events et Event Subscribers [CODE]
**Objectif** : Programmation événementielle

- [ ] Symfony Event Dispatcher
- [ ] Kernel events
- [ ] Custom events
- [ ] Migration de hooks vers events

---

## PHASE 5 : VIEWS PROGRAMMATIQUES ET PLUGINS AVANCÉS (2-3 semaines)

### 5.1 - Views Plugins [CODE]
**Objectif** : Étendre Views avec du code

- [ ] Views Field plugin
- [ ] Views Filter plugin
- [ ] Views Sort plugin
- [ ] Views Argument plugin
- [ ] Views Style plugin

### 5.2 - Plugins avancés [CODE]
**Objectif** : Créer des plugins sophistiqués

- [ ] Plugin derivatives
- [ ] Plugin contexts
- [ ] Plugin configuration forms
- [ ] Plugin managers custom

### 5.3 - Render API avancée [CODE]
**Objectif** : Maîtriser le rendu Drupal

- [ ] Render arrays complexes
- [ ] #lazy_builder
- [ ] #pre_render et #post_render
- [ ] Attachments (JS/CSS dynamiques)

---

## PHASE 6 : PERFORMANCE ET CACHE (2 semaines)

### 6.1 - Cache API [CODE]
**Objectif** : Optimiser les performances

- [ ] Cache tags
- [ ] Cache contexts
- [ ] Cache max-age
- [ ] Custom cache bins
- [ ] Cache invalidation

### 6.2 - Performance [CODE + NO-CODE]
**Objectif** : Application rapide

- [ ] BigPipe
- [ ] Lazy loading
- [ ] Agrégation CSS/JS
- [ ] Profiling avec Devel

### 6.3 - Queue et Batch API [CODE]
**Objectif** : Traitement asynchrone

- [ ] Queue workers
- [ ] Batch operations
- [ ] Cron jobs avancés

---

## PHASE 7 : API ET INTÉGRATIONS (2-3 semaines)

### 7.1 - REST et JSON:API [CODE + NO-CODE]
**Objectif** : Exposer et consommer des APIs

- [ ] JSON:API natif Drupal
- [ ] REST Resources custom
- [ ] Authentication (OAuth, JWT)
- [ ] CORS configuration

### 7.2 - Services externes [CODE]
**Objectif** : Intégrer des APIs tierces

- [ ] Guzzle HTTP client
- [ ] Service wrapper pour API externe
- [ ] Gestion des credentials
- [ ] Webhooks

### 7.3 - GraphQL [MODULE + CODE]
**Objectif** : Alternative moderne à REST

- [ ] Module GraphQL
- [ ] Queries et mutations
- [ ] Custom resolvers

---

## PHASE 8 : MULTILINGUISME (1-2 semaines)

### 8.1 - Configuration multilingue [NO-CODE]
**Objectif** : Site multilingue

- [ ] Modules de langue
- [ ] Interface translation
- [ ] Content translation
- [ ] Configuration translation

### 8.2 - Multilinguisme programmatique [CODE]
**Objectif** : Code multilingue

- [ ] t() et TranslatableMarkup
- [ ] Pluralization
- [ ] Language negotiation
- [ ] Entity translations dans le code

---

## PHASE 9 : TESTS ET QUALITÉ (2-3 semaines)

### 9.1 - Tests unitaires [CODE]
**Objectif** : Tester ton code

- [ ] PHPUnit avec Drupal
- [ ] Unit tests
- [ ] Kernel tests
- [ ] Mocking et fixtures

### 9.2 - Tests fonctionnels [CODE]
**Objectif** : Tester l'application

- [ ] Browser tests
- [ ] JavaScript tests
- [ ] Tests de formulaires

### 9.3 - Qualité de code [CODE]
**Objectif** : Code maintenable

- [ ] PHPCS et Drupal coding standards
- [ ] PHPStan / Psalm
- [ ] CI/CD basics

---

## PHASE 10 : THEMING ET FRONTEND (2-3 semaines)

### 10.1 - Theming Drupal [CODE + NO-CODE]
**Objectif** : Personnaliser l'apparence

- [ ] Structure d'un thème
- [ ] Twig avancé
- [ ] Template suggestions
- [ ] Preprocess functions
- [ ] Libraries et assets

### 10.2 - Layout Builder avancé [NO-CODE + CODE]
**Objectif** : Mise en page flexible

- [ ] Layout Builder pour content types
- [ ] Custom layouts
- [ ] Inline blocks
- [ ] Layout Builder restrictions

### 10.3 - Frontend moderne [CODE]
**Objectif** : Stack frontend moderne

- [ ] Single Directory Components
- [ ] JavaScript moderne dans Drupal
- [ ] Intégration avec frameworks JS (optionnel)

---

## PHASE 11 : DEVOPS ET DÉPLOIEMENT (2 semaines)

### 11.1 - Configuration Management [NO-CODE + CODE]
**Objectif** : Gérer la config entre environnements

- [ ] Export/Import configuration
- [ ] Config split
- [ ] Config ignore
- [ ] Drush config commands

### 11.2 - Environnements et déploiement [DEVOPS]
**Objectif** : Workflow professionnel

- [ ] Environnements (dev, staging, prod)
- [ ] Composer pour Drupal
- [ ] Drush avancé
- [ ] Scripts de déploiement

### 11.3 - Migrations [CODE]
**Objectif** : Importer des données

- [ ] Migrate API
- [ ] Sources (CSV, JSON, DB)
- [ ] Process plugins
- [ ] Migrations custom

---

## PHASE 12 : PROJET INTÉGRATEUR (3-4 semaines)

### Projet : Plateforme d'événements complète
**Objectif** : Mettre tout en pratique

Transformer ton module RSVP en une plateforme complète :

- [ ] Entité custom "Event" avec champs avancés
- [ ] Entité custom "Registration" (remplaçant la table rsvplist)
- [ ] Views pour lister les événements et inscriptions
- [ ] Webform pour inscriptions avec conditions
- [ ] REST API pour les événements
- [ ] Multilingue (FR/EN minimum)
- [ ] Tests automatisés
- [ ] Export configuration
- [ ] Documentation technique

---

## Temps total estimé : 6-8 mois (à temps partiel)

## Ressources recommandées

### Documentation officielle
- https://www.drupal.org/docs
- https://api.drupal.org

### Tutoriels
- https://www.drupal.org/docs/develop
- Drupalize.me (payant mais excellent)

### Communauté
- Drupal Slack
- Drupal Answers (Stack Exchange)
- Drupal.org forums

---

# PROMPTS D'APPRENTISSAGE

Les prompts suivants sont conçus pour être utilisés séquentiellement. Copie-colle le prompt correspondant à l'étape où tu te trouves.

---

## PHASE 1 : CONSOLIDATION DES BASES

### Prompt 1.1 - Refactorisation et bonnes pratiques
```
Je suis à l'étape 1.1 de mon plan d'apprentissage Drupal. Je veux refactoriser mon code pour suivre les bonnes pratiques.

Aide-moi à :
1. Identifier tous les endroits où j'utilise \Drupal:: au lieu de l'injection de dépendances
2. Refactoriser ces fichiers un par un pour utiliser l'injection de dépendances
3. Nettoyer le code commenté dans RSVPConfigForm
4. Ajouter la documentation PHPDoc aux méthodes publiques

Procède fichier par fichier et explique-moi chaque changement.
```

### Prompt 1.2 - Validation et sécurité
```
Je suis à l'étape 1.2 de mon plan d'apprentissage Drupal. Je veux améliorer la validation et la sécurité de mon module RSVP.

Aide-moi à :
1. Ajouter une validation pour éviter les inscriptions en doublon (même email + même node)
2. Valider que le node existe et est publié avant d'accepter une inscription
3. Ajouter des contraintes de sécurité (sanitization des inputs)
4. M'expliquer les protections CSRF/XSS natives de Drupal

Implémente ces améliorations dans mon code existant.
```

### Prompt 1.3 - Gestion des erreurs et logging
```
Je suis à l'étape 1.3 de mon plan d'apprentissage Drupal. Je veux implémenter une gestion des erreurs professionnelle.

Aide-moi à :
1. Créer un service de logging pour mon module RSVP
2. Remplacer les \Drupal::messenger()->addError() par du vrai logging
3. Créer des exceptions personnalisées pour mon module
4. Distinguer les erreurs utilisateur des erreurs système

Montre-moi les bonnes pratiques avec des exemples concrets dans mon code.
```

### Prompt 1.4 - Base de données avancée
```
Je suis à l'étape 1.4 de mon plan d'apprentissage Drupal. Je veux maîtriser l'API Database.

Aide-moi à :
1. Ajouter des contraintes UNIQUE sur ma table rsvplist (nid + email)
2. Créer un hook_update_N pour cette migration
3. Écrire une requête avec JOIN pour récupérer les inscriptions avec les infos du node
4. Implémenter une transaction pour une opération multi-tables

Explique-moi chaque concept et implémente-le dans mon module.
```

---

## PHASE 2 : MAÎTRISE DU NO-CODE DRUPAL

### Prompt 2.1 - Views
```
Je suis à l'étape 2.1 de mon plan d'apprentissage Drupal. Je veux maîtriser Views en No-Code.

Guide-moi pour :
1. Créer une View "Liste des inscriptions RSVP" (page + block)
2. Ajouter des filtres exposés (par événement, par date)
3. Créer une relation vers le contenu node
4. Afficher le nombre d'inscriptions par événement avec agrégation
5. Exporter cette View en configuration

Donne-moi les étapes détaillées dans l'interface Drupal.
```

### Prompt 2.2 - Content Types avancés
```
Je suis à l'étape 2.2 de mon plan d'apprentissage Drupal. Je veux créer un content type "Événement" avancé.

Guide-moi pour :
1. Créer un content type "Event" avec les champs : date début, date fin, lieu, capacité max, image
2. Configurer le form display avec des groupes de champs
3. Configurer le view display avec différents view modes
4. Activer les révisions et le workflow de modération

Donne-moi les étapes détaillées dans l'interface Drupal.
```

### Prompt 2.3 - Taxonomies et organisation
```
Je suis à l'étape 2.3 de mon plan d'apprentissage Drupal. Je veux organiser mon contenu avec des taxonomies.

Guide-moi pour :
1. Créer un vocabulaire "Catégories d'événements" avec une hiérarchie
2. Lier ce vocabulaire à mon content type Event
3. Créer un menu dynamique basé sur ces catégories
4. Configurer les breadcrumbs

Donne-moi les étapes détaillées dans l'interface Drupal.
```

### Prompt 2.4 - Blocks et Layout
```
Je suis à l'étape 2.4 de mon plan d'apprentissage Drupal. Je veux maîtriser la mise en page.

Guide-moi pour :
1. Organiser les blocks sur mon site (header, sidebar, footer)
2. Configurer des conditions de visibilité (par type de contenu, par rôle)
3. Découvrir Layout Builder et l'activer sur mon content type Event
4. Créer un layout personnalisé simple

Donne-moi les étapes détaillées dans l'interface Drupal.
```

---

## PHASE 3 : MODULES CONTRIB ESSENTIELS

### Prompt 3.1 - Webform
```
Je suis à l'étape 3.1 de mon plan d'apprentissage Drupal. Je veux maîtriser le module Webform.

Guide-moi pour :
1. Installer Webform via Composer
2. Créer un formulaire d'inscription événement multi-étapes
3. Configurer les handlers (email de confirmation, stockage)
4. Ajouter des conditions (afficher un champ si une case est cochée)
5. Intégrer ce formulaire à mon content type Event

Donne-moi les étapes détaillées, en comparant avec mon RSVPForm codé à la main.
```

### Prompt 3.2 - Paragraphs
```
Je suis à l'étape 3.2 de mon plan d'apprentissage Drupal. Je veux maîtriser le module Paragraphs.

Guide-moi pour :
1. Installer Paragraphs via Composer
2. Créer des types de paragraphes (Texte + Image, Galerie, CTA)
3. Ajouter un champ Paragraphs à mon content type Event
4. Configurer l'affichage des paragraphes

Explique-moi quand utiliser Paragraphs vs des champs classiques.
```

### Prompt 3.3 - SEO (Pathauto et Metatag)
```
Je suis à l'étape 3.3 de mon plan d'apprentissage Drupal. Je veux optimiser le SEO de mon site.

Guide-moi pour :
1. Installer Pathauto et configurer des patterns d'URL automatiques
2. Comprendre et utiliser les tokens
3. Installer Metatag et configurer les méta-données par défaut
4. Créer des méta-données spécifiques pour les Events

Donne-moi les bonnes pratiques SEO pour Drupal.
```

### Prompt 3.4 - Outils de développement
```
Je suis à l'étape 3.4 de mon plan d'apprentissage Drupal. Je veux améliorer mon environnement de dev.

Guide-moi pour :
1. Installer et configurer Admin Toolbar
2. Installer Devel et Kint pour le debugging
3. Utiliser dpm() et kint() pour débugger
4. Générer du contenu de test avec Devel Generate

Montre-moi comment ces outils m'aident au quotidien.
```

---

## PHASE 4 : ENTITY API ET ARCHITECTURE AVANCÉE

### Prompt 4.1 - Entités Custom (Partie 1)
```
Je suis à l'étape 4.1 de mon plan d'apprentissage Drupal. Je veux créer ma première entité custom.

Aide-moi à :
1. Comprendre la différence entre Content Entity et Config Entity
2. Créer une entité "Registration" pour remplacer ma table rsvplist
3. Définir les annotations d'entité
4. Créer les base fields (email, date, status)

Procède étape par étape avec des explications détaillées.
```

### Prompt 4.2 - Entités Custom (Partie 2)
```
Je continue l'étape 4.1 - création d'entité custom.

Aide-moi à :
1. Créer le form handler pour mon entité Registration
2. Créer le list builder pour afficher les registrations
3. Créer l'access handler pour les permissions
4. Définir les routes pour CRUD

Continue à partir de l'entité créée précédemment.
```

### Prompt 4.3 - Entity API avancée
```
Je suis à l'étape 4.2 de mon plan d'apprentissage Drupal. Je veux maîtriser l'Entity API.

Aide-moi à :
1. Écrire des Entity Queries complexes
2. Implémenter les hooks d'entité (presave, insert, update, delete)
3. Ajouter une validation sur mon entité Registration
4. Créer un computed field (ex: temps restant avant l'événement)

Implémente ces concepts dans mon module.
```

### Prompt 4.4 - Services avancés
```
Je suis à l'étape 4.3 de mon plan d'apprentissage Drupal. Je veux créer des services avancés.

Aide-moi à :
1. Refactoriser EnablerService avec plus de dépendances (logger, entity_type.manager)
2. Créer un nouveau service RegistrationManager avec toute la logique métier
3. Comprendre les tagged services avec un exemple
4. Implémenter un service decorator

Explique chaque concept et implémente-le.
```

### Prompt 4.5 - Events et Event Subscribers
```
Je suis à l'étape 4.4 de mon plan d'apprentissage Drupal. Je veux maîtriser les events.

Aide-moi à :
1. Comprendre le Event Dispatcher de Symfony
2. Créer un Event Subscriber pour réagir à la création d'une inscription
3. Créer un custom event "RegistrationCreatedEvent"
4. Dispatcher cet event depuis mon code
5. Migrer un de mes hooks vers un event subscriber

Implémente ces concepts dans mon module RSVP.
```

---

## PHASE 5 : VIEWS PROGRAMMATIQUES ET PLUGINS AVANCÉS

### Prompt 5.1 - Views Plugins
```
Je suis à l'étape 5.1 de mon plan d'apprentissage Drupal. Je veux créer des plugins Views.

Aide-moi à :
1. Créer un Views Field plugin pour afficher un badge "Places disponibles"
2. Créer un Views Filter plugin pour filtrer par "événements complets"
3. Comprendre l'architecture des plugins Views
4. Intégrer mes plugins à la View créée précédemment

Implémente ces plugins dans mon module.
```

### Prompt 5.2 - Plugins avancés
```
Je suis à l'étape 5.2 de mon plan d'apprentissage Drupal. Je veux maîtriser les plugins avancés.

Aide-moi à :
1. Comprendre et créer des plugin derivatives
2. Utiliser les plugin contexts
3. Ajouter un formulaire de configuration à mon RSVPBlock
4. Créer un plugin manager custom (si pertinent pour mon projet)

Explique chaque concept avec un exemple pratique.
```

### Prompt 5.3 - Render API avancée
```
Je suis à l'étape 5.3 de mon plan d'apprentissage Drupal. Je veux maîtriser le rendu Drupal.

Aide-moi à :
1. Comprendre le cycle de rendu Drupal
2. Utiliser #lazy_builder pour un contenu dynamique
3. Implémenter #pre_render pour modifier un render array
4. Attacher dynamiquement du JS/CSS selon le contexte

Implémente ces concepts dans mon module.
```

---

## PHASE 6 : PERFORMANCE ET CACHE

### Prompt 6.1 - Cache API
```
Je suis à l'étape 6.1 de mon plan d'apprentissage Drupal. Je veux maîtriser le cache.

Aide-moi à :
1. Comprendre cache tags, contexts et max-age
2. Ajouter le bon caching à mes render arrays
3. Invalider le cache quand une inscription est créée
4. Créer un cache bin personnalisé pour mon module

Audite mon code actuel et améliore le caching.
```

### Prompt 6.2 - Queue et Batch API
```
Je suis à l'étape 6.3 de mon plan d'apprentissage Drupal. Je veux gérer les traitements lourds.

Aide-moi à :
1. Créer un Queue Worker pour envoyer des emails en arrière-plan
2. Implémenter un Batch pour exporter toutes les inscriptions
3. Améliorer mon cron pour traiter la queue
4. Gérer les erreurs dans les workers

Implémente ces concepts pour mon module RSVP.
```

---

## PHASE 7 : API ET INTÉGRATIONS

### Prompt 7.1 - REST et JSON:API
```
Je suis à l'étape 7.1 de mon plan d'apprentissage Drupal. Je veux créer des APIs.

Aide-moi à :
1. Activer et configurer JSON:API pour mes entités
2. Créer une REST Resource custom pour les inscriptions
3. Tester les endpoints avec Postman/curl
4. Configurer l'authentification (basic auth ou OAuth)

Guide-moi étape par étape.
```

### Prompt 7.2 - Services externes
```
Je suis à l'étape 7.2 de mon plan d'apprentissage Drupal. Je veux intégrer des APIs externes.

Aide-moi à :
1. Créer un service qui consomme une API externe (ex: API météo pour les events)
2. Utiliser Guzzle HTTP client correctement
3. Gérer les credentials de manière sécurisée
4. Implémenter un webhook receiver

Crée un exemple concret pour mon module.
```

---

## PHASE 8 : MULTILINGUISME

### Prompt 8.1 - Site multilingue
```
Je suis à l'étape 8.1 de mon plan d'apprentissage Drupal. Je veux rendre mon site multilingue.

Guide-moi pour :
1. Installer et configurer les modules de langue (FR/EN)
2. Traduire l'interface de mon module RSVP
3. Activer la traduction de contenu
4. Configurer la négociation de langue (URL prefix)

Donne-moi les étapes No-Code et les adaptations code nécessaires.
```

---

## PHASE 9 : TESTS ET QUALITÉ

### Prompt 9.1 - Tests unitaires
```
Je suis à l'étape 9.1 de mon plan d'apprentissage Drupal. Je veux tester mon code.

Aide-moi à :
1. Configurer PHPUnit pour mon module
2. Écrire un test unitaire pour EnablerService
3. Écrire un kernel test pour tester l'accès à la DB
4. Comprendre le mocking dans Drupal

Crée les premiers tests pour mon module RSVP.
```

### Prompt 9.2 - Tests fonctionnels
```
Je suis à l'étape 9.2 de mon plan d'apprentissage Drupal. Je veux tester l'application.

Aide-moi à :
1. Écrire un Browser test pour le formulaire RSVP
2. Tester les permissions et le contrôle d'accès
3. Tester un formulaire avec soumission
4. Configurer la CI pour lancer les tests

Continue les tests de mon module.
```

---

## PHASE 10 : THEMING ET FRONTEND

### Prompt 10.1 - Theming Drupal
```
Je suis à l'étape 10.1 de mon plan d'apprentissage Drupal. Je veux personnaliser l'apparence.

Aide-moi à :
1. Créer un sous-thème basé sur un thème existant
2. Créer des template suggestions pour mon module
3. Implémenter une fonction preprocess
4. Organiser mes assets CSS/JS avec les libraries

Crée un thème basique pour mon projet.
```

### Prompt 10.2 - Layout Builder avancé
```
Je suis à l'étape 10.2 de mon plan d'apprentissage Drupal. Je veux maîtriser Layout Builder.

Guide-moi pour :
1. Activer Layout Builder sur mon content type Event
2. Créer un layout custom en code
3. Créer des inline blocks réutilisables
4. Restreindre les options pour les éditeurs

Mélange No-Code et Code pour cette étape.
```

---

## PHASE 11 : DEVOPS ET DÉPLOIEMENT

### Prompt 11.1 - Configuration Management
```
Je suis à l'étape 11.1 de mon plan d'apprentissage Drupal. Je veux gérer ma configuration.

Aide-moi à :
1. Exporter toute ma configuration actuelle
2. Comprendre la structure du dossier config/sync
3. Configurer config_split pour dev/prod
4. Importer une configuration sur un autre environnement

Guide-moi avec drush et l'interface.
```

### Prompt 11.2 - Migrations
```
Je suis à l'étape 11.3 de mon plan d'apprentissage Drupal. Je veux migrer des données.

Aide-moi à :
1. Comprendre la Migrate API
2. Créer une migration depuis un CSV
3. Créer une migration depuis ma table rsvplist vers mon entité custom
4. Lancer et debugger une migration

Implémente une migration concrète.
```

---

## PHASE 12 : PROJET INTÉGRATEUR

### Prompt 12.1 - Projet final (Partie 1)
```
Je suis à l'étape 12 de mon plan d'apprentissage Drupal. Je veux créer ma plateforme d'événements complète.

Phase 1 - Architecture :
1. Définis l'architecture complète du projet
2. Liste toutes les entités, content types et relations
3. Planifie les Views et les formulaires
4. Définis les permissions et rôles

Crée un document d'architecture pour mon projet.
```

### Prompt 12.2 - Projet final (Partie 2)
```
Je continue mon projet intégrateur.

Phase 2 - Implémentation des entités :
1. Crée/finalise l'entité Registration
2. Configure le content type Event avec tous les champs
3. Établis les relations entre entités
4. Implémente la validation métier

Guide-moi dans l'implémentation.
```

### Prompt 12.3 - Projet final (Partie 3)
```
Je continue mon projet intégrateur.

Phase 3 - Interface et UX :
1. Crée les Views nécessaires
2. Configure Webform pour les inscriptions
3. Implémente le theming
4. Configure Layout Builder

Guide-moi dans l'implémentation.
```

### Prompt 12.4 - Projet final (Partie 4)
```
Je continue mon projet intégrateur.

Phase 4 - API et finalisation :
1. Expose les endpoints REST/JSON:API
2. Ajoute le multilingue
3. Écris les tests essentiels
4. Exporte la configuration finale
5. Documente le projet

Finalise mon projet intégrateur.
```

---

## APRÈS LE PLAN : PROMPTS DE MAINTENANCE

### Prompt - Debugging
```
J'ai une erreur dans mon module Drupal. Voici l'erreur :
[COLLE L'ERREUR ICI]

Aide-moi à :
1. Comprendre cette erreur
2. Identifier la cause
3. Corriger le problème
4. Éviter cette erreur à l'avenir
```

### Prompt - Code Review
```
J'ai écrit ce code pour mon module Drupal :
[COLLE TON CODE ICI]

Fais une code review et :
1. Identifie les problèmes potentiels
2. Suggère des améliorations
3. Vérifie les bonnes pratiques Drupal
4. Propose une version améliorée
```

### Prompt - Nouvelle fonctionnalité
```
Je veux ajouter cette fonctionnalité à mon module Drupal :
[DÉCRIS LA FONCTIONNALITÉ]

Aide-moi à :
1. Analyser la meilleure approche (code vs no-code vs module contrib)
2. Planifier l'implémentation
3. Coder la solution
4. Tester la fonctionnalité
```
