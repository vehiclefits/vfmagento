<?php

class Elite_Vaflogo_Block_LogoTests_MMYTest extends Elite_Vaf_TestCase {

    function doSetUp() {
        $this->switchSchema('make,model,year');
    }

    function testShouldGetSelectionPart() {
        $vehicle = $this->createMMY('Honda', 'Civic', '2000');
        $block = new Elite_Vaflogo_Block_Logo;
        $this->setRequestParams($vehicle->toValueArray());
        $this->assertEquals('Honda', $block->selectionPart(), 'should get selection part from selection');
    }

    function testShouldActivateOnPartialSelection() {
        return $this->markTestIncomplete();
    }

    function testSelectionTokenShouldBeInUpperCase() {
        $vehicle = $this->createMMY('Honda', 'Civic', '2000');
        $block = new Elite_Vaflogo_Block_Logo;
        $this->setRequestParams($vehicle->toValueArray());
        $this->assertEquals('HONDA', $block->selectionToken(), 'selection token should be in UPPER CASE');
    }

    function testShouldDisable() {
        return $this->markTestIncomplete();
    }

    function testShouldReturnImageTag() {
        $vehicle = $this->createMMY('Honda', 'Civic', '2000');
        $block = new Elite_Vaflogo_Block_Logo;
        $this->setRequestParams($vehicle->toValueArray());
        $this->assertEquals('<img class="vafLogo" src="/logos/HONDA.PNG" />', $block->_toHtml());
    }

}