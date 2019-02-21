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

use Assert\Assertion;

class AuthenticationExtensionsClientInputs implements \JsonSerializable, \Countable, \IteratorAggregate
{
    /**
     * @var AuthenticationExtension[]
     */
    private $extensions = [];

    public function add(AuthenticationExtension $extension)
    {
        $this->extensions[$extension->name()] = $extension;
    }

    public static function createFromJson(array $json): self
    {
        $object = new self();
        foreach ($json as $k => $v) {
            $object->add(new AuthenticationExtension($k, $v));
        }

        return $object;
    }

    public function has($key)
    {
        return \array_key_exists($key, $this->extensions);
    }

    /**
     * @return mixed
     */
    public function get($key)
    {
        Assertion::true($this->has($key), \Safe\sprintf('The extension with key "%s" is not available', $key));

        return $this->extensions[$key];
    }

    public function jsonSerialize(): array
    {
        return $this->extensions;
    }

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->extensions);
    }

    public function count($mode = COUNT_NORMAL)
    {
        return \count($this->extensions, $mode);
    }
}
