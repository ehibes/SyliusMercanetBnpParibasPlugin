<?php

/**
 * This file was created by the developers from Waaz.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://www.studiowaaz.com and write us
 * an email on developpement@studiowaaz.com.
 */

namespace Tests\Waaz\SystemPayPlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use Sylius\Behat\Page\Shop\Checkout\CompletePageInterface;
use Sylius\Behat\Page\Shop\Order\ShowPageInterface;
use Tests\Waaz\SystemPayPlugin\Behat\Mocker\SystemPayMocker;
use Tests\Waaz\SystemPayPlugin\Behat\Page\External\SystemPayCheckoutPageInterface;

/**
 * @author Ibes Mongabure <developpement@studiowaaz.com>
 */
final class SystemPayContext implements Context
{
    /**
     * @var SystemPayMocker
     */
    private $systemPayMocker;

    /**
     * @var CompletePageInterface
     */
    private $summaryPage;

    /**
     * @var SystemPayCheckoutPageInterface
     */
    private $systemPayCheckoutPage;

    /**
     * @var ShowPageInterface
     */
    private $orderDetails;

    /**
     * @param CompletePageInterface $summaryPage
     * @param SystemPayMocker $systemPayMocker
     * @param SystemPayCheckoutPageInterface $systemPayCheckoutPage
     * @param ShowPageInterface $orderDetails
     */
    public function __construct(
        SystemPayMocker $systemPayMocker,
        CompletePageInterface $summaryPage,
        SystemPayCheckoutPageInterface $systemPayCheckoutPage,
        ShowPageInterface $orderDetails
    )
    {
        $this->orderDetails = $orderDetails;
        $this->systemPayCheckoutPage = $systemPayCheckoutPage;
        $this->summaryPage = $summaryPage;
        $this->systemPayMocker = $systemPayMocker;
    }

    /**
     * @When I confirm my order with Mercanet Bnp Paribas payment
     * @Given I have confirmed my order with Mercanet Bnp Paribas payment
     */
    public function iConfirmMyOrderWithSystemPayPayment()
    {
        $this->summaryPage->confirmOrder();
    }

    /**
     * @When I sign in to Mercanet Bnp Paribas and pay successfully
     */
    public function iSignInToSystemPayAndPaySuccessfully()
    {
        $this->systemPayMocker->completedPayment(function (){
            $this->systemPayCheckoutPage->pay();
        });
    }

    /**
     * @When I cancel my Mercanet Bnp Paribas payment
     * @Given I have cancelled Mercanet Bnp Paribas payment
     */
    public function iCancelMySystemPayPayment()
    {
        $this->systemPayMocker->canceledPayment(function (){
            $this->systemPayCheckoutPage->cancel();
        });
    }

    /**
     * @When I try to pay again Mercanet Bnp Paribas payment
     */
    public function iTryToPayAgainSystemPayPayment()
    {
        $this->systemPayMocker->completedPayment(function (){
            $this->orderDetails->pay();
        });
    }
}