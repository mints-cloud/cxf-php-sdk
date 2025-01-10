<?php

namespace Cxf\User\Helpers;
trait Helpers {
    public function slugify($data, $options = null) {
        // TODO: Research use of variable polymorphicObjectType
        return $this->client->raw('post', '/helpers/slugify', $options, $this->data_transform($data));
    }

    public function getSupportData($objectType, $options = null) {
        return $this->client->raw('get', "/helpers/support-data/{$objectType}", $options);
    }

    public function storeLayoutConfig($data, $options = null) {
        return $this->client->raw('post', '/helpers/layout-config', $options, $this->data_transform($data));
    }

    public function getLayoutConfig($options = null) {
        return $this->client->raw('get', '/helpers/layout-config', $options);
    }
}
