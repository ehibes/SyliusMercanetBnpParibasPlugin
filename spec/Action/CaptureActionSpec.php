<?php

/**
 * This file was created by the developers from Waaz.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://www.studiowaaz.com and write us
 * an email on developpement@studiowaaz.com.
 */

namespace spec\Waaz\SystemPayPlugin\Action;

use Waaz\SystemPayPlugin\Action\CaptureAction;
use Waaz\SystemPayPlugin\Bridge\SystemPayBridgeInterface;
use Waaz\SystemPayPlugin\Legacy\Mercanet;
use Payum\Core\Model\Token;
use Payum\Core\Payum;
use Payum\Core\Reply\HttpResponse;
use Payum\Core\Request\Capture;
use Payum\Core\Security\GenericTokenFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Order\Model\Order;

/**
 * @author Ibes Mongabure <developpement@studiowaaz.com>
 */
final class CaptureActionSpec extends ObjectBehavior
{
    function let(Payum $payum, SystemPayBridgeInterface $systemPayBridge)
    {
        $this->beConstructedWith($payum, $systemPayBridge);
        $this->setApi($systemPayBridge);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CaptureAction::class);
    }

    function it_executes(
        Capture $request,
        \ArrayObject $arrayObject,
        PaymentInterface $payment,
        Token $token,
        Token $notifyToken,
        Payum $payum,
        GenericTokenFactory $genericTokenFactory,
        Order $order,
        SystemPayBridgeInterface $systemPayBridge,
        Mercanet $mercanet
    )
    {
        $systemPayBridge->getSecretKey()->willReturn('123');
        $systemPayBridge->getEnvironment()->willReturn(Mercanet::TEST);
        $systemPayBridge->getMerchantId()->willReturn('123');
        $systemPayBridge->getKeyVersion()->willReturn('3');
        $systemPayBridge->createMercanet('123')->willReturn($mercanet);
        $payment->getOrder()->willReturn($order);
        $payment->getCurrencyCode()->willReturn('EUR');
        $payment->getAmount()->willReturn(100);
        $notifyToken->getTargetUrl()->willReturn('url');
        $token->getTargetUrl()->willReturn('url');
        $token->getGatewayName()->willReturn('test');
        $token->getDetails()->willReturn([]);
        $genericTokenFactory->createNotifyToken('test', [])->willReturn($notifyToken);
        $payum->getTokenFactory()->willReturn($genericTokenFactory);
        $request->getModel()->willReturn($arrayObject);
        $request->getFirstModel()->willReturn($payment);
        $request->getToken()->willReturn($token);
        $request->setModel(Argument::any())->shouldBeCalled();

        $this
            ->shouldThrow(HttpResponse::class)
            ->during('execute', [$request])
        ;
    }
}
