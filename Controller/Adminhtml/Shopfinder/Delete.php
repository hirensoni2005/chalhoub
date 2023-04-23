<?php
declare(strict_types=1);

namespace Chalhoub\Shopfinder\Controller\Adminhtml\Shopfinder;

class Delete extends \Chalhoub\Shopfinder\Controller\Adminhtml\Shopfinder
{
    /**
     * @var ShopfinderFactory
     */
    protected $shopFinder;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Chalhoub\Shopfinder\Model\Shopfinder $shopFinder
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Chalhoub\Shopfinder\Model\ShopfinderFactory $shopFinder
    ) {
        $this->shopFinder = $shopFinder;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('shopfinder_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->shopFinder->create();
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Shop.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['shopfinder_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Shop to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}

