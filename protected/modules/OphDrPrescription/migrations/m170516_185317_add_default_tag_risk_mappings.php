<?php

class m170516_185317_add_default_tag_risk_mappings extends CDbMigration
{
	public function safeUp()
	{
        $this->execute("INSERT IGNORE INTO `tag` (`name`) VALUES ('Anticoagulant'),('Alpha-blocker')");
        $this->execute("UPDATE `tag` SET
                          risk_id = (SELECT `risk`.`id` FROM `risk` WHERE `risk`.`name`='Anticoagulants')
                          WHERE `tag`.`name`='Anticoagulant'");

        $this->execute("UPDATE `tag` SET
                          risk_id = (SELECT `risk`.`id` FROM `risk` WHERE `risk`.`name`='Alpha blockers')
                          WHERE `tag`.`name`='Alpha-blocker'");

    }

	public function safeDown()
	{
        $this->execute("UPDATE `tag` SET
                          risk_id = NULL
                          WHERE `tag`.`name` IN ('Alpha-blocker','Anticoagulant')");
	}

}