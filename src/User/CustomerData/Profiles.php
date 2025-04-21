<?php

namespace Cxf\User\CustomerData;
use Cxf\CxfHelper;
trait Profiles
{
    public function getProfiles($options = [], $use_post = true)
    {
        return CxfHelper::getQueryResults($this->client, '/customer-data/profiles', $options, $use_post);
    }

    public function getProfile($id, $options = [])
    {
        return $this->client->raw('get', "/customer-data/profiles/{$id}", $options, null);
    }

    public function createProfile($data, $options = [])
    {
        return $this->client->raw('post', '/customer-data/profiles/', $options, CxfHelper::dataTransform($data));
    }

    public function updateProfile($id, $data, $options = [])
    {
        return $this->client->raw('put', "/customer-data/profiles/{$id}", $options, CxfHelper::dataTransform($data));
    }

    public function deleteProfiles($data)
    {
        return $this->client->raw('delete', '/customer-data/profiles/delete', null, CxfHelper::dataTransform($data));
    }
}