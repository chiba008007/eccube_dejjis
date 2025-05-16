<?php

namespace Customize\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Customize\Entity\Hello;

class StartBeforeEndValidator extends ConstraintValidator
{
    public function validate($object, Constraint $constraint)
    {
        if (!$object instanceof Hello) {
            return;
        }
        $start = $object->getStartDate();
        $end = $object->getEndDate();
        if ($start && $end && $start > $end) {
            // バリデーション違反を作成・登録する
            // バリデーションエラーを作る「ビルダー」を開始
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{start}}', $start->format('Y-m-d'))
                ->setParameter('{{end}}', $end->format('Y-m-d'))
                ->atPath('endDate') // エラーメッセージをどのプロパティに関連付けるか
                ->addViolation(); // バリデーションエラーの確定
        }
    }
}
