<?php
/**
 * Copyright © Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magmodules\Reloadify\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Customer Fields Option Source model
 */
class CustomerFields implements OptionSourceInterface
{

    public const TELEPHONE = 'telephone';
    public const STREET = 'street';
    public const CITY = 'city';
    public const ZIPCODE = 'zipcode';
    public const PROVINCE = 'province';
    public const COUNTRY_CODE = 'country_code';
    public const COMPANY_NAME = 'company_name';
    public const GENDER = 'gender';
    public const BIRTHDATE = 'birthdate';

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => self::TELEPHONE, 'label' => __('Phone Number')],
            ['value' => self::STREET, 'label' => __('Street Address')],
            ['value' => self::CITY, 'label' => __('City')],
            ['value' => self::ZIPCODE, 'label' => __('Postal/Zip Code')],
            ['value' => self::PROVINCE, 'label' => __('Province/Region')],
            ['value' => self::COUNTRY_CODE, 'label' => __('Country')],
            ['value' => self::COMPANY_NAME, 'label' => __('Company Name')],
            ['value' => self::GENDER, 'label' => __('Gender')],
            ['value' => self::BIRTHDATE, 'label' => __('Date of Birth')]
        ];
    }
}
