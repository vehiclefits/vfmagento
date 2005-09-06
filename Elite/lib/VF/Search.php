<?php
class VF_Search implements VF_Configurable
{
    
    /** @var Zend_Controller_Request_Http */
    protected $_request;
    
    /** @var Zend_Config */
    protected $config;
    
    function getProductId()
    {
        return 0;
    }
    
    function getRequest()
    {
        return new Zend_Controller_Request_Http;
    }
    
    /** for testability */
    function setRequest( $request )
    {
        $this->_request = $request;
    }
    
    function getFilter()
    {
        if( !$this->filter instanceof Elite_Vaf_Model_Catalog_Category_Filter )
        {
            $this->filter = new Elite_Vaf_Model_Catalog_Category_FilterImpl();
            $this->filter->setConfig( $this->getConfig() );
        }    
        return $this->filter;
    }
    
    function setFilter( Elite_Vaf_Model_Catalog_Category_Filter $filter )
    {
        $this->filter = $filter;
    }
    
    function getSelected( $level )
    {
        $search = new VF_FlexibleSearch($this->getSchema(),$this->getRequest());
        return $search->getValueForSelectedLevel($level);
    }
    
    function getSearchPostUrl()
    {
        return $this->getUrl( 'vaf/results' );
    }
    
    /** Just delegates for testability purposes */
    function getCategories()
    {
        $this->getChooser()->setConfig( $this->getConfig() );
        return $this->getChooser()->getFilteredCategories( $this->getChooser()->getAllCategories() );
    }
    
    /** Just delegates for testability purposes */
    function getFilteredCategories( array $categories )
    {
        $this->getChooser()->setConfig( $this->getConfig() );
        return $this->getChooser()->getFilteredCategories( $categories ); 
    }
    
    protected function isHomepage()
    {
        return( 'index' == $this->getRequest()->getControllerName() && 'cms' == $this->getRequest()->getRouteName() );
    }
    
    protected function isCmsPage()
    {
        return( 'page' == $this->getRequest()->getControllerName() && 'cms' == $this->getRequest()->getRouteName() );
    }
    
    protected function isProductPage()
    {
        if( 'product' == $this->getRequest()->getControllerName() )
        {
            return true;
        }
        return false;
    }
    
    protected function isCategoryPage()
    {
        if( 'category' == $this->getRequest()->getControllerName() )
        {
            return true;
        }
        return false;
    }
    
    protected function isVafPage()
    {
        if( 'vaf' == $this->getRequest()->getModuleName() )
        {
            return true;
        }
        return false;
    }
    
    protected function isChooseVehiclePage()
    {
        if( 'choosevehicle' == $this->getRequest()->getActionName() )
        {
            return true;
        }
        return false;
    }
    
    /** @return bool if vaf/categoryOnHomepage == true and it is the homepage, show the category chooser */
    function showCategoryChooser()
    {
        $this->getChooser()->setConfig( $this->getConfig() );
        
        if( $this->isHomepage() )
        {
            return $this->getChooser()->showCategoryChooserHomepage();
        }
        else
        {
            return $this->getChooser()->showCategoryChooserNonHomepage();
        }
    }

    /** @return bool if vaf/categoryOnHomepage == true and it is the homepage, show the category chooser */
    function showAllOptionOnCategoryChooser()
    {
        $this->getChooser()->setConfig( $this->getConfig() );
        
        if( $this->isHomepage() )
        {
            return $this->getChooser()->showAllOptionHomepage();
        }
        else
        {
            return $this->getChooser()->showAllOptionAllPages();
        }
    }
    
    function getCategoryChooserAllOptionText()
    {
        $setting = $this->getConfig()->categorychooser->allOptionText;
        if( $setting )
        {
            return $setting;
        }
        return 'All Categories';
    }

    function categoryAction($categoryId)
    {
        if(!$categoryId)
        {
            return;
        }
        $categoryIdsHomepage = explode(',', $this->getConfig()->search->categoriesThatSubmitToHomepage);
        $categoryIdsRefresh = explode(',', $this->getConfig()->search->categoriesThatRefresh);
        if(in_array($categoryId, $categoryIdsHomepage))
        {
            return $this->url('vaf/product/list');
        }
        if(in_array($categoryId, $categoryIdsRefresh))
        {
            return '?';
        }
    }

