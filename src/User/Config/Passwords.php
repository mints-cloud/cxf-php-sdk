<?php

namespace Cxf\User\Config;

use Cxf\CxfHelper;

trait Passwords
{
    public function updatePassword($type, $data)
    {
        return $this->client->raw('post', "/config/{$type}/password/update", null, CxfHelper::dataTransform($data));
    }
}