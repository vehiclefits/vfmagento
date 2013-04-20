<?php
class VF_Schema_Generator
{
    public $levels = array();
    public $level_options = array();
    
    const NEWLINE = "\n";
    
    const VERSION = 25;
    
    function __construct()
    {
        $this->db = new Elite_Vaf_Db;
    }
    
    function execute( $levels, $showProgress = false )
    {
        if( 1 >= count($levels) )
        {
            throw new VF_Level_Exception('Schema requires at least two levels');
        }
        
        $sql = $this->generator( $levels );
        foreach( explode( ';', $sql ) as $sql )
        {
            $sql = trim( $sql );
            if( !empty( $sql ) )
            {
                if( $showProgress )
                {
                    echo '.';
                }
                try
                {
                    $this->query( $sql );
                }
                catch( Exception $e )
                {
                    echo $sql; echo $e->getMessage(); exit();
                }
            }
        }
    }
    
    function generator( $levels )
    {
        $this->levels = $levels;
        $return = '';
        $this->enforceUniquenessOnLevel(0);
        for( $i = 0; $i < $this->levelCount(); $i++ )
        {
            $return .= $this->createLevel( $i );
        }
        $return .= $this->createMappingsTable();
        $return .= $this->addUniqueOnMappingsTable();
        
        $return .= $this->createDefinitionTable();
        $return .= $this->addUniqueOnDefinitionsTable();
        
        $return .= $this->createSchemaTable();
        $return .= $this->createVersionTable();
        
        if( file_exists(ELITE_PATH.'/Vafwheel') )
        {
            $generator = new Elite_Vafwheel_Model_Schema_Generator();
            $return .= $generator->generator($levels);
        }
        if( file_exists(ELITE_PATH.'/Vafwheeladapter') )
        {
            $generator = new Elite_Vafwheeladapter_Model_Schema_Generator();
            $return .= $generator->generator($levels);
        }
        if( file_exists(ELITE_PATH.'/Vaftire') )
        {
            $generator = new Elite_Vaftire_Model_Schema_Generator();
            $return .= $generator->generator($levels);
        }
        if( file_exists(ELITE_PATH.'/Vafpaint') )
        {
            $generator = new Elite_Vafpaint_Model_Schema_Generator();
            $return .= $generator->generator($levels);
        }
        if( file_exists(ELITE_PATH.'/Vafnote') )
        {
            $generator = new Elite_Vafnote_Model_Schema_Generator();
            $return .= $generator->generator($levels);
        }
        if( file_exists(ELITE_PATH.'/Vafimporter') )
        {
            $generator = new VF_Import_Schema_Generator();
            $return .= $generator->generator($levels);
        }
        if( file_exists(ELITE_PATH.'/Vafgarage') )
        {
            $generator = new Elite_Vafgarage_Model_Schema_Generator();
            $return .= $generator->generator($levels);
        }
        if( file_exists(ELITE_PATH.'/Vafdiagram') )
        {
            $generator = new Elite_Vafdiagram_Model_Schema_Generator();
            $return .= $generator->generator($levels);
        }
        
        return $return;
    }
    
    function dropExistingTables()
    {
        foreach( $this->getEliteTables() as $table )
        {
            $this->query( sprintf( 'DROP TABLE `%s`', $table ) );
        }
    }
    
    function getEliteTables()
    {
        $tables = array();
        // put the "levels" tables first so they get truncated first to satisfy referential integrity
        foreach($this->levels() as $level)
        {
            array_push( $tables,'elite_' . $level );
        }
        $result = $this->query( "SHOW TABLES LIKE 'elite_%'" );
        while( $table = $result->fetchColumn() )
        {
            if( !in_array($table, $tables))
            {
                array_push( $tables, $table );
            }
        }
        $result->closeCursor();
        return $tables;
    }
    
    function setSorting($level, $direction )
    {
        $key = $level.'_sorting';
        $this->getReadAdapter()->delete('elite_schema','`key`='.$this->getReadAdapter()->quote($key));
        $this->getReadAdapter()->insert('elite_schema',array('key'=>$key,'value'=>$direction));
    }
    
