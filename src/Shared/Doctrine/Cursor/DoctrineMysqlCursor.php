<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\Shared\Doctrine\Cursor;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Query\QueryBuilder;
use Generator;
use Karma8\SubscriptionNotifier\Shared\Doctrine\Cursor\Exception\CursorMustBeInsideTransaction;

final class DoctrineMysqlCursor
{
    private const CURSOR_NAME_PREFIX = 'cursor_';

    private readonly Connection $connection;
    private readonly Query $query;
    private readonly ResultTransformer $resultTransformer;
    private readonly string $cursorName;
    private bool $opened;

    public function __construct(Connection $connection, QueryBuilder $queryBuilder, ResultTransformer $resultTransformer)
    {
        $this->connection = $connection;
        $this->query = new Query(
            $queryBuilder->getSQL(),
            $queryBuilder->getParameters(),
            $queryBuilder->getParameterTypes(),
        );
        $this->resultTransformer = $resultTransformer;
        $this->cursorName = uniqid(self::CURSOR_NAME_PREFIX);
        $this->opened = false;
    }

    /**
     * @throws Exception
     */
    public function fetch(int $batchSize = 1): Generator
    {
        if (!$this->opened) {
            $this->openCursor();
        }

        do {
            $result = $this->connection->executeQuery(
                sprintf(
                    'FETCH FORWARD %d FROM %s',
                    $batchSize,
                    $this->connection->quoteIdentifier($this->cursorName),
                ),
            );

            foreach ($result->iterateAssociative() as $item) {
                yield $this->resultTransformer->transform($item);
            }
        } while ($result->rowCount() !== 0);
    }

    /**
     * @throws Exception
     */
    public function close(): void
    {
        if (!$this->opened) {
            return;
        }

        $this->connection->executeStatement(
            sprintf('CLOSE %s', $this->connection->quoteIdentifier($this->cursorName)),
        );
        $this->opened = false;
    }

    /**
     * @throws Exception
     */
    private function openCursor(): void
    {
        if ($this->connection->getTransactionNestingLevel() === 0) {
            throw new CursorMustBeInsideTransaction();
        }

        $this->connection->executeStatement(
            sprintf(
                'DECLARE %s CURSOR FOR (%s)',
                $this->connection->quoteIdentifier($this->cursorName),
                $this->query->sql,
            ),
            $this->query->parameters,
            $this->query->parameterTypes,
        );

        $this->opened = true;
    }

    /**
     * @throws Exception
     */
    public function __destruct()
    {
        if ($this->opened) {
            $this->close();
        }
    }
}
