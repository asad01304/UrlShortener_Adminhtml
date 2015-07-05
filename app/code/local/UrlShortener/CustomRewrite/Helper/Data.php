<?php

class UrlShortener_CustomRewrite_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getProductShortUrl($productId)
	{
		$shouldRemove = true; //should use backend conf value
		$subDomPattern = "/w{3}\.{1}/"; //should use backend conf value
		
		$product = Mage::getModel('catalog/product')->load($productId);
		$urls = Mage::getModel('core/url_rewrite')
			->getCollection()
			->addFieldToFilter('store_id',$product->getStoreId())
			->addFieldToFilter('id_path','product/'.$product->getId())
			->addFieldToFilter('request_path',base64_encode($product->getId()))
			->addFieldToFilter('target_path',$product->getUrlPath())
			->addFieldToFilter('is_system',0)
			->addFieldToFilter('is_viewable',0)
			->addFieldToFilter('options','RP');
		
		if($urls->count() <= 0) {
			Mage::getModel('core/url_rewrite')
				->setStoreId($product->getStoreId())
				->setIdPath('product/'.$product->getId())
				->setRequestPath(base64_encode($product->getId()))
				->setTargetPath($product->getUrlPath())
				->setIsSystem(0)
				->setIsViewable(0)
				->setOptions('RP')
				->save();
		}
		$productShortUrl = Mage::getUrl('',array('_nosid'=>true)).base64_encode($product->getId());
		
		$patterns = array('/http:\/\//', '/https:\/\//');
		$replacements = array('', '');
		$shortUrl = preg_replace($patterns, $replacements, $productShortUrl);
		if($shouldRemove && !Mage::getStoreConfigFlag('web/url/redirect_to_base')) {
			return preg_replace($subDomPattern,'',$shortUrl);
		}		
		return $shortUrl;
	}
}