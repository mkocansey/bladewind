<?php

declare(strict_types=1);

use Symplify\MonorepoBuilder\Config\MBConfig;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\AddTagToChangelogReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\PushTagReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetCurrentMutualConflictsReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetCurrentMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetNextMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\TagVersionReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateBranchAliasReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateReplaceReleaseWorker;

return static function (MBConfig $config): void {
    // All packages live in packages/*
    $config->packageDirectories([__DIR__.'/packages']);

    // Packages excluded from the monorepo-builder scan
    // (meta is treated separately — it requires all others)
    $config->packageDirectoriesExcludes([]);

    // Release workflow:
    // 1. Bump all inter-package version constraints (e.g. ^2.0 → ^2.1)
    // 2. Bump "replace" entries in the meta composer.json
    // 3. Apply the tag to git
    // 4. Push the tag (triggers the GitHub Actions split workflow)
    // 5. Set next dev aliases
    $config->workers([
        SetCurrentMutualDependenciesReleaseWorker::class,
        UpdateReplaceReleaseWorker::class,
        TagVersionReleaseWorker::class,
        PushTagReleaseWorker::class,
        SetNextMutualDependenciesReleaseWorker::class,
        UpdateBranchAliasReleaseWorker::class,
    ]);
};
