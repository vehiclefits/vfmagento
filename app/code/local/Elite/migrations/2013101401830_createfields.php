<?php

use Phinx\Migration\AbstractMigration;

class CreateFields extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     *
     * Uncomment this method if you would like to use it.
     *
    public function change()
    {
    }
    */
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $schema = $this->fetchRow("select * from elite_schema where `key` = 'levels' && id=1");
        $levels = $schema['value'];
        foreach(explode(',',$levels) as $level) {

            $level = str_replace(' ', '_', $level);

            $this->table('elite_1_mapping')->addColumn($level, 'string')->save();
            $this->table('elite_1_definition')->addColumn($level, 'string')->save();
        }
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        throw new Exception('cant reverse this migration!');
    }
}