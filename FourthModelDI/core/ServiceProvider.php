<?php

use DI\ContainerBuilder;

abstract class ServiceProvider {
    abstract public function register(ContainerBuilder $builder): void;
}
