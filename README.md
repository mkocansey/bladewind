# bladewindui/bladewindui

This package has moved to [`bladewindui/bladewindui`](https://github.com/bladewindui/bladewindui).

`composer update` will pull the new package transparently through this metapackage — no code changes required. The PHP namespace, `x-bladewind::` Blade tags, `config/bladewind.php`, and `public/vendor/bladewind` are all unchanged by the move.

When convenient, update your own `composer.json`:

```diff
-        "mkocansey/bladewind": "^4.3"
+        "bladewindui/bladewindui": "^4.4"
```

## The one thing that can silently break

A hardcoded vendor path. If you scan BladeWind's own templates for Tailwind utilities:

```diff
-@source '../../vendor/mkocansey/bladewind/packages';
+@source '../../vendor/bladewindui/bladewindui/packages';
```

Missing this doesn't error — the build just stops generating those utility classes and styles quietly disappear.
