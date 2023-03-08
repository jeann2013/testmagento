<?php

namespace Training\CLI\Console\Command;

use Magento\Store\Model\StoreManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class WebsiteList
 * @package Shkilya\WebsiteList\Console
 */
class WebsiteList extends Command
{


    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * WebsiteList constructor.
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        parent::__construct();
        $this->storeManager = $storeManager;
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName('website:website-list')
            ->setDescription('Website list');

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null|int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Websites</info>');
        foreach ($this->storeManager->getWebsites(true) as $website) {
            $output->writeln($website->getName());
        }
        $output->writeln('<info>Stores</info>');
        foreach ($this->storeManager->getGroups(true) as $store) {
            $output->writeln($store->getName());
        }
        $output->writeln('<info>Store views</info>');
        foreach ($this->storeManager->getStores(true) as $storeView) {
            $output->writeln($storeView->getName());
        }
    }
}
