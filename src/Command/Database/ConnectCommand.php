<?php

/**
 * @file
 * Contains \Drupal\Console\Command\Database\ConnectCommand.
 */

namespace Drupal\Console\Command\Database;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Drupal\Console\Command\ContainerAwareCommand;
use Drupal\Console\Command\Database\ConnectTrait;

class ConnectCommand extends ContainerAwareCommand
{
    use ConnectTrait;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('database:connect')
            ->setDescription($this->trans('commands.database.connect.description'))
            ->addArgument(
                'database',
                InputArgument::OPTIONAL,
                $this->trans('commands.database.connect.arguments.database')
            )
            ->setHelp($this->trans('commands.database.connect.help'));
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $message = $this->getMessageHelper();
        $database = $input->getArgument('database');

        $databaseConnection = $this->resolveConnection($message, $database, $output);

        $connection = sprintf(
            '%s -A --database=%s --user=%s --password=%s --host=%s --port=%s',
            $databaseConnection['driver'],
            $databaseConnection['database'],
            $databaseConnection['username'],
            $databaseConnection['password'],
            $databaseConnection['host'],
            $databaseConnection['port']
        );

        $message->showMessage(
            $output,
            sprintf(
                $this->trans('commands.database.connect.messages.connection'),
                $connection
            )
        );
    }
}
