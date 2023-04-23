<?php
declare(strict_types=1);

namespace Chalhoub\Shopfinder\Model;

class ShopfinderManagement implements \Chalhoub\Shopfinder\Api\ShopfinderManagementInterface
{

    /**
     * {@inheritdoc}
     */
    public function getShopfinder($param)
    {
        return 'hello api GET return the $param ' . $param;
    }

    /**
     * {@inheritdoc}
     */
    public function putShopfinder($param)
    {
        return 'hello api PUT return the $param ' . $param;
    }
}

