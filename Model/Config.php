<?php

/**
 * @copyright Copyright © 2021 Orba. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\MicroFeatures\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use function explode;

class Config
{
    private ScopeConfigInterface $scopeConfig;

    const XML_PATH_PAYMENT_ACCOUNT_ADMIN_ONLY = 'payment/account/admin_only';
    const XML_PATH_LOGIN_AS_CUSTOMER_GENERAL_SHOPPING_ASSISTANCE_CHECKBOX_NEEDED
        = 'login_as_customer/general/shopping_assistance_checkbox_needed';
    const XML_PATH_CHECKOUT_OPTIONS_ALWAYS_EXPAND_ITEMS_BLOCK = 'checkout/options/always_expand_items_block';
    const XML_PATH_CATALOG_FRONTEND_ENABLE_COMPARISON = 'catalog/frontend/enable_comparison';
    const XML_PATH_CUSTOMER_ADDRESS_TELEPHONE_INPUT_MASK = 'customer/address/telephone_input_mask';
    const XML_PATH_CUSTOMER_ADDRESS_POSTCODE_INPUT_MASK = 'customer/address/postcode_input_mask';

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return string[]
     */
    public function getAdminOnlyPaymentMethods(): array
    {
        $value = $this->scopeConfig->getValue(static::XML_PATH_PAYMENT_ACCOUNT_ADMIN_ONLY);
        if (empty($value)) {
            return [];
        }
        return explode(',', $value);
    }

    public function isShoppingAssistanceCheckboxNeeded(): bool
    {
        return $this->scopeConfig->isSetFlag(
            static::XML_PATH_LOGIN_AS_CUSTOMER_GENERAL_SHOPPING_ASSISTANCE_CHECKBOX_NEEDED
        );
    }

    /**
     * @param null|int|string $storeId
     */
    public function shouldAlwaysExpandItemsBlockOnCheckout($storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            static::XML_PATH_CHECKOUT_OPTIONS_ALWAYS_EXPAND_ITEMS_BLOCK,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null|int|string $storeId
     */
    public function isProductComparisonEnabled($storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            static::XML_PATH_CATALOG_FRONTEND_ENABLE_COMPARISON,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null|int|string $storeId
     */
    public function getTelephoneInputMask($storeId = null): string
    {
        return (string) $this->scopeConfig->getValue(
            static::XML_PATH_CUSTOMER_ADDRESS_TELEPHONE_INPUT_MASK,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null|int|string $storeId
     */
    public function getPostcodeInputMask($storeId = null): string
    {
        return (string) $this->scopeConfig->getValue(
            static::XML_PATH_CUSTOMER_ADDRESS_POSTCODE_INPUT_MASK,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
