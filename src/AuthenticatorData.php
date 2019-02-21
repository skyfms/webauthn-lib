<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2018 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace Webauthn;

use Webauthn\AuthenticationExtensions\AuthenticationExtensionsClientOutputs;

/**
 * @see https://www.w3.org/TR/webauthn/#sec-authenticator-data
 */
class AuthenticatorData
{
    /**
     * @var string
     */
    private $authData;

    /**
     * @var string
     */
    private $rpIdHash;

    /**
     * @var string
     */
    private $flags;

    /**
     * @var int
     */
    private $signCount;

    /**
     * @var AttestedCredentialData|null
     */
    private $attestedCredentialData;

    /**
     * @var AuthenticationExtensionsClientOutputs|null
     */
    private $extensions;

    const FLAG_UP = 0b00000001;
    const FLAG_RFU1 = 0b00000010;
    const FLAG_UV = 0b00000100;
    const FLAG_RFU2 = 0b00111000;
    const FLAG_AT = 0b01000000;
    const FLAG_ED = 0b10000000;

    public function __construct($authData, $rpIdHash, $flags, $signCount, $attestedCredentialData, $extensions)
    {
        $this->rpIdHash = $rpIdHash;
        $this->flags = $flags;
        $this->signCount = $signCount;
        $this->attestedCredentialData = $attestedCredentialData;
        $this->extensions = $extensions;
        $this->authData = $authData;
    }

    public function getAuthData()
    {
        return $this->authData;
    }

    public function getRpIdHash()
    {
        return $this->rpIdHash;
    }

    public function isUserPresent()
    {
        return 0 !== (\ord($this->flags) & self::FLAG_UP) ? true : false;
    }

    public function isUserVerified()
    {
        return 0 !== (\ord($this->flags) & self::FLAG_UV) ? true : false;
    }

    public function hasAttestedCredentialData()
    {
        return 0 !== (\ord($this->flags) & self::FLAG_AT) ? true : false;
    }

    public function hasExtensions()
    {
        return 0 !== (\ord($this->flags) & self::FLAG_ED) ? true : false;
    }

    public function getReservedForFutureUse1()
    {
        return \ord($this->flags) & self::FLAG_RFU1;
    }

    public function getReservedForFutureUse2()
    {
        return \ord($this->flags) & self::FLAG_RFU2;
    }

    public function getSignCount()
    {
        return $this->signCount;
    }

    public function getAttestedCredentialData()
    {
        return $this->attestedCredentialData;
    }

    public function getExtensions()
    {
        return null !== $this->extensions && $this->hasExtensions() ? $this->extensions : null;
    }
}
