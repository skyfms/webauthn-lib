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

/**
 * @deprecated Will be removed in v2.0. Please use \Webauthn\PublicKeyCredentialSourceRepository instead
 */
interface CredentialRepository
{
    public function has($credentialId);

    public function get($credentialId): AttestedCredentialData;

    public function getUserHandleFor($credentialId);

    public function getCounterFor($credentialId);

    public function updateCounterFor($credentialId, $newCounter);
}
