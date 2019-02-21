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

class PublicKeyCredentialUserEntity extends PublicKeyCredentialEntity
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $displayName;

    public function __construct($name, $id, $displayName, $icon = null)
    {
        parent::__construct($name, $icon);
        $this->id = $id;
        $this->displayName = $displayName;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public static function createFromJson(array $json): self
    {
        Assertion::keyExists($json, 'name', 'Invalid input. "name" is missing.');
        Assertion::keyExists($json, 'id', 'Invalid input. "id" is missing.');
        Assertion::keyExists($json, 'displayName', 'Invalid input. "displayName" is missing.');

        return new self(
            $json['name'],
            \Safe\base64_decode($json['id'], true),
            $json['displayName'],
            $json['icon'] ?? null
        );
    }

    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json['id'] = base64_encode($this->id);
        $json['displayName'] = $this->displayName;

        return $json;
    }
}
