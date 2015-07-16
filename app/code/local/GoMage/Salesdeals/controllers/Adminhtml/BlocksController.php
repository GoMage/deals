<?php

/**
 * GoMage Sales and Deals Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2015 GoMage (http://www.gomage.com)
 * @author       GoMage
 * @license      http://www.gomage.com/license-agreement/  Single domain license
 * @terms of use http://www.gomage.com/terms-of-use
 * @version      Release: 1.1
 * @since        Class available since Release 1.0
 */
class GoMage_Salesdeals_Adminhtml_BlocksController extends Mage_Adminhtml_Controller_Action
{

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('promo/gomage_salesdeals/gomage_manage_deal_blocks');
    }

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('promo/gomage_salesdeals')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Manage Deal Blocks'), Mage::helper('adminhtml')->__('Manage Deal Blocks'));

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

                $model = Mage::getModel('gomage_salesdeals/block');

                $model->setData($data)->setId($id)->save();

                $connection = Mage::getSingleton('core/resource')->getConnection('write');
                $table      = Mage::getSingleton('core/resource')->getTableName('gomage_salesdeals_block_entity');
                $connection->query('delete from ' . $table . ' where block_id=' . (int)$model->getId());

                if (isset($data['in_block_items'])) {
                    $block_items = explode('&', $data['in_block_items']);
                    foreach ($block_items as $block_item) {
                        if ($block_item) {
                            $block_item = explode('=', $block_item);
                            $item       = Mage::getModel('gomage_salesdeals/block_item');
                            $item->setData(array(
                                    'block_id' => $model->getId(),
                                    'item_id'  => $block_item[0],
                                    'position' => $block_item[1],
                                )
                            )->save();
                        }
                    }
                }

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('core')->__('Data successfully saved'));

                if ($this->getRequest()->getParam('back')) {
                    $params = array('id' => $model->getId());
                    if ($this->getRequest()->getParam('store')) {
                        $params['store'] = $this->getRequest()->getParam('store');
                    }
                    $this->_redirect('*/*/edit', $params);
                    return;
                }

            } catch (Mage_Core_Exception $e) {

                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());

                Mage::getSingleton('core/session')->setSalesdealsData($data);

                if ($model->getId() > 0) {
                    $params = array('id' => $model->getId());
                    if ($this->getRequest()->getParam('store')) {
                        $params['store'] = $this->getRequest()->getParam('store');
                    }
                    $this->_redirect('*/*/edit', $params);
                } else {
                    $this->_redirect('*/*/new');
                }
                return false;

            } catch (Exception $e) {

                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('core')->__('Can\'t save data'));

                Mage::getSingleton('core/session')->setSalesdealsData($data);

                if ($model->getId() > 0) {
                    $params = array('id' => $model->getId());
                    if ($this->getRequest()->getParam('store')) {
                        $params['store'] = $this->getRequest()->getParam('store');
                    }
                    $this->_redirect('*/*/edit', $params);
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
        $data['categories']         = (isset($data['categories']) && is_array($data['categories']) ? implode(',', $data['categories']) : '');
        $data['pages']              = (isset($data['pages']) && is_array($data['pages']) ? implode(',', $data['pages']) : '');
        $data['customer_group_ids'] = (isset($data['customer_group_ids']) && is_array($data['customer_group_ids']) ? implode(',', $data['customer_group_ids']) : '');

        return $data;
    }

    public function deleteAction()
    {

        if ($id = intval($this->getRequest()->getParam('id'))) {

            $this->_deleteBlocks(array($id));

        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {

        if ($ids = $this->getRequest()->getParam('id')) {
            if (is_array($ids) && !empty($ids)) {
                $this->_deleteBlocks($ids);
            }

        }

        $this->_redirect('*/*/');

    }

    protected function _deleteBlocks($ids)
    {
        if (is_array($ids) && !empty($ids)) {
            foreach ($ids as $id) {

                $block = Mage::getModel('gomage_salesdeals/block')->load($id);
                $block->delete();

            }
        }
    }

    public function newAction()
    {
        $this->_initAction();
        if ($data = Mage::getSingleton('core/session')->getSalesdealsData()) {
            Mage::register('gomage_salesdeals_block', Mage::getModel('gomage_salesdeals/block')->addData($data));
            Mage::getSingleton('core/session')->setSalesdealsData(null);
        }

        $this->_addContent($this->getLayout()->createBlock('gomage_salesdeals/adminhtml_blocks_edit'))
            ->_addLeft($this->getLayout()->createBlock('gomage_salesdeals/adminhtml_blocks_edit_tabs'));

        $this->renderLayout();

    }

    public function editAction()
    {

        $this->_initAction();

        if ($id = $this->getRequest()->getParam('id')) {
            Mage::register('gomage_salesdeals_block', Mage::getModel('gomage_salesdeals/block')->load($id));
        }

        $this->_addContent($this->getLayout()->createBlock('gomage_salesdeals/adminhtml_blocks_edit'))
            ->_addLeft($this->getLayout()->createBlock('gomage_salesdeals/adminhtml_blocks_edit_tabs'));

        $this->renderLayout();

    }

    public function gridAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('gomage_salesdeals/adminhtml_blocks_edit_tab_products', 'salesdeals.products.grid')
                ->toHtml()
        );
    }

}