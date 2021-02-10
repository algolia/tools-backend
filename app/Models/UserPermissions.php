<?php

namespace App;

use League\OAuth2\Client\Token\AccessToken;

class UserPermissions {
    private $token;
    private $email;

    public function __construct(AccessToken $accessToken)
    {
        $this->token = $accessToken;

        $values = $accessToken->getValues();
        $this->email = $values['user']['email'];
    }

    public function getEmail() {
        return $this->getEmail();
    }

    public function isAlgoliaEmployee() {
        return $this->endsWith($this->email, '@algolia.com');
    }

    public function isGuest() {
        return $this->isAlgoliaEmployee() || in_array($this->email, ['vincent@codeagain.com', 'maxiloc@gmail.com']);
    }

    private function endsWith($string, $endString)
    {
        $len = strlen($endString);
        if ($len == 0) {
            return true;
        }
        return (substr($string, -$len) === $endString);
    }
}
