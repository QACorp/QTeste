<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Domain\Projects\Configuration\DomainConfigurationProject;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(sprintf('CREATE SCHEMA %s', DomainConfigurationProject::getDatabaseSchema()));
        Schema::create(sprintf('%s.project',DomainConfigurationProject::getDatabaseSchema()), function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_projects');
    }
};
