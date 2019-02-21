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

class PublicKeyCredentialRpEntity extends PublicKeyCredentialEntity
{
    /**
     * @var string|null
     */
    private $id;

    public function __construct($name, $id = null, $icon = null)
    {
        parent::__construct($name, $icon);
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public static function createFromJson(array $json): self
    {
        Assertion::keyExists($json, 'name', 'Invalid input. "name" is missing.');

        return new self(
            $json['name'],
            $json['id'] ?? null,
            $json['icon'] ?? null
        );
    }

    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        if (null !== $this->id) {
            $json['id'] = $this->id;
        }

        return $json;
    }
}
