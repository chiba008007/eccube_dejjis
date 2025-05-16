<?php

namespace Customize\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class StartBeforeEnd extends Constraint
{
    public string $message = '開始日{{start}}は終了日{{end}}より前にしてください。';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
    public function validatedBy()
    {
        //return static::class.'Validator';
        return StartBeforeEndValidator::class;
    }
}
