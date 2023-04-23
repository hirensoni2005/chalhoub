<?php
declare(strict_types=1);

namespace Hsoni\Shopfinder\Ui\Component\Form;

use Hsoni\Shopfinder\Model\ResourceModel\Shopfinder\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\UrlInterface;

class DataProvider extends AbstractDataProvider
{

    /**
     * @inheritDoc
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;
	
	/**
     * @var StoreManagerInterface
     */
	protected $storeManager;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
	 * @param UrlInterface $urlBuilder
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
		StoreManagerInterface $storeManager,
		UrlInterface $urlBuilder,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
		$this->storeManager = $storeManager;
		$this->urlBuilder = $urlBuilder;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
		$baseurl =  $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        $items = $this->collection->getItems();
        foreach ($items as $model) {
			$temp = $model->getData();
            $img = [];
			if (isset($temp['image'])) {
				$img[0]['name'] = $temp['image'];
				$img[0]['url'] = $baseurl . 'shops/' . $temp['image'];
				$temp['image'] = $img;
			}else{
				$temp['image'] = null;
			}
            $this->loadedData[$model->getId()] = array_merge($model->getData(), $temp);
        }
        $data = $this->dataPersistor->get('shopfinder');
        
        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('shopfinder');
        }
        return $this->loadedData;
    }
}
