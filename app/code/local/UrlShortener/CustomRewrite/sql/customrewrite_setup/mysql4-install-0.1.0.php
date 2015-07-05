<?php

$installer = $this;

$installer->startSetup();

$installer->run("
ALTER TABLE {$this->getTable('core_url_rewrite')}
	ADD `is_viewable` TINYINT( 1 ) UNSIGNED NULL DEFAULT '1' 
	AFTER `is_system` ;
");

$installer->endSetup(); 
