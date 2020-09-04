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

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Payment\Gateway\Helper\SubjectReader;
use Magento\Payment\Gateway\Request\BuilderInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Model\Order\Creditmemo\Item;

class ShoppingCartRefundRequestBuilder implements BuilderInterface
{

    /**
     * @inheritDoc
     * @throws NoSuchEntityException
     */
    public function build(array $buildSubject): array
    {
        $paymentDataObject = SubjectReader::readPayment($buildSubject);
        $payment = $paymentDataObject->getPayment();

        /** @var OrderInterface $order */
        $order = $payment->getOrder();
        $orderId = $order->getIncrementId();

        $creditMemo = $payment->getCreditMemo();

        if ($creditMemo === null) {
            throw new NoSuchEntityException(__('The refund could not be created because the credit memo is missing'));
        }

        $refund = [];

        /** @var Item $item */
        foreach ($creditMemo->getItems() as $item) {
            if (($item->getOrderItem() !== null) && $item->getOrderItem()->getParentItem() !== null) {
                continue;
            }

            if ($item->getQty() > 0) {
                $refund[] = [
                    'sku' => $item->getSku(),
                    'quantity' => (int) $item->getQty()
                ];
            }
        }

        if (!empty($creditMemo->getShippingAmount())) {
            $refund[] = [
                'sku' => 'msp-shipping',
                'quantity' => 1
            ];
        }

        return [
            'payload' => $refund,
            'order_id' => $orderId
        ];
    }
}