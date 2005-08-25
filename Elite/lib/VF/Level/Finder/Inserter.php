<?php

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

    function save($requestedSaveId=null)
    {
	$this->requestedSaveId = $requestedSaveId;

	if ($this->getSchema()->isGlobal($this->entity->getType()))
	{
	    $id = $this->entity->getId();
	    $existingId = $this->levelFinder()->findEntityIdByTitle($this->entity->getType(), $this->entity->getTitle());
	    if (false == $existingId)
	    {
		$this->getReadAdapter()->insert($this->entity->getTable(), $this->getBind());

		$id = $this->getReadAdapter()->lastInsertId();
		$this->entity->setId($id);
	    } else
	    {
		$this->entity->setId($existingId);
	    }
	    $this->createVehicleDefinition();
	    return $id;
	} else
	{
	    if (is_array($this->parent_id))
	    {
		$prevLevel = $this->getSchema()->getPrevLevel($this->entity->getType());
		$parent_id = $this->parent_id[$prevLevel];
	    } else
	    {
		$parent_id = $this->parent_id;
	    }
	    $existingId = $this->levelFinder()->findEntityIdByTitle($this->entity->getType(), $this->entity->getTitle(), $parent_id);
	    if (!$existingId)
	    {
		$this->getReadAdapter()->insert($this->inflect($this->entity->getTable()), $this->getBind());
	    }
	}

	$id = $existingId ? $existingId : $this->getReadAdapter()->lastInsertId();
	if (!$this->entity->getId())
	{
	    $this->entity->setId($id);
	}

	$this->createVehicleDefinition();
	return $id;
    }

    function createVehicleDefinition()
    {
	if (is_array($this->parent_id))
	{
	    $vehicleFinder = new VF_Vehicle_Finder($this->getSchema());
	    $bind = $this->vehicleBind();
	    if (count($vehicleFinder->findByLevelIds($bind)) == 0)
	    {
		$this->getReadAdapter()->insert('elite_definition', $bind);
	    }
	} else
	{
	    $this->entity->createDefinition($this->parent_id);
	}
    }

    function getBind()
    {
	$bind = array();
	if ($this->requestedSaveId)
	{
	    $bind['id'] = $this->requestedSaveId;
	}

	if ($this->entity->getPrevLevel())
	{
	    $parentKey = $this->entity->getPrevLevel() . '_id';
	    if (is_numeric($this->parent_id) && $this->parent_id)
	    {
		$bind[$this->inflect($parentKey)] = $this->parent_id;
	    }

	    if (is_array($this->parent_id))
	    {
		$bind[$this->inflect($parentKey)] = $this->parent_id[$this->entity->getPrevLevel()];
	    }
	}

	$bind['title'] = $this->entity->getTitle();
	return $bind;
    }

    function vehicleBind()
    {
	$bind = array();
	foreach ($this->parent_id as $level => $val)
	{
	    $bind[$this->inflect($level . '_id')] = $val;
	}
	$bind[$this->inflect($this->entity->getType() . '_id')] = $this->entity->getId();
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
