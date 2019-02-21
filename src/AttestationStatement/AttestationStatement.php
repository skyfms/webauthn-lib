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

use Assert\Assertion;
use Webauthn\TrustPath\AbstractTrustPath;
use Webauthn\TrustPath\TrustPath;

class AttestationStatement implements \JsonSerializable
{
    const TYPE_NONE = 'none';
    const TYPE_BASIC = 'basic';
    const TYPE_SELF = 'self';
    const TYPE_ATTCA = 'attca';
    const TYPE_ECDAA = 'ecdaa';

    /**
     * @var string
     */
    private $fmt;

    /**
     * @var array
     */
    private $attStmt;

    /**
     * @var TrustPath
     */
    private $trustPath;

    /**
     * @var string
     */
    private $type;

    public function __construct($fmt, array $attStmt, $type, TrustPath $trustPath)
    {
        $this->fmt = $fmt;
        $this->attStmt = $attStmt;
        $this->type = $type;
        $this->trustPath = $trustPath;
    }

    public static function createNone($fmt, array $attStmt, TrustPath $trustPath): self
    {
        return new self($fmt, $attStmt, self::TYPE_NONE, $trustPath);
    }

    public static function createBasic($fmt, array $attStmt, TrustPath $trustPath): self
    {
        return new self($fmt, $attStmt, self::TYPE_BASIC, $trustPath);
    }

    public static function createSelf($fmt, array $attStmt, TrustPath $trustPath): self
    {
        return new self($fmt, $attStmt, self::TYPE_SELF, $trustPath);
    }

    public static function createAttCA($fmt, array $attStmt, TrustPath $trustPath): self
    {
        return new self($fmt, $attStmt, self::TYPE_ATTCA, $trustPath);
    }

    public static function createEcdaa($fmt, array $attStmt, TrustPath $trustPath): self
    {
        return new self($fmt, $attStmt, self::TYPE_ECDAA, $trustPath);
    }

    public function getFmt()
    {
        return $this->fmt;
    }

    public function getAttStmt(): array
    {
        return $this->attStmt;
    }

    public function has($key)
    {
        return \array_key_exists($key, $this->attStmt);
    }

    public function get($key)
    {
        Assertion::true($this->has($key), \Safe\sprintf('The attestation statement has no key "%s".', $key));

        return $this->attStmt[$key];
    }

    public function getTrustPath(): TrustPath
    {
        return $this->trustPath;
    }

    public function getType()
    {
        return $this->type;
    }

    public static function createFromJson(array $data): self
    {
        foreach (['fmt', 'attStmt', 'trustPath', 'type'] as $key) {
            Assertion::keyExists($data, $key, \Safe\sprintf('The key "%s" is missing', $key));
        }

        return new self(
            $data['fmt'],
            $data['attStmt'],
            $data['type'],
            AbstractTrustPath::createFromJson($data['trustPath'])
        );
    }

    public function jsonSerialize(): array
    {
        Assertion::isInstanceOf($this->trustPath, AbstractTrustPath::class, 'This method is reserved for specific classes');

        return [
            'fmt' => $this->fmt,
            'attStmt' => $this->attStmt,
            'trustPath' => $this->trustPath,
            'type' => $this->type,
        ];
    }
}
