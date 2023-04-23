<?php
declare(strict_types=1);

namespace Chalhoub\Shopfinder\Api\Data;

interface ShopfinderInterface
{

    const SHOP_NAME = 'shop_name';
    const SHOPFINDER_ID = 'shopfinder_id';
    const IDENTIFIER = 'identifier';
    const COUNTRY = 'country';
    const IMAGE = 'image';
    const LONGITUDE = 'longitude';
    const LATITUDE = 'latitude';

    /**
     * Get shopfinder_id
     * @return string|null
     */
    public function getShopfinderId();

    /**
     * Set shopfinder_id
     * @param string $shopfinderId
     * @return \Chalhoub\Shopfinder\Shopfinder\Api\Data\ShopfinderInterface
     */
    public function setShopfinderId($shopfinderId);

    /**
     * Get shop_name
     * @return string|null
     */
    public function getShopName();

    /**
     * Set shop_name
     * @param string $shopName
     * @return \Chalhoub\Shopfinder\Shopfinder\Api\Data\ShopfinderInterface
     */
    public function setShopName($shopName);

    /**
     * Get identifier
     * @return string|null
     */
    public function getIdentifier();

    /**
     * Set identifier
     * @param string $identifier
     * @return \Chalhoub\Shopfinder\Shopfinder\Api\Data\ShopfinderInterface
     */
    public function setIdentifier($identifier);

    /**
     * Get country
     * @return string|null
     */
    public function getCountry();

    /**
     * Set country
     * @param string $country
     * @return \Chalhoub\Shopfinder\Shopfinder\Api\Data\ShopfinderInterface
     */
    public function setCountry($country);

    /**
     * Get image
     * @return string|null
     */
    public function getImage();

    /**
     * Set image
     * @param string $image
     * @return \Chalhoub\Shopfinder\Shopfinder\Api\Data\ShopfinderInterface
     */
    public function setImage($image);

    /**
     * Get longitude
     * @return string|null
     */
    public function getLongitude();

    /**
     * Set longitude
     * @param string $longitude
     * @return \Chalhoub\Shopfinder\Shopfinder\Api\Data\ShopfinderInterface
     */
    public function setLongitude($longitude);

    /**
     * Get latitude
     * @return string|null
     */
    public function getLatitude();

    /**
     * Set latitude
     * @param string $latitude
     * @return \Chalhoub\Shopfinder\Shopfinder\Api\Data\ShopfinderInterface
     */
    public function setLatitude($latitude);
}

