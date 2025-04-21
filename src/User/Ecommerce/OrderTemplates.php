<?php

namespace Cxf\User\Ecommerce;

use Cxf\CxfHelper;
trait OrderTemplates
{
    public function getOrderTemplates($options = [], $usePost = true)
    {
        return CxfHelper::getQueryResults($this->client, '/ecommerce/order-templates', $options, $usePost);
    }

    public function getOrderTemplate($id, $options = [])
    {
        return $this->client->raw('get', "/ecommerce/order-templates/{$id}", $options);
    }

    public function createOrderTemplate($data, $options = [])
    {
        return $this->client->raw('post', '/ecommerce/order-templates', $options, CxfHelper::dataTransform($data));
    }

    public function updateOrderTemplate($id, $data, $options = [])
    {
        return $this->client->raw('put', "/ecommerce/order-templates/{$id}", $options, CxfHelper::dataTransform($data));
    }

    public function deleteOrderTemplate($id, $options = [])
    {
        return $this->client->raw('delete', "/ecommerce/order-templates/{$id}", $options);
    }
}