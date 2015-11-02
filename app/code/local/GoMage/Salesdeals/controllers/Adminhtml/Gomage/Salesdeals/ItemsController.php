<?php

/**
 * GoMage Sales and Deals Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2015 GoMage (http://www.gomage.com)
 * @author       GoMage
 * @license      http://www.gomage.com/license-agreement/  Single domain license
 * @terms of use http://www.gomage.com/terms-of-use
 * @version      Release: 1.2
 * @since        Class available since Release 1.2
 */
class GoMage_Salesdeals_Adminhtml_Gomage_Salesdeals_ItemsController extends Mage_Adminhtml_Controller_Action
{

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('promo/gomage_salesdeals/gomage_manage_salesdeals');
    }

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('promo/gomage_salesdeals')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Product Deals'), Mage::helper('adminhtml')->__('Product Deals'));

        return $this;
    }

    public function indexAction()
    {
        $this->_initAction();
        $this->renderLayout();

    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {

            try {

                $data = $this->_filterPostData($data);

                $id = $this->getRequest()->getParam('id');

                $model = Mage::getModel('gomage_salesdeals/item');

                $model->setData($data)->setId($id)->save();

                $product        = Mage::getModel('catalog/product')->load($model->getData('product_id'));
                $category_ids   = $product->getCategoryIds();
                $stores_cat_ids = array();
                foreach ($product->getStoreIds() as $store_id) {
                    $store = Mage::getModel('core/store')->load($store_id);
                    if ($store && $store->getRootCategoryId() && !in_array($store->getRootCategoryId(), $stores_cat_ids)) {
                        $stores_cat_ids[] = $store->getRootCategoryId();
                    }

                }
                if (count($stores_cat_ids)) {
                    $category_ids = array_unique(array_merge($category_ids, $stores_cat_ids));
                    $product->setCategoryIds($category_ids);
                    $product->save();
                }

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('core')->__('Data successfully saved'));

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }

            } catch (Mage_Core_Exception $e) {

                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());

                Mage::getSingleton('core/session')->setSalesdealsData($data);

                if ($model->getId() > 0) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                } else {
                    $this->_redirect('*/*/new');
                }
                return false;

            } catch (Exception $e) {

                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('core')->__('Can\'t save data'));

                Mage::getSingleton('core/session')->setSalesdealsData($data);

                if ($model->getId() > 0) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                } else {
                    $this->_redirect('*/*/new');
                }
                return false;

            }
            $this->_redirect('*/*/');
        }
    }

    public function _filterPostData($data)
    {

        if ($data['start_date']) {
            $data               = $this->_filterDates($data, array('start_date'));
            $data['start_time'] = implode(':', $data['start_time']);
        } else {
            $data['start_date'] = null;
            $data['start_time'] = null;
        }

        if ($data['end_date']) {
            $data             = $this->_filterDates($data, array('end_date'));
            $data['end_time'] = implode(':', $data['end_time']);
        } else {
            $data['end_date'] = null;
            $data['end_time'] = null;
        }

        return $data;
    }

    public function deleteAction()
    {

        if ($id = intval($this->getRequest()->getParam('id'))) {

            $this->_deleteItems(array($id));

        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {

        if ($ids = $this->getRequest()->getParam('id')) {
            if (is_array($ids) && !empty($ids)) {
                $this->_deleteItems($ids);
            }

        }

        $this->_redirect('*/*/');

    }

    protected function _deleteItems($ids)
    {
        if (is_array($ids) && !empty($ids)) {
            foreach ($ids as $id) {

                $item = Mage::getModel('gomage_salesdeals/item')->load($id);
                $item->delete();

            }
        }
    }

    public function newAction()
    {
        $this->_initAction();
        if ($data = Mage::getSingleton('core/session')->getSalesdealsData()) {
            Mage::register('gomage_salesdeals', Mage::getModel('gomage_salesdeals/item')->addData($data));
            Mage::getSingleton('core/session')->setSalesdealsData(null);
        }

        $this->_addContent($this->getLayout()->createBlock('gomage_salesdeals/adminhtml_items_edit'))
            ->_addLeft($this->getLayout()->createBlock('gomage_salesdeals/adminhtml_items_edit_tabs'));

        $this->renderLayout();

    }

    public function editAction()
    {

        $this->_initAction();

        if ($id = $this->getRequest()->getParam('id')) {
            Mage::register('gomage_salesdeals', Mage::getModel('gomage_salesdeals/item')->load($id));
        }

        $this->_addContent($this->getLayout()->createBlock('gomage_salesdeals/adminhtml_items_edit'))
            ->_addLeft($this->getLayout()->createBlock('gomage_salesdeals/adminhtml_items_edit_tabs'));

        $this->renderLayout();

    }

    public function getProductQtyAction()
    {
        $result        = array();
        $result['qty'] = 0;

        if ($id = $this->getRequest()->getParam('product_id')) {

            $product = Mage::getModel('catalog/product')->load($id);

            if ($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_SIMPLE) {
                $result['qty'] = min(array($product->getStockItem()->getMaxSaleQty(), $product->getStockItem()->getQty()));
            } else {
                $result['qty'] = $product->getStockItem()->getMaxSaleQty();
            }

        }

        echo Zend_Json::encode($result);

    }


}