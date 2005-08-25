<?php
class VF_FlexibleSearch implements VF_FlexibleSearch_Interface
{

    protected $schema;
    protected $request;
    protected $config;

    function __construct(VF_Schema $schema, Zend_Controller_Request_Abstract $request)
    {
	$this->schema = $schema;
	$this->request = $request;
    }

    function getLevel()
    {
	// multi tree integration
	if ($this->getRequest()->getParam('fit'))
	{
	    return $this->schema->getLeafLevel();
	}

	if (!$this->hasGETRequest() && !$this->hasSESSIONRequest())
	{
	    return false;
	}

	$last = false;
	foreach ($this->schema->getLevels() as $level)
	{
	    if ($this->hasGETRequest() && !$this->requestingGETLevel($level))
	    {
		break;
	    }

	    if ($this->hasSESSIONRequest() && !$this->requestingSESSIONLevel($level))
	    {
		break;
	    }
	    $last = $level;
	}
	return $last;
    }

    function hasRequest()
    {
	return $this->hasGETRequest() || $this->hasSESSIONRequest();
    }

    function hasSESSIONRequest()
    {
	foreach ($this->schema->getLevels() as $level)
	{
	    if ($this->requestingSESSIONLevel($level))
	    {
		return true;
	    }
	}
	return false;
    }

    function hasGETRequest()
    {
	foreach ($this->schema->getLevels() as $level)
	{
	    if ($this->requestingGETLevel($level))
	    {
		return true;
	    }
	}
	return false;
    }

    function shouldClear()
    {
	$shouldClear = true;
	foreach ($this->schema->getLevels() as $level)
	{
	    if ('0' !== (string) $this->getRequest()->getParam($level))
	    {
		$shouldClear = false;
	    }
	}
	return $shouldClear;
    }

    protected function getId()
    {
	// multi tree integration
	if ($fit = $this->getRequest()->getParam('fit'))
	{
	    return $fit;
	}

	$level = $this->getLevel();

	if ($this->request->getParam($level))
	{
	    return $this->request->getParam($level);
	}

	if (isset($_SESSION[$level]))
	{
	    return $_SESSION[$level];
	}
    }

    function vehicleSelection()
    {
        if($this->shouldClear())
        {
            $this->clearSelection();
            return new VF_Vehicle_Selection(array());
        }
        
        $vehicleFinder = new VF_Vehicle_Finder($this->schema);
        
        // Multi-tree (admin panel) integration
        if($this->request->getParam('fit'))
        {
            $id = $this->getId();
            if (!$id)
            {
                return false;
            }
            return $vehicleFinder->findByLevel($this->getLevel(), $id);
        }
        
        if(!$this->hasGETRequest() && !$this->hasSESSIONRequest())
        {
            return new VF_Vehicle_Selection(array());
        }

        // front-end lookup
        try
	{
            $params = $this->vehicleRequestParams();
            if(isset($params['year_start']) && isset($params['year_end']))
            {
                $vehicles = $vehicleFinder->findByRangeIds($params);
                //print_r($vehicles); exit();
            }
            else
            {
                $vehicles = $vehicleFinder->findByLevelIds($params, VF_Vehicle_Finder::EXACT_ONLY);
            }
            $selection = new VF_Vehicle_Selection($vehicles);
            return $selection;
	} catch (Elite_Vaf_Exception_DefinitionNotFound $e)
	{
	    return false;
	}
    }
    
    function vehicleRequestParams()
    {
        $requestParams = $this->request->getParams();
        $return = array();
        foreach($this->schema->getLevels() as $level)
        {
            if(isset($_SESSION[$level.'_start']) && isset($_SESSION[$level.'_end']))
            {
                $return[$level.'_start'] = $_SESSION[$level.'_start'];
                $return[$level.'_end'] = $_SESSION[$level.'_end'];
            }
            else if(isset($_SESSION[$level]) && (int)$_SESSION[$level])
            {
                $return[$level] = $_SESSION[$level];
            }
            else if(isset($requestParams[$level.'_start']) && isset($requestParams[$level.'_end']))
            {
                $return[$level.'_start'] = $requestParams[$level.'_start'];
                $return[$level.'_end'] = $requestParams[$level.'_end'];
            }
            else if(isset($requestParams[$level]) && (int)$requestParams[$level])
            {
                $return[$level] = $requestParams[$level];
            }
            else
            {
                $return[$level] = 0;
            }
        }
        
        return $return;
    }

    function requestingLevel($level)
    {
	if ($this->hasGETRequest())
	{
	    return (bool) $this->requestingGETLevel($level);
	}

	return (bool) $this->requestingSESSIONLevel($level);
    }

    function requestingGETLevel($level, $zeroIsValid = false)
    {
	$val = $this->request->getParam($level);
	if (!$zeroIsValid && !$val)
	{
	    return false;
	}
	return is_numeric($val);
    }

    function requestingSESSIONLevel($level)
    {
	return isset($_SESSION[$level]) && (int) $_SESSION[$level];
    }

