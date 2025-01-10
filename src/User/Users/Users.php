<?php

namespace Cxf\User\Users;

trait Users
{
    public function listUsers()
    {
        return $this->client->raw('get', '/users/list');
    }
}