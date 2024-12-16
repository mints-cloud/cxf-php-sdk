<?php

namespace Cxf\User\Config;

use Cxf\CxfHelper;

trait Seeds
{
    public function processSeed($data)
    {
        return $this->client->raw('post', '/config/seeds', null, CxfHelper::dataTransform($data));
    }

    public function getSeedProcessStatus($id)
    {
        return $this->client->raw('get', "/config/seeds/jobs/{$id}");
    }
}