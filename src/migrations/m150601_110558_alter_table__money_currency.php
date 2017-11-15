<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 03.04.2015
 */
use yii\db\Schema;
use yii\db\Migration;

class m150601_110558_alter_table__money_currency extends Migration
{
    public function safeUp()
    {
        $this->execute("ALTER TABLE {{%money_currency}} DROP `status`; ");
        $this->execute("ALTER TABLE {{%money_currency}} ADD `active` CHAR(1) NOT NULL DEFAULT 'N'");
        $this->execute("ALTER TABLE {{%money_currency}} ADD INDEX(active);");
    }

    public function down()
    {
        echo "m150601_110558_alter_table__money_currency cannot be reverted.\n";
        return false;
    }
}
