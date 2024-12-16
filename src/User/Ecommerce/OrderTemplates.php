<?php

namespace Cxf\User\Ecommerce;

use Cxf\CxfHelper;
trait OrderTemplates
{
    public function getOrderTemplates($options = null, $usePost = true)
    {
        return CxfHelper::getQueryResults($this->client, '/ecommerce/order-templates', $options, $usePost);
    }

    public function getOrderTemplate($id, $options = null)
    {
        return $this->client->raw('get', "/ecommerce/order-templates/{$id}", $options);
    }

    public function createOrderTemplate($data, $options = null)
    {
        return $this->client->raw('post', '/ecommerce/order-templates', $options, CxfHelper::dataTransform($data));
    }

    public function updateOrderTemplate($id, $data, $options = null)
    {
        return $this->client->raw('put', "/ecommerce/order-templates/{$id}", $options, CxfHelper::dataTransform($data));
    }

    public function deleteOrderTemplate($id, $options = null)
    {
        return $this->client->raw('delete', "/ecommerce/order-templates/{$id}", $options);
    }
}