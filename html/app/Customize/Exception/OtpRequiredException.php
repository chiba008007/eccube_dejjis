<?php

namespace Customize\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

class OtpRequiredException extends AuthenticationException
{
    public function getMessageKey(): string
    {
        return 'otp_required';
    }
}
