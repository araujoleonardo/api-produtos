<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = [
            ['name' => 'Admin', 'email' => 'admin@teste.com', 'password' => Hash::make('admin123')],
            ['name' => 'Usuário', 'email' => 'usuario@teste.com', 'password' => Hash::make('usuario123')],
        ];

        foreach ($user as $row) {
            // Verifica se o registro já existe na tabela
            if (!DB::table('users')->where('email', $row['email'])->exists()) {
                DB::table('users')->insert($row);
            }
        }

        $categories = [
            ['name' => 'Limpeza'],
            ['name' => 'Alimentação'],
            ['name' => 'Eletrônicos'],
            ['name' => 'Roupas'],
            ['name' => 'Calçados'],
            ['name' => 'Saúde'],
            ['name' => 'Beleza'],
            ['name' => 'Móveis'],
            ['name' => 'Brinquedos'],
            ['name' => 'Esportes'],
            ['name' => 'Ferramentas'],
            ['name' => 'Jardim'],
            ['name' => 'Automotivo'],
            ['name' => 'Livros'],
            ['name' => 'Acessórios'],
            ['name' => 'Informática'],
            ['name' => 'Higiene Pessoal'],
            ['name' => 'Pet Shop'],
            ['name' => 'Cama, Mesa e Banho'],
            ['name' => 'Construção'],
            ['name' => 'Música'],
            ['name' => 'Cozinha'],
            ['name' => 'Papelaria'],
            ['name' => 'Arte e Craft'],
            ['name' => 'Decoração'],
            ['name' => 'Saúde e Bem-Estar'],
            ['name' => 'Moda'],
            ['name' => 'Cultura'],
            ['name' => 'Supermercado'],
            ['name' => 'Jóias e Relógios'],
            ['name' => 'Gourmet'],
            ['name' => 'Fitness'],
            ['name' => 'Tecnologia'],
        ];

        foreach ($categories as $category) {
            $category['created_at'] = Carbon::now();
            $category['updated_at'] = Carbon::now();
            // Verifica se o registro já existe na tabela
            if (!DB::table('categories')->where('name', $category['name'])->exists()) {
                DB::table('categories')->insert($category);
            }
        }
    }
}
