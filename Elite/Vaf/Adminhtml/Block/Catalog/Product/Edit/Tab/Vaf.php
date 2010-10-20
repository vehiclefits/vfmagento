<?php
class Elite_Vaf_Adminhtml_Block_Catalog_Product_Edit_Tab_Vaf extends Mage_Adminhtml_Block_Template 
{
    function __construct()
    {
        parent::__construct();
        $this->setTemplate('catalog/product/tab/vaf.phtml');
    }           
    
    function getFits()
    {
         return $this->getProduct()->getFits();
    }
    
    function getProduct()
    {
        $product = Mage::registry('product');
        return $product;
    }
    
    function renderSelections()
    {
        ob_start();
        ?>
        <div class="multiTree-selections" style="height:500px; overflow:auto;">
            <?php
            foreach( $this->getFits() as $fit )
            {
                $leafLevel = Elite_Vaf_Helper_Data::getInstance()->getLeafLevel();
                ?>
                <div class="multiTree-selection">
                    <input type="checkbox" name="vafcheck[]" class="vafcheck" value="<?=$leafLevel?>-<?=$fit->id?>" />
                    <div class="multiTree-value" style="display:none"><?=$leafLevel?>-<?=$fit->id?></div>
                    <a class="multiTree-closeLink" href="#">[ x ]</a>
                    <?php
                    $label = array();
                    $schema = new Elite_Vaf_Model_Schema();
                    foreach( $schema->getLevels() as $level )
                    {
                        $label[] = $this->htmlEscape( $fit->$level );
                    }
                    echo implode( '<span class="multiTree-selection-seperator">&raquo;</span>', $label );
                    ?>
                    
                </div>
                <?php
            }
            ?>
        </div>
        <div class="multiTree-new-selections"></div>
        <div class="multiTree-deleted-selections"></div>
        <br  clear="all" />
        <?php
        return ob_get_clean();
    }
    
    function renderMultiTree()
    {
        ob_start();
        
        $metaData = '{';
            $metaData .= "'ajaxUrl':'" . $this->getUrl('*/vafajax/process') . "',";
            $metaData .= "'quickAddUrl':'" . $this->getUrl('*/definitions/save') . "',";
            $metaData .= "'elementName':'vaf'";
            $metaData .= ", 'initialSelections':[{'level':'3','id':'0','node':{},'path':['','','']}]";
        $metaData .= "}";
        
        ?>
        <div class="field">
            <div class="multiTree <?=$metaData?>">
                <?=$this->renderAvailable()?>
                <br  clear="all" />
                <input type="checkbox" class="vafCheckAll" />  Select All
                <br />
                <a href="#" class="vafDeleteSelected">Delete Selected</a>
                <?=$this->renderSelections()?>
                
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    function renderAvailable()
    {
        ob_start();
        ?>
        <?php
        $schema = new Elite_Vaf_Model_Schema();
        $levels = $schema->getLevels();
        foreach( $levels as $level )
        {
            ?>
            <div class="multiTree-selectContainer" >
                <?=ucfirst($this->htmlEscape($level))?>:<br />
                <?php
                $metadata = "{parent:'" . $schema->getPrevLevel($level) . "', parents:'" . implode(',',$schema->getPrevLevels($level)) . "',  parents_including:'" . implode(',',$schema->getPrevLevelsIncluding($level)) . "' }";
                ?>
                <select class="multiTree-select <?=$level?>Select <?=$metadata?>" multiple="multiple">
                    <?php
                    if( $schema->getRootLevel() == $level )
                    {
                        foreach( $this->listEntities($schema->getRootLevel()) as $entity )
                        {
                            ?>
                            <option value="<?=$entity->getId()?>"><?=$entity->getTitle()?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <br />
                Quick Add:
                <br />
                <input type="text" class="vafQuickAdd vafQuickAdd_<?=$level?> {level:'<?=$level?>'}" name="vafQuickAdd_<?=$level?>" />
                <input type="button" class="vafQuickAddSubmit vafQuickAddSubmit_<?=$level?> {level:'<?=$level?>'}" name="vafQuickAddSubmit_<?=$level?>" value="+" />
                <br />
                <span class="multiTree-levelName" style="display:none;"><?=$level?></span>
            </div>
            <?php
        }
        ?>
        <input class="multiTree-Add" type="button" value="Add +" />
        <?php
        return ob_get_clean();
    }
    
    function renderConfigurations()
    {
        $return = '';
        if( file_exists(ELITE_PATH.'/Vafwheel') )
        {
            $this->setScriptPath($this->designScriptPath());
            $html = $this->fetchView($this->myGetTemplateFile('catalog/product/tab/vaf-wheel.phtml'));
            $return .= $html;
        }
        if( file_exists(ELITE_PATH.'/Vafwheeladapter') )
        {
            $this->setScriptPath($this->designScriptPath());
            $html = $this->fetchView($this->myGetTemplateFile('catalog/product/tab/vaf-wheeladapter.phtml'));
            $return .= $html;
        }
        if( file_exists(ELITE_PATH.'/Vaftire') )
        {
            $this->setScriptPath($this->designScriptPath());
            $html = $this->fetchView($this->myGetTemplateFile('catalog/product/tab/vaf-tire.phtml'));
            $return .= $html;
        }
        return $return;
    }
    
    function designScriptPath()
    {
        return Mage::getBaseDir('design');
    }
    
    function myGetTemplateFile($file)
    {
        $params = array('_relative'=>true);
        $area = $this->getArea();
        if ($area) {
            $params['_area'] = $area;
        }
        $templateName = Mage::getDesign()->getTemplateFilename($file, $params);
        return $templateName;
    }
    
    function listEntities( $type, $parent_id = 0 )
    {
        $entity = new Elite_Vaf_Model_Level( $type );
        return $entity->listAll( $parent_id );              
    }
}
