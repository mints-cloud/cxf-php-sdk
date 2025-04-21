<?php

namespace Cxf\User\Ecommerce;
use Cxf\CxfHelper;
trait PaymentMethods
{
    public function getPaymentMethods($options = [], $usePost = true)
    {
        return CxfHelper::getQueryResults($this->client, '/ecommerce/payment-methods', $options, $usePost);
    }

    public function getPaymentMethod($id, $options = [])
    {
        return $this->client->raw('get', "/ecommerce/payment-methods/{$id}", $options);
    }

    public function createPaymentMethod($data, $options = [])
    {
        return $this->client->raw('post', '/ecommerce/payment-methods', $options, CxfHelper::dataTransform($data));
    }

    public function updatePaymentMethod($id, $data, $options = [])
    {
        return $this->client->raw('put', "/ecommerce/payment-methods/{$id}", $options, CxfHelper::dataTransform($data));
    }

    public function deletePaymentMethod($id, $options = [])
    {
        return $this->client->raw('delete', "/ecommerce/payment-methods/{$id}", $options);
    }
}