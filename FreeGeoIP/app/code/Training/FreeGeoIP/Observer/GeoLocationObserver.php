<?php
namespace Training\FreeGeoIP\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Training\FreeGeoIP\Helper\RemoteData;

class GeoLocationObserver implements ObserverInterface
{
    /**
     * @var RemoteAddress
     */
    private $_remote;

    /**
     * @var RemoteData
     */
    private $_remoteData;

    /**
     * GeoLocationObserver constructor.
     *
     * @param RemoteAddress $remote
     * @param RemoteData $remoteData
     */
    public function __construct(
        RemoteAddress $remote,
        RemoteData $remoteData
    ) {
       $this->_remote = $remote;
       $this->_remoteData = $remoteData;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $this->_remoteData->logUserCountry($this->_remote->getRemoteAddress());
    }
}
