<?php

namespace Cxf\User\Content;

use Cxf\CxfHelper;
trait Blocks
{
    public function duplicateBlock($id, $data)
    {
        return $this->client->raw('post', "/content/blocks/{$id}/duplicate", null, $data);
    }

    public function getBlocks($options = [], $usePost = true)
    {
        return $this->getQueryResults($this->client, '/content/blocks', $options, $usePost);
    }

    public function getBlock($id, $options = [])
    {
        return $this->client->raw('get', "/content/blocks/{$id}", $options);
    }

    public function createBlock($data, $options = [])
    {
        return $this->client->raw('post', '/content/blocks', $options, CxfHelper::dataTransform($data));
    }

    public function updateBlock($id, $data, $options = [])
    {
        return $this->client->raw('put', "/content/blocks/{$id}", $options, CxfHelper::dataTransform($data));
    }

    public function deleteBlock($id)
    {
        return $this->client->raw('delete', "/content/blocks/{$id}");
    }

    private function getQueryResults($endpoint, $options = [], $usePost = true)
    {
        $method = $usePost ? 'post' : 'get';
        return $this->client->raw($method, $endpoint, $options);
    }
}