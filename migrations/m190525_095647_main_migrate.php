<?php

use yii\db\Migration;

class m190525_095647_main_migrate extends Migration
{
    public function safeUp()
    {
        $this->createTable('roles', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
        ]);
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull(),
            'password' => $this->string(255)->notNull(),
            'role_id' => $this->integer()->notNull()->defaultValue(2),
        ]);
        $this->createTable('buildings', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
        ]);
        $this->createTable('floors', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'building_id' => $this->integer(),
        ]);
        $this->createTable('sensors', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'floor_id' => $this->integer(),
        ]);
        $this->createTable('users_to_sensors', [
            'user_id' => $this->integer()->notNull(),
            'sensor_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-users-role_id',
            'users',
            'role_id'
        );
        $this->addForeignKey(
            'fk-users-role_id',
            'users',
            'role_id',
            'roles',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            'idx-floor_id',
            'floors',
            'building_id'
        );
        $this->addForeignKey(
            'fk-floor_id',
            'floors',
            'building_id',
            'buildings',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            'idx-sensor_id',
            'sensors',
            'floor_id'
        );
        $this->addForeignKey(
            'fk-sensor_id',
            'sensors',
            'floor_id',
            'floors',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            'idx-users_to_sensors-user_id',
            'users_to_sensors',
            'user_id'
        );
        $this->addForeignKey(
            'fk-users_to_sensors-user_id',
            'users_to_sensors',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            'idx-users_to_sensors-sensor_id',
            'users_to_sensors',
            'sensor_id'
        );
        $this->addForeignKey(
            'fk-users_to_sensors-sensor_id',
            'users_to_sensors',
            'sensor_id',
            'sensors',
            'id',
            'CASCADE'
        );
        $this->insert(
            'roles',
            ['name' => 'admin']
        );
        $this->insert(
            'roles',
            ['name' => 'user']
        );
        $this->insert(
            'roles',
            ['name' => 'user']
        );
        $this->insert(
            'users',
            [
                'username' => 'admin',
                'password' => '7c4a8d09ca3762af61e59520943dc26494f8941b',// 123456
                'role_id' => 1,
            ]
        );

        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $this->insert(
                'users',
                [
                    'username' => $faker->userName,
                    'password'=> $faker->password,
                    'role_id' => 2
                ]
            );
            $this->insert(
                'buildings',
                ['name' => $faker->address]
            );
        }
        for ($i = 1; $i <= 50; $i++) {
            $this->insert(
                'floors',
                [
                    'name' => $faker->numberBetween(0, 25),
                    'building_id' => (int)$faker->numberBetween(1, 10)
                ]
            );
        }
        for ($j = 1; $j <= 300; $j++) {
            $this->insert(
                'sensors',
                [
                    'name' => $faker->text(10) . '#' . $faker->numberBetween(1, 600),
                    'floor_id' => (int)$faker->numberBetween(1, 50)
                ]
            );
        }
        for ($j = 1; $j <= 100; $j++) {
            $this->insert(
                'users_to_sensors',
                [
                    'user_id' => (int)$faker->numberBetween(2, 11),
                    'sensor_id' => (int)$faker->numberBetween(1, 300)
                ]
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-users_to_sensors-sensor_id',
            'users_to_sensors'
        );
        $this->dropIndex(
            'idx-users_to_sensors-sensor_id',
            'users_to_sensors'
        );
        $this->dropForeignKey(
            'fk-users_to_sensors-user_id',
            'users_to_sensors'
        );
        $this->dropIndex(
            'idx-users_to_sensors-user_id',
            'users_to_sensors'
        );
        $this->dropForeignKey(
            'fk-sensor_id',
            'sensors'
        );
        $this->dropIndex(
            'idx-sensor_id',
            'sensors'
        );
        $this->dropForeignKey(
            'fk-floor_id',
            'floors'
        );
        $this->dropIndex(
            'idx-floor_id',
            'floors'
        );
        $this->dropForeignKey(
            'fk-role_id',
            'users'
        );
        $this->dropIndex(
            'idx-role_id',
            'users'
        );


        $this->dropTable('users');
        $this->dropTable('roles');
        $this->dropTable('buildings');
        $this->dropTable('floors');
        $this->dropTable('sensors');
        $this->dropTable('users_to_sensors');
    }
}
