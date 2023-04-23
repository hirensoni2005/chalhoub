<?php
declare(strict_types=1);

namespace Chalhoub\Shopfinder\Model\ResourceModel\Shopfinder;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'shopfinder_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \Chalhoub\Shopfinder\Model\Shopfinder::class,
            \Chalhoub\Shopfinder\Model\ResourceModel\Shopfinder::class
        );
    }
}

