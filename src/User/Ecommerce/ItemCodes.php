<?php

namespace Cxf\User\Ecommerce;

use Cxf\CxfHelper;
trait ItemCodes
{
    public function getItemCodes($options = [], $usePost = true)
    {
        return CxfHelper::getQueryResults($this->client, '/ecommerce/item-codes', $options, $usePost);
    }

    public function getItemCode($id, $options = [])
    {
        return $this->client->raw('get', "/ecommerce/item-codes/{$id}", $options);
    }

    public function createItemCode($data, $options = [])
    {
        return $this->client->raw('post', '/ecommerce/item-codes', $options, CxfHelper::dataTransform($data));
    }

    public function updateItemCode($id, $data, $options = [])
    {
        return $this->client->raw('put', "/ecommerce/item-codes/{$id}", $options, CxfHelper::dataTransform($data));
    }

    public function deleteItemCode($id, $options = [])
    {
        return $this->client->raw('delete', "/ecommerce/item-codes/{$id}", $options);
    }

    public function addSerialsToItemCode($itemCode, $data, $options = [])
    {
        return $this->client->raw('post', "/ecommerce/item-codes/{$itemCode}/add-serials", $options, CxfHelper::dataTransform($data));
    }
}