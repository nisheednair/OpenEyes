<?php

class m170513_114804_tag_risk_mapping extends CDbMigration
{
	public function up()
	{
        $this->addColumn('tag', 'risk_id', 'INT(11) null default null');
        $this->addColumn('tag_version', 'risk_id', 'INT(11) null default null');
        $this->createIndex('idx_tag_risk', 'tag', 'risk_id', false);
        $this->addForeignKey('tag_risk', 'tag', 'risk_id', 'risk', 'id');
	}

	public function down()
	{
	    $this->dropForeignKey('tag_risk', 'tag');
		$this->dropColumn('tag', 'risk_id');
		$this->dropColumn('tag_version', 'risk_id');
	}

}