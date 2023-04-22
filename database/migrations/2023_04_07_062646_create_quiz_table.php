<?php

use App\Models\Quiz;
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
        Schema::create('quiz', function (Blueprint $table) {
            $table->id();
            $table->string('quiz', 1000);
            $table->integer('status');
            $table->timestamps();
        });

        $quizes = array(
            'What about you?',
            'Have you travelled as a solo traveller before? If so, how many times and which
            countries did you visit early?',
            'What motivated you to travel alone?',
            'How do you get to know about your place?',
            'How did you make this travel? And how are you managing all the travelling expenses?',
            'Have you experienced bad things/ risks during your solo travel?',
            'Do you like to travel alone throughout your travel, or will you join other groups or
            strangers whom you will meet at your destination?',
            'Why do you think that you want to travel alone?',
            'Have you chosen solo travel by default or through choice?',
            'What are the natural characteristics of a solo traveller?',
            'How did you connect yourself with solo travel?',
            'Solo travel can be daunting - how can first-timers get
            confidence quickly?',
            'When did you first start travelling solo? How has it
            changed your life?',
            'How do solo travellers identify themselves in the liminal
            time between the decision to travel alone and beginning
            solo travel?',
            'How do solo travellers identify themselves in the liminal
            time between the end of the solo travel and reaching their
            home?',
            'What kind of activities were you involved in during your
            travel? How did those activities relate to your life before
            travelling, and how would they affect your travel?',
            'What critical moments may trigger solo travellers to
            identify their new selves during their solo travel? And
            how did you handle everything by yourself at a new
            place?',
            'How do solo travellers reflect the new changes in
            themselves in their self-(re)presentation during their solo
            travel?',
            'How does the liminal position on culture and gender
            influence the solo travellers self-(re)presentation during
            their solo travel?',
            'How do solo travellers present themselves on online
            social networks?',
        );



        foreach ($quizes as $quiz) {
            Quiz::create([
                'quiz' => $quiz,
                'status' => 1,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz');
    }
};
