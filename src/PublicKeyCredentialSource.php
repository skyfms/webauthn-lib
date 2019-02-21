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

use Webauthn\TrustPath\TrustPath;

/**
 * @see https://www.w3.org/TR/webauthn/#iface-pkcredential
 */
class PublicKeyCredentialSource
{
    /**
     * @var string
     */
    private $publicKeyCredentialId;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string[]
     */
    private $transports;

    /**
     * @var string
     */
    private $attestationType;

    /**
     * @var TrustPath
     */
    private $trustPath;

    /**
     * @var string
     */
    private $aaguid;

    /**
     * @var string
     */
    private $credentialPublicKey;

    /**
     * @var string
     */
    private $userHandle;

    /**
     * @var int
     */
    private $counter;

    public function __construct($publicKeyCredentialId, $type, array $transports, $attestationType, TrustPath $trustPath, $aaguid, $credentialPublicKey, $userHandle, $counter)
    {
        $this->publicKeyCredentialId = $publicKeyCredentialId;
        $this->type = $type;
        $this->transports = $transports;
        $this->aaguid = $aaguid;
        $this->credentialPublicKey = $credentialPublicKey;
        $this->userHandle = $userHandle;
        $this->counter = $counter;
        $this->attestationType = $attestationType;
        $this->trustPath = $trustPath;
    }

    public function getPublicKeyCredentialId()
    {
        return $this->publicKeyCredentialId;
    }

    public function getPublicKeyCredentialDescriptor(): PublicKeyCredentialDescriptor
    {
        return new PublicKeyCredentialDescriptor(
            $this->type,
            $this->publicKeyCredentialId,
            $this->transports
        );
    }

    public function getAttestationType()
    {
        return $this->attestationType;
    }

    public function getTrustPath(): TrustPath
    {
        return $this->trustPath;
    }

    public function getAttestedCredentialData(): AttestedCredentialData
    {
        return new AttestedCredentialData(
            $this->aaguid,
            $this->publicKeyCredentialId,
            $this->credentialPublicKey
        );
    }

    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string[]
     */
    public function getTransports(): array
    {
        return $this->transports;
    }

    public function getAaguid()
    {
        return $this->aaguid;
    }

    public function getCredentialPublicKey()
    {
        return $this->credentialPublicKey;
    }

    public function getUserHandle()
    {
        return $this->userHandle;
    }

    public function getCounter()
    {
        return $this->counter;
    }

    public function setCounter($counter)
    {
        $this->counter = $counter;
    }
}
