<?php
declare(strict_types=1);

namespace Hsoni\Shopfinder\Ui\Component\Listing\Column;

use Magento\Catalog\Helper\Image;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class ImageThumbnail extends Column
{
    /**
     * @var string
     */
    protected string $subDir = 'shops';

    public const ALT_FIELD = 'title';

    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Image $imageHelper
     * @param UrlInterface $urlBuilder
     * @param StoreManagerInterface $storeManager
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface      $context,
        UiComponentFactory    $uiComponentFactory,
        Image                 $imageHelper,
        UrlInterface          $urlBuilder,
        StoreManagerInterface $storeManager,
        array                 $components = [],
        array                 $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->imageHelper = $imageHelper;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     * @throws NoSuchEntityException
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $url = '';
                if ($item[$fieldName] != '') {
                    $url = $this->storeManager->getStore()->getBaseUrl(
                        UrlInterface::URL_TYPE_MEDIA
                    ) . $this->subDir . "/" . $item[$fieldName];
                }
                $item[$fieldName . '_src'] = $url;
                $item[$fieldName . '_alt'] = $this->getAlt($item) ?: '';
                $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                    'chalhoub_shopfinder/shopfinder/edit',
                    ['shopfinder_id' => $item['shopfinder_id']]
                );
                $item[$fieldName . '_orig_src'] = $url;
            }
        }

        return $dataSource;
    }

    /**
     * @param array $row
     *
     * @return null|string
     */
    protected function getAlt($row)
    {
        $altField = $this->getData('config/altField') ?: self::ALT_FIELD;
        return isset($row[$altField]) ? $row[$altField] : null;
    }
}
