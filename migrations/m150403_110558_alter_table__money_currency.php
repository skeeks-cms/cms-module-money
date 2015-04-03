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
        $this->execute("UPDATE {{%money_currency}} SET `status` = '0' ");
        $this->execute("ALTER TABLE {{%money_currency}} CHANGE `status` `status` SMALLINT(1) NOT NULL DEFAULT '0';");
    }

    public function down()
    {
        echo "m150122_273205_alter_table__cms_user__emails_adn_phones cannot be reverted.\n";
        return false;
    }
}
