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

class AuthenticatorSelectionCriteria implements \JsonSerializable
{
    const AUTHENTICATOR_ATTACHMENT_NO_PREFERENCE = null;
    const AUTHENTICATOR_ATTACHMENT_PLATFORM = 'platform';
    const AUTHENTICATOR_ATTACHMENT_CROSS_PLATFORM = 'cross-platform';

    const USER_VERIFICATION_REQUIREMENT_REQUIRED = 'required';
    const USER_VERIFICATION_REQUIREMENT_PREFERRED = 'preferred';
    const USER_VERIFICATION_REQUIREMENT_DISCOURAGED = 'discouraged';

    /**
     * @var string|null
     */
    private $authenticatorAttachment;

    /**
     * @var bool
     */
    private $requireResidentKey;

    /**
     * @var string
     */
    private $userVerification;

    public function __construct($authenticatorAttachment = null, $requireResidentKey = false, $userVerification = self::USER_VERIFICATION_REQUIREMENT_PREFERRED)
    {
        $this->authenticatorAttachment = $authenticatorAttachment;
        $this->requireResidentKey = $requireResidentKey;
        $this->userVerification = $userVerification;
    }

    public function getAuthenticatorAttachment()
    {
        return $this->authenticatorAttachment;
    }

    public function isRequireResidentKey()
    {
        return $this->requireResidentKey;
    }

    public function getUserVerification()
    {
        return $this->userVerification;
    }

    public static function createFromJson(array $json): self
    {
        return new self(
            $json['authenticatorAttachment'] ?? null,
            $json['requireResidentKey'] ?? false,
            $json['userVerification'] ?? self::USER_VERIFICATION_REQUIREMENT_PREFERRED
        );
    }

    public function jsonSerialize(): array
    {
        $json = [
            'requireResidentKey' => $this->requireResidentKey,
            'userVerification' => $this->userVerification,
        ];
        if (null !== $this->authenticatorAttachment) {
            $json['authenticatorAttachment'] = $this->authenticatorAttachment;
        }

        return $json;
    }
}
