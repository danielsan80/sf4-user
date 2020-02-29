<?php

namespace Study\Credential\Domain\Repository;

use Study\Credential\Domain\Model\Credential;

interface CredentialRepository
{
    public function byId(string $id): ?Credential;
    public function byKey(string $key): ?Credential;
}