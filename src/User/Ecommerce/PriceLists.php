<?php

namespace Cxf\User\Ecommerce;
use Cxf\CxfHelper;
trait PriceLists
{
    public function priceLists($options = [], $usePost = true) {
        return CxfHelper::getQueryResults($this->client, '/ecommerce/price-lists', $options, $usePost);
    }

    public function createPriceList($data, $options = null) {
        return $this->client->raw('post', '/ecommerce/price-lists', $options, CxfHelper::dataTransform($data));
    }

    public function updatePriceList($id, $data, $options = null) {
        return $this->client->raw('put', "/ecommerce/price-lists/{$id}", $options, CxfHelper::dataTransform($data));
    }

    public function deletePriceList($id, $options = null) {
        return $this->client->raw('delete', "/ecommerce/price-lists/{$id}", $options);
    }

    public function getPriceList($id, $options = null) {
        return $this->client->raw('get', "/ecommerce/price-lists/{$id}", $options);
    }
}