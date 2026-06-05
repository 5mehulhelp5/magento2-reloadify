<?php
/**
 * Copyright © Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magmodules\Reloadify\Console\Command;

use Magento\Framework\Console\Cli;
use Magmodules\Reloadify\Api\Config\RepositoryInterface as ConfigRepository;
use Magmodules\Reloadify\Api\Selftest\RepositoryInterface as SelftestRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Selftest extends Command
{

    public const COMMAND_NAME = 'reloadify:selftest';

    /**
     * @var SelftestRepository
     */
    private $selftestRepository;

    /**
     * @var ConfigRepository
     */
    private $configRepository;

    public function __construct(
        SelftestRepository $selftestRepository,
        ConfigRepository $configRepository
    ) {
        $this->selftestRepository = $selftestRepository;
        $this->configRepository = $configRepository;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription('Perform self test of extension');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->configRepository->isEnabled()) {
            $output->writeln('<error>Module is not enabled.</error>');
            return Cli::RETURN_FAILURE;
        }

        $result = $this->selftestRepository->test();
        foreach ($result as $test) {
            if ($test['result_code'] == 'success') {
                $output->writeln(
                    sprintf(
                        '<info>%s:</info> %s- %s',
                        $test['test'],
                        $test['result_code'],
                        $test['result_msg']
                    )
                );
            } else {
                $output->writeln(
                    sprintf(
                        '<info>%s:</info> <error>%s</error> - %s',
                        $test['test'],
                        $test['result_code'],
                        $test['result_msg']
                    )
                );
            }
        }
        return Cli::RETURN_SUCCESS;
    }
}
