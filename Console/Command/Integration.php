<?php
/**
 * Copyright © Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magmodules\Reloadify\Console\Command;

use Magento\Framework\Console\Cli;
use Magmodules\Reloadify\Api\Config\RepositoryInterface as ConfigRepository;
use Magmodules\Reloadify\Service\WebApi\Integration as CreateToken;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Integration extends Command
{

    public const COMMAND_NAME = 'reloadify:integration';
    public const COMMAND_OPTION_UPDATE = 'update';

    /**
     * @var CreateToken
     */
    private $createToken;

    /**
     * @var ConfigRepository
     */
    private $configRepository;

    public function __construct(
        CreateToken $createToken,
        ConfigRepository $configRepository
    ) {
        $this->createToken = $createToken;
        $this->configRepository = $configRepository;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription('Create or update integration');
        $this->addOption(
            self::COMMAND_OPTION_UPDATE,
            '-u',
            InputOption::VALUE_OPTIONAL,
            'Update token with new version (usage: --update=1)'
        );
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->configRepository->isEnabled()) {
            $output->writeln('<error>Module is not enabled.</error>');
            return Cli::RETURN_FAILURE;
        }

        try {
            $token = $this->createToken->createToken($this->isUpdate($input));
            $output->writeln(sprintf('<info>Integration token: %s</info>', $token));
        } catch (\Throwable $exception) {
            $output->writeln(sprintf('<error>%s</error>', $exception->getMessage()));
            return Cli::RETURN_FAILURE;
        }

        return Cli::RETURN_SUCCESS;
    }

    private function isUpdate(InputInterface $input): bool
    {
        if ($input->getOption(self::COMMAND_OPTION_UPDATE) == 1) {
            return true;
        }

        if ($input->getOption(self::COMMAND_OPTION_UPDATE) == 'true') {
            return true;
        }

        return false;
    }
}
