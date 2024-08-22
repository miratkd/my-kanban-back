<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Staudenmeir\LaravelMergedRelations\Facades\Schema;
use App\Models\User;
// use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::createMergeView(
            'friends_view',
            [(new User())->acceptedFriendsTo(), (new User())->acceptedFriendsFrom()]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
