<?php

namespace Cxf\User\Content;

use Cxf\CxfHelper;
trait BlockTemplates
{
    public function getBlockTemplates($options = [])
    {
        return $this->client->raw('get', '/content/block-templates', $options);
    }

    public function getBlockTemplate($id, $options = [])
    {
        return $this->client->raw('get', "/content/block-templates/{$id}", $options);
    }

    public function createBlockTemplate($data, $options = [])
    {
        return $this->client->raw('post', '/content/block-templates', $options, CxfHelper::dataTransform($data));
    }

    public function updateBlockTemplate($id, $data)
    {
        return $this->client->raw('put', "/content/block-templates/{$id}", null, CxfHelper::dataTransform($data));
    }
}