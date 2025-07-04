<?php

namespace Cxf;

trait UserAuthTrait
{
    public UserClient $cxfUser;

    public function initializeUserClient($host = null, $apiKey = null, $debug = false, $timeouts = []): void
    {
        $this->cxfUser = new UserClient($host, $apiKey, $debug, $timeouts);
    }

    /**
     * @param string $email
     * @param string $password
     * @return User
     * @throws \Exception
     */
    public function cxfUserLogin(string $email, string $password)
    {
        // Check if cxfUser is not initialized, then initialize it
        if (!$this->cxfUser) $this->initializeUserClient();
        return $this->cxfUser->login($email, $password);
    }

    /**
     * @return void
     */
    public function cxfUserLogout(): void
    {
        // Unset the cookie called cxf_user_access_token
        setcookie('cxf_user_access_token', '', time() - 3600, '/');
        // Unset the cookie called cxf_user_refresh_token
        setcookie('cxf_user_refresh_token', '', time() - 3600, '/');
    }

    /**
     * @throws \Exception
     */
    public function cxfUserMagicLink(string $token)
    {
        if (!$this->cxfUser) $this->initializeUserClient();
        $response = $this->cxfUser->magicLinkLogin($token);

        if (isset($response['data']['access_token']) && isset($response['data']['refresh_token'])) {
            $this->cxfUser->client->setSessionToken($response['data']['access_token']);
            setcookie('cxf_user_access_token', $response['data']['access_token'], time() + 86400, '/');

            $this->cxfUser->client->setRefreshToken($response['data']['refresh_token']);
            setcookie('cxf_user_refresh_token', $response['data']['refresh_token'], time() + 86400, '/');
        }
        return $response;
    }

    /**
     * @return bool
     */
    public function cxfUserSignedIn(): bool
    {
        // Check if cxf_user_access_token cookie exists
        return isset($_COOKIE['cxf_user_access_token']);
    }
}