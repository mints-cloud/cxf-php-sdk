<?php

namespace Cxf\User\Ecommerce;
use Cxf\CxfHelper;
trait Orders
{
    public function getOrders($options = [], $usePost = true)
    {
        return CxfHelper::getQueryResults($this->client, '/ecommerce/orders', $options, $usePost);
    }

    public function createOrder($data, $options = null) {
        return $this->client->raw('post', '/ecommerce/orders', $options, CxfHelper::dataTransform($data));
    }

    public function updateOrder($id, $data, $options = null) {
        return $this->client->raw('put', "/ecommerce/orders/{$id}", $options, CxfHelper::dataTransform($data));
    }

    public function getOrder($id, $options = null) {
        return $this->client->raw('get', "/ecommerce/orders/{$id}", $options);
    }

    public function deleteOrder($id, $options = null) {
        return $this->client->raw('delete', "/ecommerce/orders/{$id}", $options);
    }

    public function addLineItemToSectionOrder($orderId, $data, $options = null) {
        return $this->client->raw('post', "/ecommerce/orders/{$orderId}/line-item", $options, CxfHelper::dataTransform($data));
    }

    public function removeLineItemFromSectionOrder($orderId, $lineItemId, $options = null) {
        return $this->client->raw('delete', "/ecommerce/orders/{$orderId}/line-item/{$lineItemId}", $options);
    }

    public function updateLineItemInSectionOrder($orderId, $data, $options = null) {
        return $this->client->raw('put', "/ecommerce/orders/{$orderId}/line-item", $options, CxfHelper::dataTransform($data));
    }

    public function updateUnitLineItemInSectionOrder($orderId, $data, $options = null) {
        return $this->client->raw('put', "/ecommerce/orders/{$orderId}/unit-line-item", $options, CxfHelper::dataTransform($data));
    }

    public function reorderLineItemsInSectionOrder($orderId, $data, $options = null) {
        return $this->client->raw('put', "/ecommerce/orders/{$orderId}/reorder-line-items", $options, CxfHelper::dataTransform($data));
    }

    public function changeOrderStatus($orderId, $data, $options = null)
    {
        return $this->client->raw('put', "/ecommerce/orders/{$orderId}/status", $options, CxfHelper::dataTransform($data));
    }

    public function createChildOrder($orderId, $data, $options = null) {
        return $this->client->raw('post', "/ecommerce/orders/{$orderId}/child-order", $options, CxfHelper::dataTransform($data));
    }

    public function addChargeToOrder($orderId, $data, $options = null) {
        return $this->client->raw('post', "/ecommerce/orders/{$orderId}/charges", $options, CxfHelper::dataTransform($data));
    }

    public function removeChargeFromOrder($orderId, $options = null) {
        return $this->client->raw('delete', "/ecommerce/orders/{$orderId}/charges", $options);
    }
}