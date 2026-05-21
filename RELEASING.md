# Releasing BladewindUI

All work happens in **this monorepo** (`mkocansey/bladewindui`).  
The individual package repos (`mkocansey/bladewind-table` etc.) are **read-only mirrors** — never push to them directly.

---

## First-time setup

### 1. Create the split repos on GitHub

Create one empty public repo per package (no README, no licence — keep them completely empty):

```
mkocansey/bladewind-core
mkocansey/bladewind-icon
mkocansey/bladewind-script
mkocansey/bladewind-spinner
mkocansey/bladewind-button
mkocansey/bladewind-alert
mkocansey/bladewind-modal
mkocansey/bladewind-forms
mkocansey/bladewind-table
mkocansey/bladewind-content
mkocansey/bladewind-navigation
mkocansey/bladewind          ← the full-install meta package
```

### 2. Add the GitHub Actions secret

In **this monorepo's** Settings → Secrets and variables → Actions, add:

| Secret name | Value |
|---|---|
| `MONOREPO_SPLIT_TOKEN` | A GitHub personal access token (classic) with `repo` scope, or a fine-grained token with **Contents: Read and write** on all split repos |

### 3. Register each split repo on Packagist

Go to [packagist.org/packages/submit](https://packagist.org/packages/submit) and submit each split repo URL. Enable the GitHub webhook so Packagist auto-updates on new tags.

---

## Day-to-day release flow

```bash
# 1. Make sure you're on main and everything is committed
git checkout main && git pull

# 2. Install monorepo-builder (first time only)
composer install

# 3. Validate all package composer.json files are consistent
vendor/bin/monorepo-builder validate

# 4. Release — this command does everything:
#    a) bumps all inter-package version constraints to the new version
#    b) commits the change
#    c) tags the monorepo commit as vX.Y.Z
#    d) pushes the tag to GitHub
#    → GitHub Actions split-packages.yml fires automatically
#    → each packages/* directory is pushed to its read-only repo
#    → the same tag is applied to each split repo
#    → Packagist picks up the new release via webhook
vendor/bin/monorepo-builder release 2.1.0

# 5. Done. Monitor the Actions tab to confirm all 43 splits succeeded.
```

---

## Semantic versioning rules

- **Patch** (`2.0.x`) — bug fixes, no API changes
- **Minor** (`2.x.0`) — new attributes/features, backward compatible
- **Major** (`x.0.0`) — breaking changes (attribute renamed/removed, SP class moved)

All packages always share the same version number. The monorepo-builder enforces this.

---

## Package architecture

Every component is a **standalone leaf package** that users can install individually:

```
composer require mkocansey/bladewind-accordion   # just accordion
composer require mkocansey/bladewind-table       # just table (pulls exact deps)
```

Three **aggregate metapackages** bundle related components for convenience:

```
composer require mkocansey/bladewind-forms       # all form components
composer require mkocansey/bladewind-content     # all content components
composer require mkocansey/bladewind-navigation  # all navigation components
```

The full install meta-package pulls everything:

```
composer require mkocansey/bladewind             # the whole library
```

Aggregate packages are `type: metapackage` — they contain no code, only a `require` list.

---

## Adding a new component

1. Create `packages/<name>/` with:
   - `composer.json` (name: `mkocansey/bladewind-<name>`, type: `library`)
   - `src/Bladewind<Name>ServiceProvider.php`
   - `config/bladewind.php` (just this component's keys)
   - `resources/views/components/` (blade files)
2. Add `"Mkocansey\\Bladewind\\<Name>\\": "packages/<name>/src/"` to root `composer.json` `autoload.psr-4`
3. Add a matrix entry to `.github/workflows/split-packages.yml`
4. If the component belongs to a group (forms/content/navigation), add it to the relevant `packages/<group>/composer.json` `require`
5. Add it to `packages/meta/composer.json` `require` (or it'll be pulled transitively via the group)
6. Add its config keys to `packages/meta/config/bladewind.php`
7. Create the empty GitHub repo `mkocansey/bladewind-<name>`
8. Register it on Packagist with a GitHub webhook
9. Release a new minor version
