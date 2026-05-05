<?php

namespace App\Services;

use \Symfony\Bundle\SecurityBundle\Security;

class UserManager
{
    private Security $security;
    private bool $isLoggedIn = false;

    public function __construct(Security $security)
    {
        $this->security = $security;
        $this->updateConnectionStatus();
    }

    public function isConnected(): bool
    {
        $this->updateConnectionStatus();

        return $this->isLoggedIn;
    }

    public function isDisconnected(): bool
    {
        return !$this->isConnected();
    }

    // Met à jour l'état de connexion
    private function updateConnectionStatus(): void
    {
        $user = $this->security->getUser();
        $this->isLoggedIn = ($user !== null);
    }
}
