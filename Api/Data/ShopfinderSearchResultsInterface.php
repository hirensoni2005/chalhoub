<?php
declare(strict_types=1);

namespace Hsoni\Shopfinder\Api\Data;

interface ShopfinderSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Shopfinder list.
     * @return \Hsoni\Shopfinder\Api\Data\ShopfinderInterface[]
     */
    public function getItems();

    /**
     * Set shop_name list.
     * @param \Hsoni\Shopfinder\Api\Data\ShopfinderInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

