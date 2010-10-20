<?php
class Elite_Vafsitemap_Model_Sitemap_Product_XML extends Elite_Vafsitemap_Model_Sitemap_Product
{
    function xml( $storeId, $startRecord, $endRecord )
    {
        $this->storeId = $storeId;
        $products = $this->getCollection();

        $return = '<?xml version="1.0" encoding="UTF-8"?>';
        $return .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        $record = 0;
        
        foreach( $products as $product )
        {
            echo 'product - ' . $product->getId() . "\n";
            foreach( $product->getFitModels() as $vehicle )
            {
                echo '    definition - ' . implode('-',$vehicle->toTitleArray() ) . "\n";
                $record++;
                if( $record >= $startRecord && $record <= $endRecord )
                {
                    $product->setCurrentlySelectedFit( $vehicle );
                    $return .= $this->product($product);
                }
            }
        }
        
        $return .= '</urlset>';
        return $return;
    }
    
    function sitemapIndex($files)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach($files as $file)
        {
           $xml .= '<sitemap>';
              $xml .= '<loc>' . $this->baseUrl($_GET['store']) . $file . '</loc>';
           $xml .= '</sitemap>';
        }
        $xml .= '</sitemapindex>';
        return $xml;
    }
    
    function product($product)
    {
        $return = '<url>';
        $return .= '<loc>'.$this->productUrl($product).'</loc>';
        $return .= '</url>';
        return $return;
    }
    
}