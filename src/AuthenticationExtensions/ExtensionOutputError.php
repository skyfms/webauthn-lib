<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2018 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace Webauthn\AuthenticationExtensions;

use Exception;

class ExtensionOutputError extends \Exception
{
    /**
     * @var AuthenticationExtension
     */
    private $authenticationExtension;

    public function __construct(AuthenticationExtension $authenticationExtension, $message = '', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->authenticationExtension = $authenticationExtension;
    }

    public function getAuthenticationExtension(): AuthenticationExtension
    {
        return $this->authenticationExtension;
    }
}
