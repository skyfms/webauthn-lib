<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2018 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace Webauthn\AttestationStatement;

use Webauthn\AuthenticatorData;

class AttestationObject
{
    /**
     * @var string
     */
    private $rawAttestationObject;
    /**
     * @var AttestationStatement
     */
    private $attStmt;
    /**
     * @var AuthenticatorData
     */
    private $authData;

    public function __construct($rawAttestationObject, AttestationStatement $attStmt, AuthenticatorData $authData)
    {
        $this->rawAttestationObject = $rawAttestationObject;
        $this->attStmt = $attStmt;
        $this->authData = $authData;
    }

    public function getRawAttestationObject()
    {
        return $this->rawAttestationObject;
    }

    public function getAttStmt(): AttestationStatement
    {
        return $this->attStmt;
    }

    public function getAuthData(): AuthenticatorData
    {
        return $this->authData;
    }
}
