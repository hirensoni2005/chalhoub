<?php
declare(strict_types=1);

namespace Hsoni\Shopfinder\Controller\Adminhtml\Shopfinder;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var ShopfinderFactory
     */
    protected $shopFinder;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \Hsoni\Shopfinder\Model\Shopfinder $shopFinder
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Hsoni\Shopfinder\Model\ShopfinderFactory $shopFinder
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->shopFinder	 = $shopFinder;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('shopfinder_id');
        
            $model = $this->shopFinder->create()->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Shop no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
        
            $model->setData($data);

            if (isset($data['image'])) {
                $shopImage = $data['image'][0]['name'];
				$model->setData('image', $shopImage);
            }
        
            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Shop.'));
                $this->dataPersistor->clear('chalhoub_shopfinder_shopfinder');
        
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['shopfinder_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Shop.'));
            }
        
            $this->dataPersistor->set('chalhoub_shopfinder_shopfinder', $data);
            return $resultRedirect->setPath('*/*/edit', ['shopfinder_id' => $this->getRequest()->getParam('shopfinder_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}

