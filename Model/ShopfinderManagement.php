<?php
declare(strict_types=1);

namespace Hsoni\Shopfinder\Model;

class ShopfinderManagement implements \Hsoni\Shopfinder\Api\ShopfinderManagementInterface
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

