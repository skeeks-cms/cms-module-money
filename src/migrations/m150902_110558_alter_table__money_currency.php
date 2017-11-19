<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 03.04.2015
 */

use yii\db\Schema;
use yii\db\Migration;

class m150902_110558_alter_table__money_currency extends Migration
{
    public function safeUp()
    {
        return true;
    }

    public function down()
    {
        echo "m150902_110558_alter_table__money_currency cannot be reverted.\n";
        return false;
    }
}
