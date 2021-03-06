<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace PrestaShop\PrestaShop\Core\Form\ChoiceProvider;

use PrestaShop\PrestaShop\Core\Form\FormChoiceAttributeProviderInterface;
use PrestaShop\PrestaShop\Core\Form\FormChoiceProviderInterface;
use PrestaShop\PrestaShop\Core\Order\OrderStateDataProviderInterface;
use PrestaShop\PrestaShop\Core\Util\ColorBrightnessCalculator;

/**
 * Class OrderStateByIdChoiceProvider provides order state choices with ID values.
 */
final class OrderStateByIdChoiceProvider implements FormChoiceProviderInterface, FormChoiceAttributeProviderInterface
{
    /**
     * @var int language ID
     */
    private $languageId;

    /**
     * @var OrderStateDataProviderInterface
     */
    private $orderStateDataProvider;

    /**
     * @var ColorBrightnessCalculator
     */
    private $colorBrightnessCalculator;

    /**
     * @param int $languageId language ID
     * @param OrderStateDataProviderInterface $orderStateDataProvider
     */
    public function __construct(
        $languageId,
        OrderStateDataProviderInterface $orderStateDataProvider,
        ColorBrightnessCalculator $colorBrightnessCalculator
    ) {
        $this->languageId = $languageId;
        $this->orderStateDataProvider = $orderStateDataProvider;
        $this->colorBrightnessCalculator = $colorBrightnessCalculator;
    }

    /**
     * Get order state choices.
     *
     * @return array
     */
    public function getChoices()
    {
        $orderStates = $this->orderStateDataProvider->getOrderStates($this->languageId);
        $choices = [];

        foreach ($orderStates as $orderState) {
            $choices[$orderState['name']] = $orderState['id_order_state'];
        }

        return $choices;
    }

    /**
     * Get order state choices attributes.
     *
     * @return array
     */
    public function getChoicesAttributes()
    {
        $orderStates = $this->orderStateDataProvider->getOrderStates($this->languageId);
        $attrs = [];

        foreach ($orderStates as $orderState) {
            $attrs[$orderState['name']]['data-background-color'] = $orderState['color'];
            $attrs[$orderState['name']]['data-is-bright'] = $this->colorBrightnessCalculator->isBright($orderState['color']);
        }

        return $attrs;
    }
}
