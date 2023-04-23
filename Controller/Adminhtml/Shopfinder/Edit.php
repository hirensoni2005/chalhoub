<?php
declare(strict_types=1);

namespace Chalhoub\Shopfinder\Controller\Adminhtml\Shopfinder;

class Edit extends \Chalhoub\Shopfinder\Controller\Adminhtml\Shopfinder
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Chalhoub\Shopfinder\Model\ShopfinderFactory
     */
    protected $shopFinder;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Chalhoub\Shopfinder\Model\Shopfinder $shopFinder
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Chalhoub\Shopfinder\Model\ShopfinderFactory $shopFinder
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->shopFinder	 = $shopFinder;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('shopfinder_id');
        $model = $this->shopFinder->create();
        
        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Shopfinder no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('chalhoub_shopfinder', $model);
        
        // 3. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Shop') : __('New Shop'),
            $id ? __('Edit Shop') : __('New Shop')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Shop'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Shop %1', $model->getShopName()) : __('New Shop'));
        return $resultPage;
    }
}

