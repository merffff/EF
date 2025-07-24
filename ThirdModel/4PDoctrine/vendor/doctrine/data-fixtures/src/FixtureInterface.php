<?php

declare(strict_types=1);

namespace Doctrine\Common\DataFixtures;

use Doctrine\Persistence\ObjectManager;

/**
 * Interface contract for fixture classes to implement.
 */
interface FixtureInterface
{
    /**
     * Load data DataFixtures with the passed EntityManager
     */
    public function load(ObjectManager $manager): void;
}
