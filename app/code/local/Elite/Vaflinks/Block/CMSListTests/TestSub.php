<?php
class Elite_Vaflinks_Block_CMSListTests_TestSub extends Elite_Vaflinks_Block_CMSList {

    function toHtml() {
        return $this->_toHtml();
    }

    function _toHtml() {
        if (!$this->isEnabled()) {
            return;
        }
        ob_start();
        include(MAGE_PATH . '/app/design/frontend/default/default/template/vaflinks/cms-list.phtml');
        return ob_get_clean();
    }

    function htmlEscape($text) {
        return $text;
    }

}