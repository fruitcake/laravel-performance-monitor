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

            $table->string('request_url');
            $table->string('request_path');
            $table->unsignedInteger('response_code');
            $table->unsignedInteger('query_count');
            $table->unsignedInteger('duration');
            $table->timestamps();

            $table->index('request_path');
            $table->index('response_code');
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
