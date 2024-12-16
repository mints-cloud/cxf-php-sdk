<?php

namespace Cxf\User\Config;

use Cxf\CxfHelper;

trait Relationships
{
    public function attachRelationship($data)
    {
        return $this->client->raw('post', '/config/relationships/attach', null, CxfHelper::dataTransform($data));
    }

    public function detachRelationship($data)
    {
        return $this->client->raw('post', '/config/relationships/detach', null, CxfHelper::dataTransform($data));
    }

    public function getRelationships($options = null)
    {
        return $this->client->raw('get', '/config/relationships', $options);
    }

    public function getRelationship($id, $options = null)
    {
        return $this->client->raw('get', "/config/relationships/{$id}", $options);
    }

    public function createRelationship($data)
    {
        return $this->client->raw('post', '/config/relationships', null, CxfHelper::dataTransform($data));
    }

    public function updateRelationship($id, $data)
    {
        return $this->client->raw('put', "/config/relationships/{$id}", null, CxfHelper::dataTransform($data));
    }

    public function deleteRelationship($id)
    {
        return $this->client->raw('delete', "/config/relationships/{$id}");
    }

    public function updateRelationshipPivotFields($data)
    {
        return $this->client->raw('put', '/config/relationships/pivot-fields', null, CxfHelper::dataTransform($data));
    }
}