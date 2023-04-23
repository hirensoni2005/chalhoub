<?php
declare(strict_types=1);

namespace Hsoni\Shopfinder\Model\Resolver;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;

class DeleteShop implements ResolverInterface
{
    /**
     * @var Hsoni\Shopfinder\Model\Resolver\DataProvider\Shopfinder
     */
    private $shopfinderDataProvider;

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
        if (empty($args) || !is_array($args)) {
            throw new GraphQlInputException(__('"input" value should be specified'));
        }
        throw new GraphQlAuthorizationException(__('User is not authorized to delete operation.'));
    }
}
