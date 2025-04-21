<?php

namespace Cxf\User\Ecommerce;
use Cxf\CxfHelper;
trait Transactions
{

    public function getTransactions($options = [], $usePost = true) {
        return CxfHelper::getQueryResults($this->client, '/ecommerce/transactions', $options, $usePost);
    }

    public function getTransaction($id, $options = []) {
        return $this->client->raw('get', "/ecommerce/transactions/{$id}", $options);
    }

    public function createTransaction($data, $options = []) {
        return $this->client->raw('post', '/ecommerce/transactions', $options, CxfHelper::dataTransform($data));
    }

    public function updateTransaction($id, $data, $options = []) {
        return $this->client->raw('put', "/ecommerce/transactions/{$id}", $options, CxfHelper::dataTransform($data));
    }

    public function deleteTransaction($id, $options = []) {
        return $this->client->raw('delete', "/ecommerce/transactions/{$id}", $options);
    }
}