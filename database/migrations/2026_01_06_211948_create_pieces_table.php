 <?php

 use App\Enums\PlayableStatus;
 use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pieces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collection_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('artist')->nullable();
            $table->string('lyrics_link')->nullable();
            $table->string('tutorial_link')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default(PlayableStatus::NOT_PLAYABLE_YET->value);
            $table->integer('sort')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pieces');
    }
};
