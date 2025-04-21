<?php

namespace Cxf\User\Content;

use Cxf\CxfHelper;
trait Bundles
{
    public function getBundles($options = [], $usePost = true)
    {
        return CxfHelper::getQueryResults($this->client, '/content/bundles', $options, $usePost);
    }

    public function getBundle($id, $options = [])
    {
        return $this->client->raw('get', "/content/bundles/{$id}", $options);
    }

    public function createBundle($data, $options = [])
    {
        return $this->client->raw('post', '/content/bundles', $options, CxfHelper::dataTransform($data));
    }

    public function updateBundle($id, $data, $options = [])
    {
        return $this->client->raw('put', "/content/bundles/{$id}", $options, CxfHelper::dataTransform($data));
    }

    public function deleteBundle($id)
    {
        return $this->client->raw('delete', "/content/bundles/{$id}");
    }
}