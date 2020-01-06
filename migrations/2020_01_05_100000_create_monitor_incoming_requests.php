<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitorIncomingRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitor_incoming_requests', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('request_method');
            $table->string('request_url');
            $table->string('request_path');
            $table->string('controller_action')->nullable();
            $table->unsignedInteger('response_status');
            $table->unsignedInteger('query_count');
            $table->unsignedInteger('duration');
            $table->unsignedInteger('memory');
            $table->timestamps();

            $table->index('controller_action');
            $table->index('response_status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monitor_incoming_requests');
    }
}
