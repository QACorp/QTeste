<?php

use App\Application\Traits\MigrationTrait;
use App\Domain\Projects\Configuration\DomainConfigurationProject;
use App\Domain\Projects\Enum\CloneTypeEnum;
use App\Domain\Projects\Enum\StrategyEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use MigrationTrait;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(sprintf('CREATE SCHEMA %s', DomainConfigurationProject::getDatabaseSchema()));
        Schema::create($this->getTableName('projects',DomainConfigurationProject::getDatabaseSchema()), function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('name', 255);
            $table->json('branchs')->default(
            '{
                        "main":"master",
                        "develop":"develop",
                        "feature":"feature",
                        "hotfix":"hotfix",
                        "release":"release"
                }'
            );
            $table->enum('strategy', StrategyEnum::values());
            $table->string('url_repository', 400);
            $table->string('url_git_clone', 400);
            $table->enum('clone_type',CloneTypeEnum::values());
            $table->longText('custom_script')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
//        Schema::create($this->getTableName('releases',DomainConfigurationProject::getDatabaseSchema()), function (Blueprint $table) {
//            $table->uuid()->primary();
//            $table->dateTime('start_release');
//            $table->string('version', 255);
//            $table->bigInteger('user_id');
//            $table->boolean('update_minor');
//            $table->uuid('project_uuid');
//            $table->longText('custon_script')->nullable();
//            $table->timestamps();
//            $table->softDeletes();
//            $table->foreign('project_uuid')
//                ->on($this->getTableName('projects',DomainConfigurationProject::getDatabaseSchema()))
//                ->references('uuid');
//            $table->foreign('user_id')
//                ->on($this->getTableName('user'))
//                ->references('id');
//
//        });
//        Schema::create($this->getTableName('logs',DomainConfigurationProject::getDatabaseSchema()), function (Blueprint $table) {
//            $table->uuid()->primary();
//            $table->uuid('release_uuid');
//            $table->longText('message');
//            $table->longText('script')->nullable();
//            $table->timestamps();
//            $table->foreign('release_uuid')
//                ->on($this->getTableName('releases',DomainConfigurationProject::getDatabaseSchema()))
//                ->references('uuid');
//
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->getTableName('projects',DomainConfigurationProject::getDatabaseSchema()));
    }
};
