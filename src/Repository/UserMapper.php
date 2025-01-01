<?php

namespace Lumino\Repository;

use JDS\Dbal\DataMapper;

class UserMapper
{
    public function __construct(
        private DataMapper $dataMapper,
        private UserRepository $userRepository
    )
    {
    }

}


