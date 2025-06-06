<?php

namespace Customize\Resource\trait;

use Doctrine\ORM\EntityManagerInterface;
use Throwable;

trait TransactionalTrait
{
    protected EntityManagerInterface $entityManager;

    /**
     * トランザクション処理をラップする汎用関数
     *
     * @param callable $callback
     * @return mixed
     */
    protected function runInTransaction(callable $callback): mixed
    {
        $conn = $this->entityManager->getConnection();
        $conn->beginTransaction();
        try {
            $result = $callback(); // 実行内容
            $conn->commit();
            return $result;
        } catch (Throwable $e) {
            $conn->rollBack();
            throw $e;
        }
    }

    /**
     * EntityManagerの注入(コントローラーの__constructで呼び出す)
     *
     * @param EntityManagerInterface $entityManager
     * @return void
     */
    protected function setEntityManager(EntityManagerInterface $entityManager): void
    {
        $this->entityManager = $entityManager;
    }
}
