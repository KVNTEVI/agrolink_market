<?php

namespace Database\Factories;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Utilisateur>
 */
class UtilisateurFactory extends Factory
{
    protected $model = Utilisateur::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $avatars = [
        'avatar1.png', 
        'avatar2.png', 
        'avatar3.png', 
        'avatar4.png', 
        'avatar5.png',
        'avatar6.png', 
        'avatar7.png', 
        'avatar8.png', 
        'avatar9.png', 
        'avatar10.png'
    ];

       return [
        'nom' => $this->faker->name(),
        'email' => $this->faker->unique()->safeEmail(),
        'password' => Hash::make('password'),
        'telephone' => $this->faker->phoneNumber(),
        'adresse' => $this->faker->address(),
        'role_id' => 3, // On force le rôle producteur ici
        'image' => $this->faker->randomElement($avatars),
    ];
    }
}
