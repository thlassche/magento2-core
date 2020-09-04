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

namespace MultiSafepay\ConnectCore\Model\Api\Builder\OrderRequestBuilder\GatewayInfoBuilder;

use Magento\Sales\Api\Data\OrderPaymentInterface;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Ideal;

class IdealGatewayInfoBuilder
{
    /**
     * @var Ideal
     */
    private $ideal;

    /**
     * GatewayInfo constructor.
     *
     * @param Ideal $ideal
     */
    public function __construct(
        Ideal $ideal
    ) {
        $this->ideal = $ideal;
    }

    /**
     * @param OrderPaymentInterface $payment
     * @return Ideal
     */
    public function build(OrderPaymentInterface $payment): Ideal
    {
        return $this->ideal->addIssuerId($payment->getAdditionalInformation()['issuer_id']);
    }
}