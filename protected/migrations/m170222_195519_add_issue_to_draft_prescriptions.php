<?php

class m170222_195519_add_issue_to_draft_prescriptions extends CDbMigration
{
    /*
	public function up()
	{

	}
    */

	public function down()
	{
		echo "m170222_195519_add_issue_to_draft_prescriptions does not support migration down.\n";
		return false;
	}


	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("INSERT INTO event_issue (event_id, issue_id, last_modified_date, created_date, created_user_id)
                        SELECT pd.event_id, 3, pd.last_modified_date, pd.created_date, pd.created_user_id
                        FROM   et_ophdrprescription_details pd
                        WHERE  pd.draft = 1
                        AND  pd.event_id 
                          NOT IN (SELECT event_id FROM event_issue WHERE issue_id = 3);");
	}

	public function safeDown()
	{
        echo "m170222_195519_add_issue_to_draft_prescriptions does not support migration down.\n";
        return false;
	}

}