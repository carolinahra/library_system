<?php

namespace Factories;

use Services\DatabaseService;

readonly class Factory
{
    public function __construct(protected DatabaseService $databaseService) {}
}
