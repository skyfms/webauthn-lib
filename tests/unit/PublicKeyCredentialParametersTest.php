<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2018 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace Webauthn\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Webauthn\PublicKeyCredentialParameters;

/**
 * @group unit
 * @group Fido2
 *
 * @covers \Webauthn\PublicKeyCredentialParameters
 */
class PublicKeyCredentialParametersTest extends TestCase
{
    /**
     * @test
     */
    public function anPublicKeyCredentialParametersCanBeCreatedAndValueAccessed()
    {
        $parameters = new PublicKeyCredentialParameters('type', 100);

        static::assertEquals('type', $parameters->getType());
        static::assertEquals(100, $parameters->getAlg());
        static::assertEquals('{"type":"type","alg":100}', \Safe\json_encode($parameters));

        $json = \Safe\json_decode('{"type":"type","alg":100}', true);
        $data = PublicKeyCredentialParameters::createFromJson($json);
        static::assertEquals('type', $data->getType());
        static::assertEquals(100, $data->getAlg());
        static::assertEquals('{"type":"type","alg":100}', \Safe\json_encode($data));
    }
}
