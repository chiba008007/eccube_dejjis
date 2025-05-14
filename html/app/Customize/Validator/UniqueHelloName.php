<?php

namespace Customize\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueHelloName extends Constraint
{
    public string $message = 'この名前はすでに使用されています。';

    public function getTargets()
    {
        return self::PROPERTY_CONSTRAINT;
    }
    public function validatedBy()
    {
        //return static::class.'Validator';
        return UniqueHelloNameValidator::class;
    }
}
