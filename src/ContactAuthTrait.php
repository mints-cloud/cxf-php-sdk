<?php

namespace Cxf;

trait ContactAuthTrait
{
    public ContactClient $cxfContact;
    public string $contactToken;

    public function initializeContactClient($host = null, $apiKey = null, $debug = false, $timeouts = []): void
    {
        $this->cxfContact = new ContactClient($host, $apiKey, $debug, $timeouts);
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
        if (!$this->cxfContact) $this->initializeContactClient();
        return $this->cxfContact->login($email, $password);
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
            setcookie('cxf_contact_access_token', $sessionToken, 0, '/', '', true, true);
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
        setcookie('cxf_contact_access_token', '', time() - 3600, '/', '', true, true);
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
            setcookie('cxf_contact_access_token', '', time() - 3600, '/', '', true, true);
            $status = false;
        }

        return $status;
    }
}