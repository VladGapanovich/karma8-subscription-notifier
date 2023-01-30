<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\EmailConfirmationStatus\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Karma8\SubscriptionNotifier\EmailConfirmationStatus\Domain\Exception\EmailConfirmationStatusNotFoundException;
use Karma8\SubscriptionNotifier\EmailConfirmationStatus\Domain\Model\EmailConfirmationStatus;
use Karma8\SubscriptionNotifier\EmailConfirmationStatus\Domain\Repository\EmailConfirmationStatusRepository;
use Karma8\SubscriptionNotifier\Shared\Model\Email;

/**
 * @template-extends ServiceEntityRepository<EmailConfirmationStatus>
 */
final class DoctrineEmailConfirmationStatusRepository extends ServiceEntityRepository implements EmailConfirmationStatusRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailConfirmationStatus::class);
    }

    /**
     * @throws EmailConfirmationStatusNotFoundException
     * @throws NonUniqueResultException
     */
    public function getByEmail(Email $email): EmailConfirmationStatus
    {
        $emailConfirmationStatus = $this->createQueryBuilder('email_confirmation_status')
            ->andWhere('email_confirmation_status.email = :email')
            ->setParameter('email', $email->value)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$emailConfirmationStatus instanceof EmailConfirmationStatus) {
            throw EmailConfirmationStatusNotFoundException::createByEmail($email);
        }

        return $emailConfirmationStatus;
    }

    public function save(EmailConfirmationStatus $emailConfirmationStatus): void
    {
        $this->_em->persist($emailConfirmationStatus);
        $this->_em->flush();
    }
}
