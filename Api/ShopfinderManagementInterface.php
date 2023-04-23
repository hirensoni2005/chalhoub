<?php
declare(strict_types=1);

namespace Hsoni\Shopfinder\Api;

interface ShopfinderManagementInterface
{

    /**
     * GET for shopfinder api
     * @param string $param
     * @return string
     */
    public function getShopfinder($param);

    /**
     * PUT for shopfinder api
     * @param string $param
     * @return string
     */
    public function putShopfinder($param);
}

