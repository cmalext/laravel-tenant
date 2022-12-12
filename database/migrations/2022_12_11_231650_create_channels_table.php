<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->longText('description');
            $table->unsignedBigInteger('tenant_id');
            $table->timestamps();

            $table
                ->foreign('tenant_id')
                ->references('id')
                ->on('tenants')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unique(['code', 'tenant_id']);
            $table->unique(['name', 'tenant_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scenes', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
        });

        Schema::dropIfExists('series');
    }
};
