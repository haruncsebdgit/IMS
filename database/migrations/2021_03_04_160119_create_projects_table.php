<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->string('project_id_en', 100);
            $table->string('project_id_bn', 100);
            $table->string('project_code_1', 100)->nullable()->unique();
            $table->string('project_code_2', 100)->nullable()->unique();
            $table->string('project_name_en', 500);
            $table->string('project_name_bn', 500);
            $table->text('objective')->nullable();
            $table->string('project_period_en', 100)->nullable();
            $table->string('project_period_bn', 100)->nullable();
            $table->tinyInteger('is_approved')->default(0);
            $table->string('project_director_en', 500)->nullable();
            $table->string('project_director_bn', 500)->nullable();
            $table->string('ministry_en', 500)->nullable();
            $table->string('ministry_bn', 500)->nullable();
            $table->string('division_en', 500)->nullable();
            $table->string('division_bn', 500)->nullable();
            $table->string('implementation_org_en', 200)->nullable();
            $table->string('implementation_org_bn', 200)->nullable();
            $table->decimal('estimated_expense_bdt', $precision = 8, $scale = 2)->nullable();
            $table->decimal('estimated_expense_usd', $precision = 8, $scale = 2)->nullable();
            $table->decimal('fund_contribution_bdt', $precision = 8, $scale = 2)->nullable();
            $table->decimal('fund_contribution_usd', $precision = 8, $scale = 2)->nullable();
            $table->text('comments')->nullable();
            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');

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
        Schema::dropIfExists('projects');
    }
}
