<?php

namespace Cxf\User\Content;

use Cxf\CxfHelper;
trait ContentPrints
{
    public function getContentPrints($options = null, $usePost = true)
    {
        return CxfHelper::getQueryResults($this->client, '/content/prints', $options, $usePost);
    }

    public function getContentPrint($id, $options = null)
    {
        return $this->client->raw('get', "/content/prints/{$id}", $options);
    }

    public function createContentPrint($data, $options = null)
    {
        return $this->client->raw('post', '/content/prints', $options, CxfHelper::dataTransform($data));
    }

    public function updateContentPrint($id, $data, $options = null)
    {
        return $this->client->raw('put', "/content/prints/{$id}", $options, CxfHelper::dataTransform($data));
    }

    public function deleteContentPrint($id)
    {
        return $this->client->raw('delete', "/content/prints/{$id}");
    }
}