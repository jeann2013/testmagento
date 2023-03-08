<?php
namespace Training\FreeGeoIP\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\Serialize\SerializerInterface;
use Psr\Log\LoggerInterface;

class RemoteData extends AbstractHelper
{
    /**
     * @var Magento\Framework\HTTP\Client\Curl
     */
    private $rCurl;
    private $rLogger;
    private $rJsonHelper;

    const COUNTRY_API_URL = 'http://www.geoplugin.net/json.gp';

    /**
     * RemoteData constructor.
     *
     * @param Context             $context
     * @param Curl                $curl
     * @param SerializerInterface $jsonHelper
     * @param LoggerInterface     $logger
     */
    public function __construct(
        Context $context,
        Curl $curl,
        SerializerInterface $jsonHelper,
        LoggerInterface $logger
    ) {
        parent::__construct($context);

        $this->rLogger = $logger;
        $this->rCurl = $curl;
        $this->rJsonHelper = $jsonHelper;
    }

    /**
     * Log user Data by IP
     * @param $remoteIp
     */
    public function logUserCountry($remoteIp)
    {
        $remoteIp = '192.158.1.38';
        $this->rCurl->get(self::COUNTRY_API_URL . '?ip=' . $remoteIp);

        $data = $this->getDecodedData($this->rCurl->getBody());

        if ($this->IsCorrectData($data)) {
            $this->rLogger->info('UserInfo', [
                'ip' => $data['geoplugin_request'],
                'code' => $data['geoplugin_countryCode'],
                'name' => $data['geoplugin_countryName'],
            ]);
        } else {
            $this->rLogger->error('UserErrorInfo', [
                'message' => 'Not correct info from api'
            ]);
        }
    }

    /**
     * check correct data for logging
     *
     * @param $data
     * @return bool
     */
    protected function IsCorrectData($data)
    {
        return ($data['geoplugin_request'] ?? false)
            && ($data['geoplugin_countryCode'] ?? false)
            && ($data['geoplugin_countryName'] ?? false);
    }

    /**
     * decode json string
     *
     * @param $json
     * @return array|bool|float|int|string|null
     */
    protected function getDecodedData($json)
    {
        return $this->rJsonHelper->unserialize($json);
    }
}