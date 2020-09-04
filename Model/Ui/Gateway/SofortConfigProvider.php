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

namespace MultiSafepay\ConnectCore\Model\Ui\Gateway;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\View\Asset\Repository as AssetRepository;
use MultiSafepay\ConnectCore\Model\Ui\GenericConfigProvider;

class SofortConfigProvider extends GenericConfigProvider
{
    public const CODE = 'multisafepay_sofort';

    /**
     * @var ResolverInterface
     */
    private $localeResolver;

    /**
     * PayafterConfigProvider constructor.
     *
     * @param AssetRepository $assetRepository
     * @param ResolverInterface $localeResolver
     */
    public function __construct(
        AssetRepository $assetRepository,
        ResolverInterface $localeResolver
    ) {
        $this->assetRepository = $assetRepository;
        $this->localeResolver = $localeResolver;
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
        if ($this->localeResolver->getLocale() === 'de_DE') {
            return 'MultiSafepay_ConnectFrontend::images/' . $this->getCode() . '-de.png';
        }
        return 'MultiSafepay_ConnectFrontend::images/' . $this->getCode() . '-en.png';
    }
}