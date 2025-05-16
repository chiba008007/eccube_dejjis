<?php

namespace Customize\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Doctrine\ORM\EntityManagerInterface;
use Customize\Entity\Hello;

class UniqueHelloNameValidator extends ConstraintValidator
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof UniqueHelloName) {
            throw new UnexpectedTypeException($constraint, UniqueHelloName::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        // 名前がすでに存在するか確認
        $existingHello = $this->entityManager->getRepository(Hello::class)->findOneBy(['name' => $value]);
        // 入力中のエンティティ（Hello）を取得
        $currentHello = $this->context->getObject();
        // $currentHello instenceof Helloについて
        // $currentHello変数がHelloクラスのインスタンスかどうか判定
        if ($existingHello
            && $currentHello instanceof Hello && $existingHello->getId() !== $currentHello->getId()
        ) {
            // エラーメッセージを設定
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->addViolation();
        }
    }
}
