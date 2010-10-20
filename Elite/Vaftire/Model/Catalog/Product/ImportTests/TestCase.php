<?php
class Elite_Vaftire_Model_Catalog_Product_ImportTests_TestCase extends Elite_Vaf_TestCase
{
	function importer($file)
	{
		 return new Elite_Vaftire_Model_Catalog_Product_ImportTests_TestSubClass($file);
	}
}