    protected function createLevel( $i )
    {
        $return = sprintf(
            'CREATE TABLE IF NOT EXISTS `elite_level_%d_%s` (',
            $this->id(),
            $this->getLevel($i)
        ) . self::NEWLINE;
            $return .= '`id` int(255) NOT NULL AUTO_INCREMENT,' . self::NEWLINE;
            $return .= '`title` varchar(255) NOT NULL,' . self::NEWLINE;
            $return .= $this->createForeignKeyIntoPreviousLevel($i);
            $return .= 'PRIMARY KEY (`id`),' . self::NEWLINE;
            $return .= 'KEY `title` (`title`)' . self::NEWLINE;
        $return .= ') ENGINE=InnoDB DEFAULT CHARSET=utf8;' . self::NEWLINE;
        $return .= $this->indexForeignKeyIntoPreviousLevel($i);
        
        return $return;
    }
    
    protected function createForeignKeyIntoPreviousLevel( $i )
    {
        if( !$this->getPreviousLevel( $i ) )
        {
            return '';
        }
        return sprintf(
            '`%s_id` int(255) NOT NULL,',
            $this->getPreviousLevel( $i )
        ) . self::NEWLINE;
    }
    
    protected function enforceUniquenessOnLevel( $i )
    {
        return sprintf(
            'ALTER TABLE `elite_level_%d_%s` ADD UNIQUE (`title`);',
            $this->id(),
            $this->getLevel( $i )
        ) . self::NEWLINE;
    }
    
    protected function indexForeignKeyIntoPreviousLevel( $i )
    {
        if( !$this->getPreviousLevel($i) )
        {
            return '';
        }
        return sprintf(
            'ALTER TABLE `elite_level_%d_%s` ADD INDEX ( `%s_id` );',
            $this->id(),
            $this->getLevel($i),
            $this->getPreviousLevel($i)
        ) . self::NEWLINE;
    }
    
    protected function getPreviousLevel( $i )
    {
        return $this->getLevel( $i - 1 );
    }
    
    protected function createMappingsTable()
    {
        $return = sprintf('CREATE TABLE IF NOT EXISTS `elite_%d_mapping` (',$this->id());
            $return .= '`id` int(50) NOT NULL AUTO_INCREMENT,';
            $return .= $this->columns();
            $return .= '`entity_id` int(25) NOT NULL,';
            $return .= '`universal` int(1) NOT NULL COMMENT \'if there is a row with this flag set for a product ( entity_id ) then it should be returned universally for all vehicles\',';
            $return .= '`related` int(1) NOT NULL,';
	    $return .= 'PRIMARY KEY (`id`),';
            $return .= 'KEY `universal` (`universal`),';
            $return .= $this->keys();
        $return .= ') ENGINE=InnoDB CHARSET=utf8;';

	$return .= sprintf('ALTER TABLE `elite_%d_mapping` ADD `price` FLOAT NOT NULL ;',$this->id());
        $return .= sprintf('ALTER TABLE `elite_%d_mapping` ADD INDEX ( `entity_id` ) ;',$this->id());
        
        return $return;
    }
    
    protected function createDefinitionTable()
    {
        $return = sprintf("CREATE TABLE IF NOT EXISTS `elite_%d_definition` (",$this->id());
          $return .= "`id` int(50) NOT NULL AUTO_INCREMENT,";
        $return .= $this->columns();
        $return .= "PRIMARY KEY (`id`),";
        $return .= $this->keys();
        $return .= ") ENGINE=InnoDB CHARSET=utf8;; ";
        return $return;
    }

    function addUniqueOnDefinitionsTable()
    {
        $levels = array();
        foreach( $this->levels() as $level )
        {
            $level = str_replace(' ', '_', $level);
            $levels[] = sprintf( '`%s_id`', $level );
        }
        $levels = implode( ',', $levels );
        return sprintf("ALTER TABLE `elite_%d_definition` ADD UNIQUE ( %s );",$this->id(),$levels);
    }
    
