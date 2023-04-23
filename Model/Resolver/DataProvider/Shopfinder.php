<?php
declare(strict_types=1);

namespace Chalhoub\Shopfinder\Model\Resolver\DataProvider;

use Chalhoub\Shopfinder\Api\Data\ShopfinderInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;

class Shopfinder
{
    /**
     * @var ShopfinderFactory
     */
    protected $shopFinder;

    /**
     * @var ShopfinderRepositoryInterface
     */
    protected $shopfinderRepositoryInterface;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;
    
    /**
     * @param \Chalhoub\Shopfinder\Api\ShopfinderRepositoryInterface $shopfinderRepositoryInterface
     * @param \Chalhoub\Shopfinder\Model\Shopfinder $shopFinder
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Chalhoub\Shopfinder\Api\ShopfinderRepositoryInterface $shopfinderRepositoryInterface,
        \Chalhoub\Shopfinder\Model\ShopfinderFactory $shopFinder,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        $this->shopFinder = $shopFinder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->shopfinderRepositoryInterface = $shopfinderRepositoryInterface;
        $this->storeManager = $storeManager;
    }

    /**
     * @param array $args
     * @return array
     * @throws GraphQlNoSuchEntityException
     */
    public function getShopfinder($args): array
    {
        $searchCriteria = "";
        if (isset($args['identifier'])) 
        {
            $searchCriteria = $this->searchCriteriaBuilder->addFilter('identifier', $args['identifier'], 'eq')->create();
        }elseif(isset($args['shopfinder_id'])) {
            $searchCriteria = $this->searchCriteriaBuilder->addFilter('shopfinder_id', $args['shopfinder_id'], 'eq')->create();
        }
        try{
            $shopList = $this->shopfinderRepositoryInterface->getList($searchCriteria);
            if(count($shopList->getItems()) > 0){
                $shop = current($shopList->getItems());
            }else{
                throw new NoSuchEntityException(__("No Such entity available."));
            }
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        
        return $this->convertShopData($shop);
    }

    /**
     * Shop List
     * @return array
     * @throws GraphQlNoSuchEntityException
     */
    public function getShopfinderList()
    {
        $shopList = $this->shopfinderRepositoryInterface->getList($this->searchCriteriaBuilder->create());
        if(!count($shopList->getItems()) > 0){
            throw new GraphQlNoSuchEntityException(__("No Records available."));
        }

        foreach ($shopList->getItems() as $shop)
        {
            $shopFimders['shoplist'][$shop->getShopfinderId()] = $this->convertShopData($shop);
        }
        return $shopFimders;
    }

    /**
     * Convert Shop data
     *
     * @param ShopfinderInterface $shop
     * @return array
     * @throws NoSuchEntityException
     */
    private function convertShopData(ShopfinderInterface $shop)
    {
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        $shopData = [
            ShopfinderInterface::SHOPFINDER_ID => $shop->getShopfinderId(),
            ShopfinderInterface::SHOP_NAME => $shop->getShopName(),
            ShopfinderInterface::IDENTIFIER => $shop->getIdentifier(),
            ShopfinderInterface::COUNTRY => $shop->getCountry(),
            ShopfinderInterface::IMAGE => $mediaUrl . 'shops/' .$shop->getImage(),
            ShopfinderInterface::LONGITUDE => $shop->getLongitude(),
            ShopfinderInterface::LATITUDE => $shop->getLatitude()
        ];
        return $shopData;
    }
    
    /**
     * Update Shop Details
     * @param array $args
     * @return array
     * @throws GraphQlNoSuchEntityException
     */
    public function updateShopfinder($input): array
    {
        if (isset($input['shopfinder_id'])) 
        {
            $shop = $this->shopFinder->create()->load($input['shopfinder_id']);
        }elseif(isset($input['identifier'])) {
            $shop = $this->shopFinder->create()->load($input['identifier'], 'identifier');
        }
        
        if(!$shop->getShopfinderId()){
            throw new GraphQlNoSuchEntityException(__("Shop couldn't found with identifier."));
        }
        try{
            $shop->setData($input)->save();
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        $response['message'] = __("Shop details are updated sucessfully!");
        return $response;
    }
}
