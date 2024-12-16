<?php

namespace Cxf;

trait UserAuthTrait
{
    public UserClient $cxfUser;

    public function initializeUserClient($host = null, $apiKey = null, $sessionToken = null, $refreshToken = null, $debug = false, $timeouts = []): void
    {
        // Check if cxf_session_token cookie exists, then set session token from cookie
        if (isset($_COOKIE['cxf_user_session_token'])) {
            $sessionToken = $_COOKIE['cxf_user_session_token'];
        }
        if (isset($_COOKIE['cxf_user_refresh_token'])) {
            $refreshToken = $_COOKIE['cxf_user_refresh_token'];
        }
        $this->cxfUser = new UserClient($host, $apiKey, $sessionToken, $refreshToken, $debug, $timeouts);
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
        if (!isset($this->cxfUser)) $this->initializeClient();
        $response = $this->cxfUser->login($email, $password);
        // Verify if api_token key exists in response
        if (isset($response['data']['access_token']) && isset($response['data']['refresh_token'])) {
            $this->cxfUser->client->setSessionToken($response['data']['access_token']);
            $this->cxfUser->client->setRefreshToken($response['data']['refresh_token']);

            setcookie('cxf_user_session_token', $response['data']['access_token'], time() + 86400, '/');
            setcookie('cxf_user_refresh_token', $response['data']['refresh_token'], time() + 86400, '/');
        }
    }

    /**
     * @return void
     */
    public function cxfUserLogout(): void
    {
        // Unset the cookie called cxf_user_session_token
        setcookie('cxf_user_session_token', '', time() - 3600, '/');
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
            setcookie('cxf_user_session_token', $response['data']['access_token'], time() + 86400, '/');

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
        // Check if cxf_user_session_token cookie exists
        return isset($_COOKIE['cxf_user_session_token']);
    }
}