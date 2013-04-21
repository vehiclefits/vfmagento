<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.
 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Vehicle Fits Free Edition - Copyright (c) 2008-2010 by Vehicle Fits, LLC
 * PROFESSIONAL IDENTIFICATION:
 * "www.vehiclefits.com"
 * PROMOTIONAL SLOGAN FOR AUTHOR'S PROFESSIONAL PRACTICE:
 * "Automotive Ecommerce Provided By Vehicle Fits llc"
 *
 * All Rights Reserved
 * VEHICLE FITS ATTRIBUTION ASSURANCE LICENSE (adapted from the original OSI license)
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the conditions in license.txt are met
 */
class VF_Level_Finder_Inserter extends VF_Level_Finder_Abstract implements VF_Level_Saver
{

    /** @var integer id of the model being saved */
    protected $id;
    /** @var integer */
    protected $parent_id;
    /** @var Elite_Vaf_Model */
    protected $entity;
    protected $requestedSaveId;

    /**
     * @param VF_Level $entity
     * @return VF_Level_Saver
     */
    function __construct(VF_Level $entity, $parent_id = 0)
    {
        $this->entity = $entity;
        $this->parent_id = $parent_id;
    }

    function save($requestedSaveId = null)
    {
        $this->requestedSaveId = $requestedSaveId;

        if ($this->getSchema()->isGlobal($this->entity->getType())) {
            $id = $this->entity->getId();
            $existingId = $this->levelFinder()->findEntityIdByTitle($this->entity->getType(), $this->entity->getTitle());
            if (false == $existingId) {
                $this->getReadAdapter()->insert($this->entity->getTable(), $this->getBind());

                $id = $this->getReadAdapter()->lastInsertId();
                $this->entity->setId($id);
            } else {
                $this->entity->setId($existingId);
            }
            return $id;
        } else {
            $existingId = $this->levelFinder()->findEntityIdByTitle($this->entity->getType(), $this->entity->getTitle());
            if (!$existingId) {
                $this->getReadAdapter()->insert($this->inflect($this->entity->getTable()), $this->getBind());
            }
        }

        $id = $existingId ? $existingId : $this->getReadAdapter()->lastInsertId();
        if (!$this->entity->getId()) {
            $this->entity->setId($id);
        }

        return $id;
    }

    function getBind()
    {
        $bind = array();
        if ($this->requestedSaveId) {
            $bind['id'] = $this->requestedSaveId;
        }

        $bind['title'] = $this->entity->getTitle();
        return $bind;
    }

    function inflect($identifier)
    {
        return str_replace(' ', '_', $identifier);
    }

    function levelFinder()
    {
        return new VF_Level_Finder();
    }

}
