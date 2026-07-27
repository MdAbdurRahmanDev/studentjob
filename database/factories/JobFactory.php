<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = ['Catering', 'Packaging', 'Delivery', 'Data Entry', 'Event Helper', 'Customer Support', 'Warehouse Assistant'];
        $locations = ['গুলশান, ঢাকা', 'খিলক্ষেত, ঢাকা', 'ধানমন্ডি, ঢাকা', 'বনানী, ঢাকা', 'মিরপুর, ঢাকা', 'উত্তরা, ঢাকা'];
        $times = ['09:00', '10:00', '14:00', '16:00', '17:00', '18:00'];
        $employers = ['ফুডপ্যান্ডা', 'পাঠাও', 'দারাজ', 'স্বপ্ন', 'মিনা বাজার', 'পিৎজা হাট', 'কেএফসি'];

        return [
            'title' => $this->faker->randomElement($titles),
            'location' => $this->faker->randomElement($locations),
            'time' => $this->faker->randomElement($times),
            'status' => 'OPEN',
            'employer_name' => $this->faker->randomElement($employers),
            'description' => 'এই শিফটে আপনাকে আমাদের টিমের সাথে কাজ করতে হবে। কাজের পরিবেশ অত্যন্ত সুন্দর এবং বন্ধুত্বপূর্ণ। আপনার কাজ হবে মূলত কাস্টমারদের সাহায্য করা এবং আমাদের ডেইলি অপারেশন স্মুথ রাখা।',
            'requirements' => "১. সময়মতো উপস্থিত থাকতে হবে।\n২. স্মার্টফোন এবং ইন্টারনেট কানেকশন থাকতে হবে।\n৩. হাসিমুখে কাস্টমারদের সাথে কথা বলতে হবে।",
            'wage' => $this->faker->randomElement(['৳২০০/ঘণ্টা', '৳২৫০/ঘণ্টা', '৳৩০০/ঘণ্টা']),
        ];
    }
}
