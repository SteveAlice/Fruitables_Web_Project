<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSiteMetaDescriptionLengthInYourTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ChangeSiteMetaDescriptionLengthInYourTable', function (Blueprint $table) {
            $table->string('site_meta_description', 500)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Nếu cần, bạn cũng có thể thực hiện thay đổi ngược lại ở đây
    }
}
