<?php
class UrlShortener_Adminhtml_Block_Urlrewrite_Grid extends Mage_Adminhtml_Block_Urlrewrite_Grid {    
	protected function _prepareCollection() {
		$collection = Mage::getResourceModel('core/url_rewrite_collection')
			->addFieldToFilter('is_viewable',1);
        $this->setCollection($collection);
        return Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();
    }
}

