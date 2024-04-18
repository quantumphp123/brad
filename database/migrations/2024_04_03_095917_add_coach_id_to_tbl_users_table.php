<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCoachIdToTblUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('tbl_users', function (Blueprint $table) {
            $table->unsignedBigInteger('coach_id')->nullable()->after('id');
            // Add foreign key constraint
            $table->foreign('coach_id')->references('id')->on('coaches')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_users', function (Blueprint $table) {
            // Drop foreign key constraint before dropping the column
            $table->dropForeign(['coach_id']);
            $table->dropColumn('coach_id');
        });
    }
}
