<?php

// If you choose to use ENV vars to define these values, give this IdP its own env var names
// so you can define different values for each IdP, all starting with 'SAML2_'.$this_idp_env_id
$this_idp_env_id = 'ssocircle';

// This is variable is for simplesaml example only.
// For real IdP, you must set the url values in the 'idp' config to conform to the IdP's real urls.
// $idp_host = env('SAML2_'.$this_idp_env_id.'_IDP_HOST', 'http://localhost:8000/simplesaml');
$idp_host = 'https://idp.ssocircle.com';

return $settings = [
    // One Login Settings

    // If 'strict' is True, then the PHP Toolkit will reject unsigned
    // or unencrypted messages if it expects them signed or encrypted
    // Also will reject the messages if not strictly follow the SAML
    // standard: Destination, NameId, Conditions ... are validated too.
    'strict' => true, // @todo: make this depend on laravel config

    // Enable debug mode (to print errors)
    'debug' => env('APP_DEBUG', false),

    // Service Provider Data that we are deploying
    'sp' => [
        // Specifies constraints on the name identifier to be used to
        // represent the requested subject.
        // Take a look on lib/Saml2/Constants.php to see the NameIdFormat supported
        'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent',

        // Usually x509cert and privateKey of the SP are provided by files placed at
        // the certs folder. But we can also provide them with the following parameters
        'x509cert' => env('SAML2_'.$this_idp_env_id.'_SP_x509', ''),
        'privateKey' => env('SAML2_'.$this_idp_env_id.'_SP_PRIVATEKEY', ''),

        // Identifier (URI) of the SP entity.
        // Leave blank to use the '{idpName}_metadata' route, e.g. 'test_metadata'.
        'entityId' => env('SAML2_'.$this_idp_env_id.'_SP_ENTITYID', ''),

        // Specifies info about where and how the <AuthnResponse> message MUST be
        // returned to the requester, in this case our SP.
        'assertionConsumerService' => [
            // URL Location where the <Response> from the IdP will be returned,
            // using HTTP-POST binding.
            // Leave blank to use the '{idpName}_acs' route, e.g. 'test_acs'
            'url' => '',
        ],
        // Specifies info about where and how the <Logout Response> message MUST be
        // returned to the requester, in this case our SP.
        // Remove this part to not include any URL Location in the metadata.
        'singleLogoutService' => [
            // URL Location where the <Response> from the IdP will be returned,
            // using HTTP-Redirect binding.
            // Leave blank to use the '{idpName}_sls' route, e.g. 'test_sls'
            'url' => '',
        ],
    ],

    // Identity Provider Data that we want connect with our SP
    'idp' => [
        // Identifier of the IdP entity  (must be a URI)

        'entityId' => $idp_host,
        // SSO endpoint info of the IdP. (Authentication Request protocol)
        'singleSignOnService' => [
            // URL Target of the IdP where the SP will send the Authentication Request Message,
            // using HTTP-Redirect binding.

            'url' => $idp_host.'/sso/SSORedirect/metaAlias/publicidp',
        ],
        // SLO endpoint info of the IdP.
        'singleLogoutService' => [
            // URL Location of the IdP where the SP will send the SLO Request,
            // using HTTP-Redirect binding.

            'url' => $idp_host.'/sso/IDPSloRedirect/metaAlias/publicidp',
        ],
        // Public x509 certificate of the IdP
        // 'x509cert' => 'MIIFLzCCAxegAwIBAgIJALje1EQBtAlnMA0GCSqGSIb3DQEBDQUAMC4xCzAJBgNVBAYTAkRFMRIwEAYDVQQKDAlTU09DaXJjbGUxCzAJBgNVBAMMAkNBMB4XDTE2MDcyNzEyMTYxMFoXDTI2MDYwNTEyMTYxMFowLjELMAkGA1UEBhMCREUxEjAQBgNVBAoMCVNTT0NpcmNsZTELMAkGA1UEAwwCQ0EwggIiMA0GCSqGSIb3DQEBAQUAA4ICDwAwggIKAoICAQCyfZx/C2Iu1MHcg5dhFWmK3l25U/f/IMyUj5nEep+0jow+hApJobbWSUdtY+rajRF2n9rGJ/kaNIC5kykEgL3iJ1op4wZ2SU+23qb54tTBkuGh4Wg9uwb4Q279d7eEJNdHkp4wmHfBghnGHc2iXzI4lPhFDFbCrDtaUZyDXfnpWsO/GOhGAfo7HyG2vsbqLuFXDIL083pUsbtY19IzpSHnEG7AR/UvoeJVvZLhq5Gy904vjDhZaHDc31UMHPRXnyOYrbiEUWN0gctbnwLeZSO/gUJQZ+MTaxzB1Ftfqc1k54Hs4bnqhchnJNHmW8Jg6gRXRyM0J1+XlnJpKgtlCyRg5peoWLzQlW1/AupcEWPfRBw53zi8umVZHuC+hrTyVDM22laELn31ypJtCtzXr8+vFWp8irn4j2FbraAv5gfk7qVZWYQXhiUg0625CcZjbKvMd2yluSm+yvNijLjQ7FR8lS5f5I97McbLKxZimU14O9D5IzIiSFSYqVyOp1aX0TKVTp8NZFkKE6zU8AC1imHu67kHkJoj71kbBSIKwc/8QwjKTyS4fOGUTlbzstg6vbM6mydMiWlor4k/4iFJalp7n1z3TbyeAFisGiHhu6A/6EORRIg8T7GsS7Zc5PMSqTeciXIexfx6sHovXFQSYPstKyHmizReT6cKg92QfD2+OwIDAQABo1AwTjAdBgNVHQ4EFgQUwNZxAPtM2uqaSyLZDl+chKfHEGkwHwYDVR0jBBgwFoAUwNZxAPtM2uqaSyLZDl+chKfHEGkwDAYDVR0TBAUwAwEB/zANBgkqhkiG9w0BAQ0FAAOCAgEAeUWFTr0iTAS8bjyj6DQHZovRmgKXyFbAR4aVxOTn6NK7GZy95SiIoCGhWL6bBMs05PTuLSUZ2AKGzgCPNbcg2bjBCmGM9wHbMeaMj3ZhwNWPf8Qvs9ul/H8EgkOMsqw9iF2pRhb2hNAUtc/bkw9zrt+zMUPmw1goibOKyW0cCYISnFNt3ZevElNYsik6WqHuIzhkxSt7C5PJnZkOTYa+41hbjPaaeG1Jei6D7TcTHAHOGqVd998O77v8ii3E3RWpzKULuuReHZVgu1a+dPSfrkWatPtk7I3w93RpR8C905L3Iv6umfs8rgI2QxldxaVjk258rccQeL6DSo3Ey0VlGuZK42SqFYP4KH70NJUjzYRpna6NZNBHjpqSrmhxYqLqVM1Mb8i1P6pvAvjqLJjNJWxt6LhoZszK2dTtcEcPySO7Ejp0l/Iz9Aw1tXixub2Uy9T3hjOg1m7VQBvFyGU0jKlUOZOHai0hj2DvDwmcERHHrv5UjHo0MgTo+MSFhYPdjqPg60SQuFUWT+6ZsvYZtGzRtm9Z5rCX1tScMCx4GA4npczTCvCm3hGQm8BIAq0kV2mZCWrr5ju7NaGey/yB01T5m29HjKgbRATIcTQvrk9HGlm5IkGEiO36ulQuwH4HmcZYeMxPiDX5BWOb5IH4y+3cc30LWwEFzoIiXbv6GCs=',
        'x509cert' => 'MIIEYzCCAkugAwIBAgIDIAZmMA0GCSqGSIb3DQEBCwUAMC4xCzAJBgNVBAYTAkRFMRIwEAYDVQQKDAlTU09DaXJjbGUxCzAJBgNVBAMMAkNBMB4XDTE2MDgwMzE1MDMyM1oXDTI2MDMwNDE1MDMyM1owPTELMAkGA1UEBhMCREUxEjAQBgNVBAoTCVNTT0NpcmNsZTEaMBgGA1UEAxMRaWRwLnNzb2NpcmNsZS5jb20wggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCAwWJyOYhYmWZF2TJvm1VyZccs3ZJ0TsNcoazr2pTWcY8WTRbIV9d06zYjngvWibyiylewGXcYONB106ZNUdNgrmFd5194Wsyx6bPvnjZEERny9LOfuwQaqDYeKhI6c+veXApnOfsY26u9Lqb9sga9JnCkUGRaoVrAVM3yfghv/Cg/QEg+I6SVES75tKdcLDTt/FwmAYDEBV8l52bcMDNF+JWtAuetI9/dWCBe9VTCasAr2Fxw1ZYTAiqGI9sW4kWS2ApedbqsgH3qqMlPA7tg9iKy8Yw/deEn0qQIx8GlVnQFpDgzG9k+jwBoebAYfGvMcO/BDXD2pbWTN+DvbURlAgMBAAGjezB5MAkGA1UdEwQCMAAwLAYJYIZIAYb4QgENBB8WHU9wZW5TU0wgR2VuZXJhdGVkIENlcnRpZmljYXRlMB0GA1UdDgQWBBQhAmCewE7aonAvyJfjImCRZDtccTAfBgNVHSMEGDAWgBTA1nEA+0za6ppLItkOX5yEp8cQaTANBgkqhkiG9w0BAQsFAAOCAgEAAhC5/WsF9ztJHgo+x9KV9bqVS0MmsgpG26yOAqFYwOSPmUuYmJmHgmKGjKrj1fdCINtzcBHFFBC1maGJ33lMk2bM2THx22/O93f4RFnFab7t23jRFcF0amQUOsDvltfJw7XCal8JdgPUg6TNC4Fy9XYv0OAHc3oDp3vl1Yj8/1qBg6Rc39kehmD5v8SKYmpE7yFKxDF1ol9DKDG/LvClSvnuVP0b4BWdBAA9aJSFtdNGgEvpEUqGkJ1osLVqCMvSYsUtHmapaX3hiM9RbX38jsSgsl44Rar5Ioc7KXOOZFGfEKyyUqucYpjWCOXJELAVAzp7XTvA2q55u31hO0w8Yx4uEQKlmxDuZmxpMz4EWARyjHSAuDKEW1RJvUr6+5uA9qeOKxLiKN1jo6eWAcl6Wr9MreXR9kFpS6kHllfdVSrJES4ST0uh1Jp4EYgmiyMmFCbUpKXifpsNWCLDenE3hllF0+q3wIdu+4P82RIM71n7qVgnDnK29wnLhHDat9rkC62CIbonpkVYmnReX0jze+7twRanJOMCJ+lFg16BDvBcG8u0n/wIDkHHitBI7bU1k6c6DydLQ+69h8SCo6sO9YuD+/3xAGKad4ImZ6vTwlB4zDCpu6YgQWocWRXE+VkOb+RBfvP755PUaLfL63AFVlpOnEpIio5++UjNJRuPuAA=',
        /*
         *  Instead of use the whole x509cert you can use a fingerprint
         *  (openssl x509 -noout -fingerprint -in "idp.crt" to generate it)
         */
        // 'certFingerprint' => '',
    ],

    // OneLogin advanced settings
    // Security settings
    'security' => [
        // signatures and encryptions offered

        // Indicates that the nameID of the <samlp:logoutRequest> sent by this SP
        // will be encrypted.
        'nameIdEncrypted' => false,

        // Indicates whether the <samlp:AuthnRequest> messages sent by this SP
        // will be signed.              [The Metadata of the SP will offer this info]
        'authnRequestsSigned' => false,

        // Indicates whether the <samlp:logoutRequest> messages sent by this SP
        // will be signed.
        'logoutRequestSigned' => false,

        // Indicates whether the <samlp:logoutResponse> messages sent by this SP
        // will be signed.
        'logoutResponseSigned' => false,

        /* Sign the Metadata
         False || True (use sp certs) || array (
                                                    keyFileName => 'metadata.key',
                                                    certFileName => 'metadata.crt'
                                                )
        */
        'signMetadata' => false,

        // signatures and encryptions required

        // Indicates a requirement for the <samlp:Response>, <samlp:LogoutRequest> and
        // <samlp:LogoutResponse> elements received by this SP to be signed.
        'wantMessagesSigned' => false,

        // Indicates a requirement for the <saml:Assertion> elements received by
        // this SP to be signed.        [The Metadata of the SP will offer this info]
        'wantAssertionsSigned' => false,

        // Indicates a requirement for the NameID received by
        // this SP to be encrypted.
        'wantNameIdEncrypted' => false,

        // Authentication context.
        // Set to false and no AuthContext will be sent in the AuthNRequest,
        // Set true or don't present thi parameter and you will get an AuthContext 'exact' 'urn:oasis:names:tc:SAML:2.0:ac:classes:PasswordProtectedTransport'
        // Set an array with the possible auth context values: array ('urn:oasis:names:tc:SAML:2.0:ac:classes:Password', 'urn:oasis:names:tc:SAML:2.0:ac:classes:X509'),
        'requestedAuthnContext' => true,
    ],

    // Contact information template, it is recommended to suply a technical and support contacts
    'contactPerson' => [
        'technical' => [
            'givenName' => 'name',
            'emailAddress' => 'no@reply.com',
        ],
        'support' => [
            'givenName' => 'Support',
            'emailAddress' => 'no@reply.com',
        ],
    ],

    // Organization information template, the info in en_US lang is recomended, add more if required
    'organization' => [
        'en-US' => [
            'name' => 'Name',
            'displayname' => 'Display Name',
            'url' => 'http://url',
        ],
    ],

    /* Interoperable SAML 2.0 Web Browser SSO Profile [saml2int]   http://saml2int.org/profile/current
   'authnRequestsSigned' => false,    // SP SHOULD NOT sign the <samlp:AuthnRequest>,
                                      // MUST NOT assume that the IdP validates the sign
   'wantAssertionsSigned' => true,
   'wantAssertionsEncrypted' => true, // MUST be enabled if SSL/HTTPs is disabled
   'wantNameIdEncrypted' => false,
*/
];
