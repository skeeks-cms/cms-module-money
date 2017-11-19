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
        $this->dropColumn('{{%money_currency}}', 'status');
        $this->addColumn('{{%money_currency}}', 'active', $this->char(1)->notNull()->defaultValue('N'));
        $this->createIndex('money_currency__active', '{{%money_currency}}', 'active');
    }

    public function down()
    {
        echo "m150601_110558_alter_table__money_currency cannot be reverted.\n";
        return false;
    }
}
