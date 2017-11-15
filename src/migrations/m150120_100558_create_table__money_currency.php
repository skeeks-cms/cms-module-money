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
    public function up()
    {
        $tableExist = $this->db->getTableSchema("{{%money_currency}}", true);
        if ($tableExist) {
            return true;
        }

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable("{{%money_currency}}", [
            'id' => Schema::TYPE_PK,

            'code' => Schema::TYPE_STRING . '(3) NOT NULL',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10', //статус, активна некативна, удалено

            'name' => Schema::TYPE_STRING . '(255) NULL', //статус, активна некативна, удалено
            'name_full' => Schema::TYPE_STRING . '(255) NULL', //статус, активна некативна, удалено
            'course' => Schema::TYPE_STRING . '(255) NULL', //статус, активна некативна, удалено

        ], $tableOptions);

        $this->execute("ALTER TABLE {{%money_currency}} ADD UNIQUE(code);");
        $this->execute("ALTER TABLE {{%money_currency}} ADD INDEX(status);");
        $this->execute("ALTER TABLE {{%money_currency}} ADD INDEX(course);");
        $this->execute("ALTER TABLE {{%money_currency}} ADD INDEX(name_full);");
        $this->execute("ALTER TABLE {{%money_currency}} ADD INDEX(name);");

        $this->execute("ALTER TABLE {{%money_currency}} COMMENT = 'Валюты';");

    }

    public function down()
    {
        $this->dropTable("{{%money_currency}}");
    }
}
