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

class PublicKeyCredentialDescriptor implements \JsonSerializable
{
    const CREDENTIAL_TYPE_PUBLIC_KEY = 'public-key';

    const AUTHENTICATOR_TRANSPORT_USB = 'usb';
    const AUTHENTICATOR_TRANSPORT_NFC = 'nfc';
    const AUTHENTICATOR_TRANSPORT_BLE = 'ble';
    const AUTHENTICATOR_TRANSPORT_INTERNAL = 'internal';

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string[]
     */
    private $transports;

    /**
     * @param string[] $transports
     */
    public function __construct($type, $id, array $transports = [])
    {
        $this->type = $type;
        $this->id = $id;
        $this->transports = $transports;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string[]
     */
    public function getTransports(): array
    {
        return $this->transports;
    }

    public static function createFromJson(array $json): self
    {
        Assertion::keyExists($json, 'type', 'Invalid input. "type" is missing.');
        Assertion::keyExists($json, 'id', 'Invalid input. "id" is missing.');

        return new self(
            $json['type'],
            \Safe\base64_decode($json['id'], true),
            $json['transports'] ?? []
        );
    }

    public function jsonSerialize(): array
    {
        $json = [
            'type' => $this->type,
            'id' => base64_encode($this->id),
        ];
        if (0 !== \count($this->transports)) {
            $json['transports'] = $this->transports;
        }

        return $json;
    }
}
