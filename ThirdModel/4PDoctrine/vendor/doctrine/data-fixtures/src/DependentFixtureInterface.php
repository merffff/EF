<?php

declare(strict_types=1);

namespace Doctrine\Common\DataFixtures;

/**
 * DependentFixtureInterface needs to be implemented by DataFixtures which depend on other DataFixtures
 */
interface DependentFixtureInterface
{
    /**
     * This method must return an array of DataFixtures classes
     * on which the implementing class depends on
     *
     * @phpstan-return array<class-string<FixtureInterface>>
     */
    public function getDependencies(): array;
}
