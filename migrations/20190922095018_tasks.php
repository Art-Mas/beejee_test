<?php

use Beejee\Models\Task;
use Phinx\Migration\AbstractMigration;

class Tasks extends AbstractMigration
{
    public function up()
    {
        $table = $this->table(Task::tableName());
        $table->addColumn(Task::FIELD_NAME, 'string', ['limit' => 50, 'null' => false])
            ->addColumn(Task::FIELD_EMAIL, 'string', ['limit' => 50, 'null' => false])
            ->addColumn(Task::FIELD_TEXT, 'text', ['null' => true])
            ->addColumn(Task::FIELD_IS_EDITED, 'boolean', ['default' => 0])
            ->addColumn(Task::FIELD_IS_COMPLETED, 'boolean', ['default' => 0])
            ->create();
    }

    public function down()
    {
        $this->table('task')->drop()->save();
    }
}
