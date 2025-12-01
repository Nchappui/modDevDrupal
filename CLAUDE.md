# Projet modDevDrupal

Projet d'apprentissage Drupal 11 avec des modules custom.

## 🎓 Méthode d'apprentissage

**IMPORTANT : Approche pédagogique**

- ❌ **NE PAS** faire les modifications de code automatiquement
- ✅ **GUIDER** l'apprenant pour qu'il fasse les modifications lui-même
- 📚 **Si concept connu** : Dire quoi faire et où le faire
- 🧭 **Si concept nouveau** : Ne pas donner la solution directement, mais :
  - Expliquer le concept
  - Donner des exemples
  - Pointer vers la documentation Drupal officielle
  - Guider progressivement vers la solution
- ⚡ **Exception** : Uniquement si l'apprenant demande explicitement de faire les modifications et d'expliquer après

## Structure du projet

```
web/modules/custom/
├── mymodule/          # Module de démonstration simple
└── rsvplist/          # Module de gestion d'inscriptions RSVP
```

## Module mymodule

Module de démonstration basique.

### Routes
- `/examplePage/{pageNum}` - Page simple avec paramètre

### Fichiers clés
- `src/Controller/FirstController.php` - Contrôleur simple

## Module rsvplist

Module complet de gestion d'inscriptions à des événements.

### Architecture

```
rsvplist/
├── config/
│   ├── install/rsvplist.settings.yml    # Config: allowed_types
│   └── schema/                           # Schéma de validation
├── src/
│   ├── Controller/
│   │   ├── ReportController.php          # /admin/reports/rsvplist
│   │   └── RSVPListController.php        # /events, détails, export CSV
│   ├── Form/
│   │   ├── RSVPForm.php                  # Formulaire d'inscription
│   │   └── RSVPConfigForm.php            # /rsvplist/settings
│   ├── Plugin/Block/
│   │   └── RSVPBlock.php                 # Bloc RSVP (attribut PHP 8)
│   └── EnablerService.php                # Service activation/désactivation
├── templates/
│   ├── hello-block.html.twig
│   └── hello-block2.html.twig
├── rsvplist.module                       # Hooks (theme, form_node_form_alter)
├── rsvplist.install                      # Schéma DB
├── rsvplist.routing.yml
├── rsvplist.services.yml
├── rsvplist.permissions.yml
├── rsvplist.links.menu.yml
├── rsvplist.links.action.yml
└── rsvplist.links.task.yml
```

### Base de données

| Table | Description |
|-------|-------------|
| `rsvplist` | Inscriptions (id, uid, nid, email, created) |
| `rsvplist_enabled` | Nodes avec bloc RSVP activé (nid) |

### Routes principales

| Route | Path | Description |
|-------|------|-------------|
| `rsvplist.admin_settings.form` | `/rsvplist/settings` | Configuration admin |
| `rsvplist.report` | `/admin/reports/rsvplist` | Rapport inscriptions |
| `rsvplist.details` | `/admin/reports/rsvplist/{rsvp_id}` | Détails inscription |
| `rsvplist.events` | `/events` | Liste tous les événements |
| `rsvplist.event_details` | `/events/{node}` | Inscriptions d'un événement |
| `rsvplist.export` | `/admin/reports/rsvplist/export` | Export CSV |
| `rsvplist.add_form` | `/rsvplist` | Formulaire inscription |

### Permissions

- `view rsvplist` - Voir la liste RSVP et s'inscrire
- `access rsvplist report` - Accéder aux rapports
- `administer rsvplist` - Administrer les paramètres

### Service EnablerService

Défini dans `rsvplist.services.yml` comme `rsvplist.enabler`.

Méthodes :
- `isEnabled(Node $node)` - Vérifie si RSVP est activé pour un node
- `setEnabled(Node $node)` - Active RSVP pour un node
- `delEnabled(Node $node)` - Désactive RSVP pour un node

### Hooks implémentés

**`rsvplist_form_node_form_alter`** : Ajoute une checkbox "Activer le bloc RSVP" sur les formulaires de nodes dont le type est autorisé dans la config.

**`rsvplist_theme`** : Déclare les templates custom.

### Flux fonctionnel

1. **Configuration** : L'admin définit les types de contenu autorisés dans `/rsvplist/settings`
2. **Activation par node** : Lors de l'édition d'un node, checkbox pour activer/désactiver le bloc
3. **Affichage** : Le `RSVPBlock` s'affiche sur les nodes activés
4. **Inscription** : L'utilisateur entre son email via `RSVPForm`
5. **Rapports** : Les admins consultent/exportent les inscriptions

## Commandes utiles

```bash
# Vider le cache
drush cr

# Voir la configuration
drush cget rsvplist.settings

# Réinstaller le module
drush pmu rsvplist && drush en rsvplist
```

## Points d'attention

### Injection de dépendances

- **Services** : Configurés via `services.yml`, injection automatique via constructeur
- **Controllers/Forms/Blocks** : Nécessitent `create()` + constructeur

### Routes avec paramètres optionnels

Éviter les paramètres optionnels dans les routes (`node: NULL`). Préférer deux routes distinctes pour éviter les warnings lors de la génération d'URLs.

### entityTypeManager dans ControllerBase

Utiliser `$this->entityTypeManager()` (méthode) et non `$this->entityTypeManager` (propriété).
