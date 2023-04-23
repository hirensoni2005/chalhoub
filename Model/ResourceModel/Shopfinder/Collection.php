<?php
declare(strict_types=1);

namespace Hsoni\Shopfinder\Model\ResourceModel\Shopfinder;

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
            \Hsoni\Shopfinder\Model\Shopfinder::class,
            \Hsoni\Shopfinder\Model\ResourceModel\Shopfinder::class
        );
    }
}

