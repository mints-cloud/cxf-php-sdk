<?php

namespace Cxf;

trait ContactAuthTrait
{
    public Contact $cxfContact;
    public string $contactToken;

    public function initializeContactClient($host = null, $apiKey = null, $sessionToken = null, $refreshToken = null, $debug = false, $timeouts = []): void
    {
        // Check if cxf_session_token cookie exists, then set session token from cookie
        if (isset($_COOKIE['cxf_contact_session_token'])) {
            $sessionToken = $_COOKIE['cxf_contact_session_token'];
        }

        if (isset($_COOKIE['cxf_contact_refresh_token'])) {
            $refreshToken = $_COOKIE['cxf_contact_refresh_token'];
        }

        $this->cxfContact = new Contact($host, $apiKey, $sessionToken, $refreshToken, $debug, $timeouts);
    }

    /**
     * @param string $email
     * @param string $password
     * @return User
     * @throws \Exception
     */
    public function cxfContactLogin($email, $password)
    {
        // Login in cxf
        $response = $this->cxfContact->login($email, $password);

        if (!isset($response['data']['access_token']) || !isset($response['data']['refresh_token'])) {
            $this->cxfContact->client->setSessionToken($response['data']['access_token']);
            $this->cxfContact->client->setRefreshToken($response['data']['refresh_token']);

            setcookie('cxf_contact_session_token', $response['data']['access_token'], time() + 86400, '/');
            setcookie('cxf_contact_refresh_token', $response['data']['refresh_token'], time() + 86400, '/');
        }
    }

    public function cxfContactMagicLinkLogin($hash, $redirectInError = false)
    {
        // Login in cxf
        $response = $this->cxfContact->magicLinkLogin($hash);

        if (isset($response['data'])) {
            // Get session token from response
            $sessionToken = $response['data']['session_token'];
            $idToken = $response['data']['contact']['contact_token'] ? $response['data']['contact']['contact_token'] : $response['data']['contact']['id_token'];
            // Set a permanent cookie with the session token
            setcookie('cxf_contact_session_token', $sessionToken, 0, '/', '', true, true);
            setcookie('cxf_contact_id', $idToken, 0, '/', '', true, true);
            $this->contactToken = $idToken;
            if ($redirectInError) {
                header('Location: ' . ($response['data']['redirect_url'] ?? '/'));
                exit();
            }
        } else {
            if ($redirectInError) {
                header('Location: /');
                exit();
            }
        }
    }

    public function cxfContactLogout()
    {
        // Logout from cxf
        $this->cxfContact->logout();
        // Delete session token and keep the contact token id
        // Never delete the cxf_contact_id cookie to avoid the creation of ghosts
        setcookie('cxf_contact_session_token', '', time() - 3600, '/', '', true, true);
        $this->contactToken = null;
    }

    public function cxfContactSignedIn()
    {
        try {
            // Check status in cxf
            $response = $this->cxfContact->status();
            $status = isset($response['success']) ? $response['success'] : false;
        } catch (Exception $e) {
            // Handle the client Unauthorized error
            // if cxf response is negative delete the session cookie
            setcookie('cxf_contact_session_token', '', time() - 3600, '/', '', true, true);
            $status = false;
        }

        return $status;
    }
}