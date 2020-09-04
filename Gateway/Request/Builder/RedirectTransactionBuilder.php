<?php
/**
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is provided with Magento in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 *
 */

declare(strict_types=1);

namespace MultiSafepay\ConnectCore\Gateway\Request\Builder;

use Magento\Payment\Gateway\Helper\SubjectReader;
use Magento\Payment\Gateway\Request\BuilderInterface;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\StatusResolver;
use MultiSafepay\ConnectCore\Config\Config;

class RedirectTransactionBuilder implements BuilderInterface
{

    /**
     * @var StatusResolver
     */
    private $statusResolver;

    /**
     * @var Config
     */
    private $config;

    /**
     * RedirectTransactionBuilder constructor.
     *
     * @param StatusResolver $statusResolver
     */
    public function __construct(
        Config $config,
        StatusResolver $statusResolver
    ) {
        $this->config = $config;
        $this->statusResolver = $statusResolver;
    }

    /**
     * @inheritDoc
     */
    public function build(array $buildSubject): array
    {
        $stateObject = $buildSubject['stateObject'];

        $paymentDataObject = SubjectReader::readPayment($buildSubject);
        $payment = $paymentDataObject->getPayment();

        $state = Order::STATE_NEW;
        $orderStatus = $this->statusResolver->getOrderStatusByState($payment->getOrder(), $state);

        $stateObject->setState($state);
        $stateObject->setStatus($orderStatus);

        if ($this->config->getOrderConfirmationEmail() !== 'before_transaction') {
            $stateObject->setIsNotified(false);

            $order = $payment->getOrder();
            $order->setCanSendNewEmailFlag(false);
        }

        return [];
    }
}