<?php

/**
 * This file was created by the developers from Waaz.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://www.studiowaaz.com and write us
 * an email on developpement@studiowaaz.com.
 */

namespace Waaz\SystemPayPlugin\Legacy;

use Payum\Core\Reply\HttpResponse;

/**
 * @author Ibes Mongabure <developpement@studiowaaz.com>
 * @author Ibes Mongabure <developpement@studiowaaz.com>
 */
final class SimplePayment
{
    /**
     * @var Mercanet|object
     */
    private $mercanet;

    /**
     * @var string
     */
    private $environment;

    /**
     * @var string
     */
    private $merchantId;

    /**
     * @var string
     */
    private $keyVersion;

    /**
     * @var string
     */
    private $amount;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $transactionReference;

    /**
     * @var string
     */
    private $automaticResponseUrl;

    /**
     * @param Mercanet $mercanet
     * @param $merchantId
     * @param $keyVersion
     * @param $environment
     * @param $amount
     * @param $targetUrl
     * @param $currency
     * @param $transactionReference
     * @param $automaticResponseUrl
     */
    public function __construct(
        Mercanet $mercanet,
        $merchantId,
        $keyVersion,
        $environment,
        $amount,
        $targetUrl,
        $currency,
        $transactionReference,
        $automaticResponseUrl
    )
    {
        $this->automaticResponseUrl = $automaticResponseUrl;
        $this->transactionReference = $transactionReference;
        $this->mercanet = $mercanet;
        $this->environment = $environment;
        $this->merchantId = $merchantId;
        $this->keyVersion = $keyVersion;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->targetUrl = $targetUrl;
    }

    public function execute()
    {
        $this->resolveEnvironment();

        $this->mercanet->setMerchantId($this->merchantId);
        $this->mercanet->setInterfaceVersion(Mercanet::INTERFACE_VERSION);
        $this->mercanet->setKeyVersion($this->keyVersion);
        $this->mercanet->setAmount($this->amount);
        $this->mercanet->setCurrency($this->currency);
        $this->mercanet->setOrderChannel("INTERNET");
        $this->mercanet->setTransactionReference($this->transactionReference);
        $this->mercanet->setNormalReturnUrl($this->targetUrl);
        $this->mercanet->setAutomaticResponseUrl($this->automaticResponseUrl);

        $this->mercanet->validate();

        $response = $this->mercanet->executeRequest();

        throw new HttpResponse($response);
    }

    /**
     * @throws \InvalidArgumentException
     */
    private function resolveEnvironment()
    {
        if (Mercanet::TEST === $this->environment) {
            $this->mercanet->setUrl(Mercanet::TEST);

            return;
        }

        if (Mercanet::PRODUCTION === $this->environment) {
            $this->mercanet->setUrl(Mercanet::PRODUCTION);

            return;
        }

        if (Mercanet::SIMULATION === $this->environment) {
            $this->mercanet->setUrl(Mercanet::SIMULATION);

            return;
        }

        throw new \InvalidArgumentException(
            sprintf('The "%s" environment is invalid. Expected %s or %s',
                $this->environment, Mercanet::PRODUCTION, Mercanet::TEST)
        );
    }
}
