<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\User\UI\Console;

use Karma8\SubscriptionNotifier\Shared\Messenger\Cqrs\Command\CommandBus;
use Karma8\SubscriptionNotifier\User\Application\SendUsersEmailsAboutAlmostEndedSubscription\SendUsersEmailsAboutAlmostEndedSubscriptionCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Uid\UuidV4;
use Throwable;

#[AsCommand(
    'karma8:sn:user:send-users-emails-about-almost-ended-subscription',
    'That command send email about almost ended subscription',
)]
final class SendUsersEmailsAboutAlmostEndedSubscriptionConsoleCommand extends Command
{
    public function __construct(
        private readonly CommandBus $commandBus,
    ) {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Start sending emails to users about almost ended subscription');

        $event = (new Stopwatch())->start((new UuidV4())->toRfc4122());

        try {
            $this->commandBus->handle(new SendUsersEmailsAboutAlmostEndedSubscriptionCommand());
        } catch (Throwable $exception) {
            $io->error($exception->getMessage());

            $exitCode = $exception->getCode();
        }

        $event->stop();

        $io->newLine();
        $io->success(
            sprintf(
                'Done in %.3f seconds, %.3f MB memory used.',
                $event->getDuration() / 1000,
                $event->getMemory() / 1024 / 1024,
            ),
        );

        return $exitCode ?? Command::SUCCESS;
    }
}
