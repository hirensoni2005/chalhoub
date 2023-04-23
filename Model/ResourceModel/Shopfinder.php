<?php
declare(strict_types=1);

namespace Chalhoub\Shopfinder\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Shopfinder extends AbstractDb
{

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('shopfinder', 'shopfinder_id');
    }
}

