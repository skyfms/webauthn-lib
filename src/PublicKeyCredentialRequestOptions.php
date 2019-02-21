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

use Assert\Assertion;
use Webauthn\AuthenticationExtensions\AuthenticationExtensionsClientInputs;

class PublicKeyCredentialRequestOptions implements \JsonSerializable
{
    const USER_VERIFICATION_REQUIREMENT_REQUIRED = 'required';
    const USER_VERIFICATION_REQUIREMENT_PREFERRED = 'preferred';
    const USER_VERIFICATION_REQUIREMENT_DISCOURAGED = 'discouraged';

    /**
     * @var string
     */
    private $challenge;

    /**
     * @var int|null
     */
    private $timeout;

    /**
     * @var string|null
     */
    private $rpId;

    /**
     * @var PublicKeyCredentialDescriptor[]
     */
    private $allowCredentials;

    /**
     * @var string|null
     */
    private $userVerification;

    /**
     * @var AuthenticationExtensionsClientInputs
     */
    private $extensions;

    /**
     * @param PublicKeyCredentialDescriptor[] $allowCredentials
     */
    public function __construct($challenge, $timeout = null, $rpId = null, array $allowCredentials = [], $userVerification = null, $extensions = null)
    {
        $this->challenge = $challenge;
        $this->timeout = $timeout;
        $this->rpId = $rpId;
        $this->allowCredentials = array_values($allowCredentials);
        $this->userVerification = $userVerification;
        $this->extensions = $extensions ?? new AuthenticationExtensionsClientInputs();
    }

    public function getChallenge()
    {
        return $this->challenge;
    }

    public function getTimeout()
    {
        return $this->timeout;
    }

    public function getRpId()
    {
        return $this->rpId;
    }

    /**
     * @return PublicKeyCredentialDescriptor[]
     */
    public function getAllowCredentials(): array
    {
        return $this->allowCredentials;
    }

    public function getUserVerification()
    {
        return $this->userVerification;
    }

    public function getExtensions(): AuthenticationExtensionsClientInputs
    {
        return $this->extensions;
    }

    public static function createFromJson(array $json): self
    {
        Assertion::keyExists($json, 'challenge', 'Invalid input. "challenge" is missing.');

        $allowCredentials = [];
        $allowCredentialList = $json['allowCredentials'] ?? [];
        foreach ($allowCredentialList as $allowCredential) {
            $allowCredentials[] = PublicKeyCredentialDescriptor::createFromJson($allowCredential);
        }

        return new self(
            \Safe\base64_decode($json['challenge'], true),
            $json['timeout'] ?? null,
            $json['rpId'] ?? null,
            $allowCredentials,
            $json['userVerification'] ?? null,
            isset($json['extensions']) ? AuthenticationExtensionsClientInputs::createFromJson($json['extensions']) : new AuthenticationExtensionsClientInputs()
        );
    }

    public function jsonSerialize(): array
    {
        $json = [
            'challenge' => base64_encode($this->challenge),
        ];

        if (null !== $this->rpId) {
            $json['rpId'] = $this->rpId;
        }

        if (null !== $this->userVerification) {
            $json['userVerification'] = $this->userVerification;
        }

        if (0 !== \count($this->allowCredentials)) {
            $json['allowCredentials'] = $this->allowCredentials;
        }

        if (0 !== $this->extensions->count()) {
            $json['extensions'] = $this->extensions;
        }

        if (!\is_null($this->timeout)) {
            $json['timeout'] = $this->timeout;
        }

        return $json;
    }
}
