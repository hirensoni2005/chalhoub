<?php
declare(strict_types=1);

namespace Hsoni\Shopfinder\Model\Resolver;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class ShopfinderUpdate implements ResolverInterface
{
    /**
     * @var Hsoni\Shopfinder\Model\Resolver\DataProvider\Shopfinder
     */
    private $shopfinderDataProvider;

    /**
     * @param DataProvider\Shopfinder $shopfinderRepository
     */
    public function __construct(
        \Hsoni\Shopfinder\Model\Resolver\DataProvider\Shopfinder $shopfinderDataProvider
    ) {
        $this->shopfinderDataProvider = $shopfinderDataProvider;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        if (empty($args['input']) || !is_array($args['input'])) {
            throw new GraphQlInputException(__('"input" value should be specified'));
        }
        if (empty($args['input']['identifier']) && empty($args['input']['shopfinder_id'])) {
            throw new GraphQlInputException(__('Shop Identifier is mandatory.'));
        }
        $shopfinderData = $this->shopfinderDataProvider->updateShopfinder($args['input']);
        return $shopfinderData;
    }
}
