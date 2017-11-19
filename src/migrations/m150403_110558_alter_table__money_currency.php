<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 03.04.2015
 */

use yii\db\Schema;
use yii\db\Migration;

class m150403_110558_alter_table__money_currency extends Migration
{
    public function safeUp()
    {
        $this->update('{{%money_currency}}', [
            'status' => 0
        ]);

        if ($this->db->driverName == 'pgsql') {
            $this->alterColumn('{{%money_currency}}', 'status', $this->smallInteger(1));
            $this->alterColumn('{{%money_currency}}', "status", "SET NOT NULL");
            $this->alterColumn('{{%money_currency}}', "status", "SET DEFAULT 0");
        } else {
            $this->alterColumn('{{%money_currency}}', 'status', $this->smallInteger(1)->notNull()->defaultValue(0));
        }
    }

    public function down()
    {
        echo "m150122_273205_alter_table__cms_user__emails_adn_phones cannot be reverted.\n";
        return false;
    }
}
