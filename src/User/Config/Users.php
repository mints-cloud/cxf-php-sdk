<?php

namespace Cxf\User\Config;

trait Users
{
    /**
     * Can Users Coach.
     *
     * @return mixed
     */
    public function canUsersCoach()
    {
        return $this->client->raw('get', '/config/users/can_coach');
    }

    /**
     * Get users.
     *
     * @param array $options
     * @return mixed
     */
    public function getUsers(array $options)
    {
        return $this->client->raw('get', '/config/users', $options);
    }

    /**
     * Get user.
     *
     * @param string $id
     * @return mixed
     */
    public function getUser(string $id)
    {
        return $this->client->raw('get', "/config/users/{$id}");
    }

    /**
     * Create user.
     *
     * @param array $data
     * @param array|null $options
     * @return mixed
     */
    public function createUser(array $data, ?array $options = [])
    {
        return $this->client->raw('post', '/config/users', $options, $this->dataTransform($data));
    }

    /**
     * Update user.
     *
     * @param string $id
     * @param array $data
     * @param array|null $options
     * @return mixed
     */
    public function updateUser(string $id, array $data, ?array $options = [])
    {
        return $this->client->raw('put', "/config/users/{$id}", $options, $this->dataTransform($data));
    }
}