<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('website_url')->nullable();
            $table->string('logo_path')->nullable();
            $table->text('description')->nullable();
            $table->string('primary_color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->json('social_links')->nullable();
            $table->string('timezone')->default('UTC');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->json('settings')->nullable();
        });
    }

    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn([
                'website_url',
                'logo_path',
                'description',
                'primary_color',
                'secondary_color',
                'social_links',
                'timezone',
                'address',
                'phone',
                'contact_email',
                'settings'
            ]);
        });
    }
};
