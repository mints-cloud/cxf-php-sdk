<?php

namespace Cxf;

use Cxf\User\Config\Config;
use Cxf\User\Content\Content;
use Cxf\User\CustomerData\CustomerData;
use Cxf\User\Ecommerce\Ecommerce;
use Cxf\User\Helpers\Helpers;
use Cxf\User\Marketing\Marketing;
use Cxf\User\Ownership\Ownership;
use Cxf\User\Profile\Profile;
use Cxf\User\Users\Users;

class UserClient
{
    use Profile,
        Marketing,
        Config,
        Content,
        CustomerData,
        Ecommerce,
        Helpers,
        Ownership,
        Users;
    public Client $client;

    /**
     * @param $host
     * @param $apiKey
     * @param $sessionToken
     * @param $debug
     * @param $timeouts
     */
    public function __construct($host = null, $apiKey = null, $debug = false, $timeouts = [])
    {
        $this->client = new Client(
            $host ?? $_ENV['CXF_HOST'] ?? null,
            $apiKey ?? $_ENV['CXF_USER_API_KEY'] ?? null,
            'user',
            null,
            null,
            $debug,
            $timeouts
        );
    }

    /**
     * @param $email
     * @param $password
     * @return mixed
     * @throws \Exception
     */
    public function login($email, $password)
    {
        return $this->client->raw('post', '/users/login', null, [ 'data' => [
            'email' => $email,
            'password' => $password
        ]], '/api/v1', ['no_content_type' => true], false, false);
    }

    /**
     * @param string $token
     * @return mixed
     * @throws \Exception
     */
    public function magicLinkLogin(string $token)
    {
        return $this->client->raw('get', "/user/login/${token}", null, null, '/api/v1/magic-link');
    }

    /**
     * @param string $email
     * @param string $redirectUrl
     * @param int $lifeTime
     * @return mixed
     * @throws \Exception
     */
    public function sendMagicLink(string $email, string $redirectUrl = '', int $lifeTime = 24)
    {
        return $this->client->raw('post', '/user/request', null, ['data' => [
            'email' => $email,
            'redirectUrl' => $redirectUrl,
            'lifeTime' => $lifeTime
        ]], '/api/v1/magic-link');
    }

    private function dataTransform($data)
    {
        return CxfHelper::dataTransform($data);
    }
}
