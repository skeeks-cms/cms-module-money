<?php
/**
 * m150120_100558_create_table__money_currency
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 25.01.2015
 * @since 1.0.0
 */
use yii\db\Schema;
use yii\db\Migration;

class m150120_100558_create_table__money_currency extends Migration
{
    public function safeUp()
    {
        $table = "{{%money_currency}}";

        $tableExist = $this->db->getTableSchema($table, true);
        if ($tableExist) {
            return true;
        }

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable($table, [
            'id' => $this->primaryKey(),

            'code' => $this->string(3)->notNull()->unique(),
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',

            'name' => Schema::TYPE_STRING . '(255) NULL',
            'name_full' => Schema::TYPE_STRING . '(255) NULL',
            'course' => $this->decimal(10,6)->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->createIndex('money_currency__status', $table, 'status');
        $this->createIndex('money_currency__course', $table, 'course');
        $this->createIndex('money_currency__name_full', $table, 'name_full');
        $this->createIndex('money_currency__name', $table, 'name');
    }

    public function down()
    {
        $this->dropTable("{{%money_currency}}");
    }
}