    function action()
    {
        if($this->categoryAction($this->currentCategoryId()))
        {
            return $this->categoryAction($this->currentCategoryId());
        }
        $submitAction = $this->getConfig()->search->submitAction;
        $submitOnCategoryAction = $this->getConfig()->search->submitOnCategoryAction;
        $submitOnProductAction = $this->getConfig()->search->submitOnProductAction;
        $submitOnHomepageAction = $this->getConfig()->search->submitOnHomepageAction;
        
        if( $this->getConfig()->category->disable )
        {
            return $this->url('vaf/product/list');
        }
    
        if( $this->isCategoryPage() )
        {
            if( $submitOnCategoryAction )
            {
                return $submitOnCategoryAction;
            }
            return '?';
        }

        if( $this->isCmsPage() || ( '' != $submitAction && '' == $submitOnProductAction && '' == $submitOnHomepageAction ) )
        {
            if(  'refresh' == $submitAction )
            {
                return '?';
            }
            
            if ( 'homepagesearch' == $submitAction )
            {
                return $this->url('vaf/product/list');
            }
            
            return $submitAction;
        }
        
        if( '' == $submitAction && '' == $submitOnProductAction && '' == $submitOnHomepageAction )
        {
            return $this->url('vaf/product/list');
        }
        
        if( $this->isProductPage() )
        {
            if( '' == $submitOnProductAction && '' != $submitAction )
            {
                return $submitAction;
            }
            
            if(  'refresh' == $submitOnProductAction )
            {
                return '?';
            }
            
            if ( 'homepagesearch' == $submitOnProductAction )
            {
                return $this->url('vaf/product/list');
            }
            
            return $submitOnProductAction;
        }
        
        if( $this->isHomepage() )
        {
            if( '' == $submitOnHomepageAction && '' != $submitAction )
            {
                return $submitAction;
            }
            
            if(  'refresh' == $submitOnHomepageAction )
            {
                return '?';
            }
            
            if ( 'homepagesearch' == $submitOnHomepageAction )
            {
                return $this->url('vaf/product/list');
            }
            
            return $submitOnHomepageAction;
        }
        
    }
    
    function listEntities( $level )
    {
        if(!in_array($level,$this->getSchema()->getLevels()))
        {
            throw new VF_Level_Exception_InvalidLevel('Invalid level ['.$level.']');
        }
        
        $parent_id = 0;
        
        $parentLevel = $this->getSchema()->getPrevLevel( $level );
        if( $parentLevel )
        {
            $parent_id = $this->getSelected( $parentLevel );
        }
        $levelObject = new VF_Level( $level );
        
        if( $this->isNotRootAndHasNoParent( $level, $parent_id ) )
        {
            return array();
        }
        if( !$parentLevel || !$parent_id )
        {
            return $levelObject->listInUse( array() );
        }
        
        return $levelObject->listInUse( array($parentLevel=>$parent_id) );
    }
    
    function isNotRootAndHasNoParent( $level, $parent_id )
    {
        return $this->getSchema()->getRootLevel() != $level && $parent_id == 0;
    }
    
    /** @return array */
    function getRequestLevels()
    {
        $levels = array();
        $displayLevels = $this->getLevels();
        foreach( $displayLevels as $level )
        {
            $search = new VF_FlexibleSearch($this->getSchema(),$this->getRequest());
            $val = $search->getValueForSelectedLevel( $level );
            if( !is_null( $val ) )
            {
                $levels[ $level ] = $val;
            }
        }
        return $levels;
    }

    function currentCategoryId()
    {
        return $this->current_category_id;
    }

    function setCurrentCategoryId($id)
    {
        $this->current_category_id = $id;
    }
    
    function shouldShow( $categoryId )
    {
        if( $this->isChooseVehiclePage() )
        {
            return false;
        }
        if( Elite_Vaf_Helper_Data::getInstance()->getConfig()->category->disable && !$this->isHomepage() && !$this->isVafPage() )
        {
            return false;
        }
        if (!$this->getTemplate()) {
            return false;
        }
        if( !$this->categoryEnabled( $categoryId ) )
        {
            return false;
        }
        return true;
    }
    
    function categoryEnabled( $categoryId )
    {
        if( !$categoryId )
        {
            return true;
        }
        return $this->getFilter()->shouldShow( $categoryId );
    }

