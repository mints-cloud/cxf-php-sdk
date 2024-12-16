<?php

namespace Cxf\User\Config;

use Cxf\CxfHelper;

trait Logs
{
    public function getLogs($options = null, $use_post = true)
    {
        return CxfHelper::getQueryResults($this->client, '/config/logs', $options, $use_post);
    }

    public function getLog($id, $options = null)
    {
        return $this->client->raw('get', "/config/logs/{$id}", $options);
    }

    public function createLog($data)
    {
        return $this->client->raw('post', '/config/logs', null, CxfHelper::dataTransform($data));
    }

    public function updateLog($id, $data)
    {
        return $this->client->raw('put', "/config/logs/{$id}", null, CxfHelper::dataTransform($data));
    }

    public function deleteLog($id)
    {
        return $this->client->raw('delete', "/config/logs/{$id}");
    }
}