    function setRequest($request)
    {
	$this->request = $request;
    }

    function getRequest()
    {
	return $this->request;
    }

    function getRequestValues()
    {
	$values = array();
	foreach ($this->schema->getLevels() as $level)
	{
	    $values[$level] = $this->getRequest()->getParam($level);
	}
	return $values;
    }

    function getRequestLeafValue()
    {
	$values = $this->getRequestValues();
	return $values[$this->schema->getLeafLevel()];
    }

    function getValueForSelectedLevel($level)
    {
	// multi tree integration
	if ($fit = $this->getRequest()->getParam('fit'))
	{
	    return $fit;
	}

	if (is_numeric($this->getRequest()->getParam($level)))
	{
	    return $this->getRequest()->getParam($level);
	}
	if (!$this->hasGETRequest() && isset($_SESSION[$level]))
	{
	    return $_SESSION[$level];
	}
	return false;
    }

    function doGetProductIds()
    {
	if ($this->vehicleSelection()->isEmpty())
	{
	    return array();
	}

	$level = $this->getLevel();
	$where = ' `universal` = 1 ';
	$where .= 'OR (';
	foreach ($this->schema()->getLevels() as $level_type)
	{
	    $id = (int) $this->vehicleSelection()->getLevel($level_type)->getId();
	    if (!$id)
	    {
		continue;
	    }

	    if ($level_type != $this->schema()->getRootLevel())
	    {
		$where .= ' && ';
	    }
	    $where .= sprintf(' `%s_id` = %d  ', $level_type, $id);
	}
	$where .= ')';
        
	$rows = $this->getReadAdapter()->fetchAll("SELECT distinct( entity_id ) FROM elite_mapping WHERE  $where");

	if (count($rows) == 0)
	{
	    return array(0);
	}

	foreach ($rows as $r)
	{
	    $ids [] = $r['entity_id'];
	}
	return $ids;
    }

    /**
     * store paramaters in the session
     * @return integer fit_id
     */
    function storeFitInSession()
    {
	if(!$this->shouldStoreVehicleInSession())
	{
	    return;
	}
        
	if ($this->hasGETRequest())
	{
	    foreach ($this->schema()->getLevels() as $level)
	    {
                if($this->getValueForSelectedLevel($level.'_start'))
                {
                    $_SESSION[$level.'_start'] = $this->getValueForSelectedLevel($level.'_start');
                    $_SESSION[$level.'_end'] = $this->getValueForSelectedLevel($level.'_end');
                }
                else
                {
                    $_SESSION[$level] = $this->getValueForSelectedLevel($level);
                }
	    }

	    if (!isset($_SESSION['garage']))
	    {
		$_SESSION['garage'] = new Elite_Vafgarage_Model_Garage;
	    }
	    $_SESSION['garage']->addVehicle($this->getRequestValues());

	    $leafVal = $this->getValueForSelectedLevel($this->schema()->getLeafLevel());
	    if ($leafVal)
	    {
		return $leafVal;
	    }
	}

	if ($this->shouldClear())
	{
	    $this->clearSelection();
	}

	return $this->getValueForSelectedLevel($this->schema()->getLeafLevel());
    }

    function shouldStoreVehicleInSession()
    {
        if (null == $this->getConfig())
        {
            return true;
        }
        if(!isset($this->getConfig()->search->storeVehicleInSession))
        {
            return true;
        }
        if( '' == $this->getConfig()->search->storeVehicleInSession)
        {
            return false;
        }
        if( 'false' == $this->getConfig()->search->storeVehicleInSession)
        {
            return false;
        }        
        if( (bool)$this->getConfig()->search->storeVehicleInSession)
        {
            return true;
        }
        return false;
    }

    function getFlexibleDefinition()
    {
	$this->storeFitInSession();
	try
	{
	    $level = $this->getLevel();
	    $vehicle = $this->vehicleSelection();
	    if (!$vehicle)
	    {
		return false;
	    }

	    $levelObj = $vehicle->getLevel($level);
	    if (!$level || !$levelObj || !$levelObj->getId())
	    {
		return false;
	    }

	    $vehicleFinder = new VF_Vehicle_Finder($this->schema());
	    $vehicle = $vehicleFinder->findByLevel($level, $levelObj->getId());
	} catch (Elite_Vaf_Exception_DefinitionNotFound $e)
	{
	    return false;
	}
	return $vehicle;
    }

    function clearSelection()
    {
	foreach ($this->schema()->getLevels() as $level)
	{
	    if (isset($_SESSION[$level]))
	    {
		unset($_SESSION[$level]);
	    }
	}
    }

    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
	return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }

    function schema()
    {
	return new VF_Schema();
    }

    function setConfig($config)
    {
	$this->config = $config;
    }

    function getConfig()
    {
        if(!$this->config)
        {
            return Elite_Vaf_Helper_Data::getInstance()->getConfig();
        }
	return $this->config;
    }

}