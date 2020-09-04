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

namespace MultiSafepay\ConnectCore\Model\Ui\Giftcard;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Asset\Repository as AssetRepository;
use MultiSafepay\ConnectCore\Model\Ui\GenericConfigProvider;

class BoekenbonConfigProvider extends GenericConfigProvider
{
    public const CODE = 'multisafepay_boekenbon';

    /**
     * PayafterConfigProvider constructor.
     *
     * @param AssetRepository $assetRepository
     */
    public function __construct(
        AssetRepository $assetRepository
    ) {
        $this->assetRepository = $assetRepository;
        parent::__construct($assetRepository);
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return self::CODE;
    }

    /**
     * @return string
     * @throws LocalizedException
     */
    public function getImage(): string
    {
        $path = $this->getPath();
        $this->assetRepository->createAsset($path);

        return $this->assetRepository->getUrl($path);
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return 'MultiSafepay_ConnectFrontend::images/giftcard/' . $this->getCode() . '.png';
    }
}