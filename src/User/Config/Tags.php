<?php

namespace Cxf\User\Config;

use Cxf\CxfHelper;

trait Tags
{
    public function getTags()
    {
        return $this->client->raw('get', '/config/tags');
    }

    public function getTag($id)
    {
        return $this->client->raw('get', "/config/tags/{$id}");
    }

    public function createTag($data)
    {
        return $this->client->raw('post', '/config/tags', null, CxfHelper::dataTransform($data));
    }

    public function updateTag($id, $data)
    {
        return $this->client->raw('put', "/config/tags/{$id}", null, CxfHelper::dataTransform($data));
    }
}