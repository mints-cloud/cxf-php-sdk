<?php

namespace Cxf\User\Ecommerce;
use Cxf\CxfHelper;
trait Prices
{
    public function getPrices($options = null, $usePost = true) {
        return CxfHelper::getQueryResults($this->client, '/ecommerce/prices', $options, $usePost);
    }

    public function createPrice($data, $options = null) {
        return $this->client->raw('post', '/ecommerce/prices', $options, CxfHelper::dataTransform($data));
    }

    public function updatePrice($id, $data, $options = null) {
        return $this->client->raw('put', "/ecommerce/prices/{$id}", $options, CxfHelper::dataTransform($data));
    }

    public function deletePrice($id, $options = null) {
        return $this->client->raw('delete', "/ecommerce/prices/{$id}", $options);
    }

    public function getPrice($id, $options = null) {
        return $this->client->raw('get', "/ecommerce/prices/{$id}", $options);
    }
}