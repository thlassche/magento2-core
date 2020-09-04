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

namespace MultiSafepay\ConnectCore\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    public const DEFAULT_PATH_PATTERN = 'multisafepay/general/%s';
    public const TEST_API_KEY = 'test_api_key';
    public const LIVE_API_KEY = 'live_api_key';
    public const API_MODE = 'mode';
    public const DEBUG = 'debug';
    public const ORDER_CONFIRMATION_EMAIL = 'order_confirmation_email';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Config constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param string $field
     * @param null $storeId
     * @return mixed
     */
    public function getValue(string $field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            sprintf(self::DEFAULT_PATH_PATTERN, $field),
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return bool
     */
    public function getMode($storeId = null): bool
    {
        return ((int)$this->getValue(self::API_MODE, $storeId) === 1);
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getApiKey($storeId = null): string
    {
        if (!$this->getMode($storeId)) {
            return (string)$this->getValue(self::TEST_API_KEY, $storeId);
        }
        return (string)$this->getValue(self::LIVE_API_KEY, $storeId);
    }

    /**
     * @param null $storeId
     * @return bool
     */
    public function isDebug($storeId = null): bool
    {
        return (bool)$this->getValue(self::DEBUG, $storeId);
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getOrderConfirmationEmail($storeId = null): string
    {
        return (string)$this->getValue(self::ORDER_CONFIRMATION_EMAIL, $storeId);
    }
}