    function addUniqueOnMappingsTable()
    {
        $levels = array();
        foreach( $this->levels() as $level )
        {
            $level = str_replace(' ', '_', $level);
            $levels[] = sprintf( '`%s_id`', $level );
        }
        $levels[] = 'universal';
        $levels[] = 'entity_id';
        $levels = implode( ',', $levels );
        return sprintf("ALTER TABLE `elite_%d_mapping` ADD UNIQUE ( %s );",$this->id(),$levels);
    }
    
    function createSchemaTable()
    {
        $return = "CREATE TABLE `elite_schema` (`id` int(11) NOT NULL AUTO_INCREMENT, `key` VARCHAR( 25 ) NOT NULL , `value` VARCHAR( 255 ) NOT NULL, PRIMARY KEY (`id`) ) ENGINE = InnoDB CHARSET=utf8;";
        $return .= sprintf(
            "INSERT INTO `elite_schema` ( `id`, `key`, `value` ) VALUES ( 1, 'levels', %s );",
            $this->getReadAdapter()->quote( $this->levelsDelimByComma() )
        );
        
        foreach($this->levels() as $level)
        {
            if( $this->isRoot($level) || $this->isGlobal($level) )
            {
                $return .= sprintf(
                    "INSERT INTO `elite_schema` ( `key`, `value` ) VALUES ( %s, %d );",
                    $this->getReadAdapter()->quote( $level . '_global' ),
                    true
                );
            }
        }
        return $return;
    }
    
    function isRoot($level)
    {
        foreach( $this->levels() as $eachLevel )
        {
            if( $eachLevel == $level )
            {
                return true;
            }
            return false;
        }
    }
    
    function levelsDelimByComma()
    {
        return implode(',', $this->levels());
    }
    
    function createVersionTable()
    {
        return "CREATE TABLE IF NOT EXISTS `elite_version` ( `version` int(5) NOT NULL ) ENGINE=InnoDb; INSERT INTO `elite_version` (`version`) VALUES (" . self::VERSION . ");";
    }
    
    protected function keys()
    {
        $i = 0;
        $return = '';
        foreach( $this->levels() as $level )
        {
            $i++;
            $return .= $this->key( $level );
            if( $i < $this->levelCount() )
            {
                $return .= ',';
            }
        }
        return $return;
    }
    
    protected function key( $level )
    {
        $level = str_replace(' ', '_', $level);
        return sprintf( 'KEY `%s_id` (`%s_id`)', $level, $level );
    }
    
    protected function columns()
    {
        $return = '';
        foreach( $this->levels() as $level )
        {
            $level = str_replace(' ', '_', $level);
            $return .= sprintf( '`%s_id` int(15) NOT NULL,', $level );
        }
        return $return;
    }
    
    function getLevel( $i )
    {
        $levels = $this->levels();
        $level = isset( $levels[ $i ] ) ? $levels[ $i ] : false;
        $level = str_replace(' ', '_', $level);
        return $level;
    }
    
    function leafLevel()
    {
        $levels = $this->levels();
        return $levels[ $this->levelCount() - 1 ];
    }
    
    function levelCount()
    {
        return count( $this->levels() );
    }
    
    function levels()
    {
        $this->levels = (array)$this->levels;
        $levels = array();
        foreach($this->levels as $key => $level )
        {
            if(is_array($level))
            {
                $levelString = $key;
                $this->level_options[$levelString] = $level;
            }
            else
            {
                $levelString = $level;
            }
            array_push($levels, $levelString);
        }
        return $levels;
    }
    
    function isGlobal($level)
    {
        return isset( $this->level_options[$level]['global'] ) && $this->level_options[$level]['global'];
    }
    
    function tablePrefix()
    {
        if(!method_exists('Mage', 'getConfig'))
        {
            return '';
        }
        return (string)Mage::getConfig()->getTablePrefix();
    }
    
    function query( $sql )
    {
        return $this->getReadAdapter()->query( $sql );
    }
    
    /** @return Zend_Db_Adapter_Abstract */
    function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
    
    function id()
    {
        return 1;
    }
}