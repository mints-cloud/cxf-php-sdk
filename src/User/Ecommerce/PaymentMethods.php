<?php

namespace Cxf\User\Ecommerce;
use Cxf\CxfHelper;
trait PaymentMethods
{
    public function getPaymentMethods($options = null, $usePost = true)
    {
        return CxfHelper::getQueryResults($this->client, '/ecommerce/payment-methods', $options, $usePost);
    }

    public function getPaymentMethod($id, $options = null)
    {
        return $this->client->raw('get', "/ecommerce/payment-methods/{$id}", $options);
    }

    public function createPaymentMethod($data, $options = null)
    {
        return $this->client->raw('post', '/ecommerce/payment-methods', $options, CxfHelper::dataTransform($data));
    }

    public function updatePaymentMethod($id, $data, $options = null)
    {
        return $this->client->raw('put', "/ecommerce/payment-methods/{$id}", $options, CxfHelper::dataTransform($data));
    }

    public function deletePaymentMethod($id, $options = null)
    {
        return $this->client->raw('delete', "/ecommerce/payment-methods/{$id}", $options);
    }
}