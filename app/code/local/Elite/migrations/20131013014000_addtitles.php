<?php

use Phinx\Migration\AbstractMigration;

class AddTitles extends AbstractMigration
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

            $q1 = "update elite_1_mapping m set $level = (select title from elite_level_1_{$level} l where m.{$level}_id = l.id)";
            $this->execute($q1);

            $q2 = "update elite_1_definition d set $level = (select title from elite_level_1_{$level} l where d.{$level}_id = l.id)";
            $this->execute($q2);
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