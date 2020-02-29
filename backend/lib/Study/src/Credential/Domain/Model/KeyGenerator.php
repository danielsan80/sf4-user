<?php

namespace Study\Credential\Domain\Model;

use Ramsey\Uuid\Uuid;

class KeyGenerator
{

    public function generate(?string $seed=null): string
    {
        if ($seed == null) {
            $seed = Uuid::uuid4();
        }
        return hash('sha256', $seed);
    }

}