    function getHeaderText()
    {
        return $this->translate('Search By Vehicle');
    }
    
    function getSubmitText()
    {
        return $this->translate('Search');
    }
    
    function getLevels()
    {
        $schema = new VF_Schema();
        $schema->setConfig( $this->getConfig() );
        return $schema->getLevels();
    }
    
    /** @return Elite_Vaf_Block_Search_CategoryChooser */
    function getChooser()
    {
        return $this->chooser;
    }
    
    function showClearButton()
    {
        if( isset($this->getConfig()->search->clearButton) && 'hide' === $this->getConfig()->search->clearButton )
        {
            return false;
        }
        return true;
    }
    
    function showSearchButton()
    {
        if( isset($this->getConfig()->search->searchButton) && 'hide' === $this->getConfig()->search->searchButton )
        {
            return false;
        }
        return true;
    }
    
    function clearButton()
    {
        if( 'link' === $this->getConfig()->search->clearButton )
        {
            return 'link';
        }
        return 'button';
    }
    
    function searchButton()
    {
        if( 'link' === $this->getConfig()->search->searchButton )
        {
            return 'link';
        }
        return 'button';
    }
    
    function getMethod()
    {
        return 'GET';
    }
    
    function proxyValues()
    {
        ob_start();
        $ignore = array( 'category', 'submitb', 'q', 'category1', 'category2', 'category3', 'category4' );
        $ignore = array_merge( $ignore, $this->getLevels() );
        
        foreach ( $this->getRequest()->getParams() as $key => $value)
        {
            if( is_string( $key ) && is_string( $value ) && !in_array( $key, $ignore ) )
            {
                echo '<input type="hidden" name="' . $this->htmlEscape( $key ) . '" value="' . $this->htmlEscape( $value ) . '" />';
            }
            if( is_array( $value ) )
            {
                foreach( $value as $k=>$v )
                {
                    echo '<input type="hidden" name="' . $this->htmlEscape( $key ) . '[' . $this->htmlEscape( $k ) . ']" value="' . $this->htmlEscape( $v ) . '" />';
                }
            }
        }
        return ob_get_clean();
    }

    function getFlexibleDefinition()
    {
        return $this->getFlexible()->getFlexibleDefinition();
    }
    
    function shouldShowMyGarageActive()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getConfig()->mygarage->collapseAfterSelection  &&
            $this->getFlexibleDefinition() !== false &&
            $this->formId() == 'vafForm';
    }
    
    function getClearText()
    {
        return $this->__('Clear');
    }
    
    function __()
    {
        $args = func_get_args();
        return $args[0];
    }
    
    function getFlexible()
    {
        $schema = new VF_Schema;
        $flexible = new VF_FlexibleSearch( $schema, $this->getRequest() );
        return $flexible;
    }
    
    function renderCategoryOptions()
    {
        ob_start();
        if( $this->showAllOptionOnCategoryChooser() )
        {
            ?>
            <option value="?"><?=$this->htmlEscape( $this->getCategoryChooserAllOptionText() )?></option>
            <?php
        }
        
        foreach( $this->getCategories( ) as $category )
        {
            ?>
            <option value="<?=$category['url']?>"><?=$category['title']?></option>
            <?php
        }
        return ob_get_clean();
    }

    function getSchema()
    {
        $schema = new VF_Schema();
        $schema->setConfig( $this->getConfig() );
        return $schema;
    }
    
    function renderBefore()
    {
        if( file_exists(ELITE_PATH.'/Vaflogo') )
        {
            $block = new Elite_Vaflogo_Block_Logo;
            return $block->_toHtml();
        }
    }
    
    function formId()
    {
        return 'vafForm';
    }
    
    function loadingStrategy()
    {
        return $this->getConfig()->search->loadingStrategy;
    }
    
    function unavailableSelections()
    {
        return $this->getConfig()->search->unavailableSelections;
    }
    
    function getConfig()
    {
        if( !$this->config instanceof Zend_Config )
        {
            $this->config = Elite_Vaf_Helper_Data::getInstance()->getConfig();
        }
        return $this->config;
    }

    function setConfig( Zend_Config $config )
    {
        $this->config = $config;
    }
    
    function url($url)
    {
        return $url;
    }
}