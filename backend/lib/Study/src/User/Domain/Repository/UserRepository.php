<?php

namespace Study\User\Domain\Repository;

use Study\User\Domain\Model\User;

interface UserRepository
{
    public function byEmail(string $email): ?User;
}