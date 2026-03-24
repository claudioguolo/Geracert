<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuariosSeeder extends Seeder
{
    public function run()
    {
        $email = (string) (getenv('SEED_ADMIN_EMAIL') ?: 'admin@geracert.local');
        $nome = (string) (getenv('SEED_ADMIN_NOME') ?: 'Administrador');
        $senha = (string) (getenv('SEED_ADMIN_PASSWORD') ?: 'admin123456');

        $data = [
            'nome' => $nome,
            'email' => $email,
            'permissoes' => 'admin',
            'senha' => password_hash($senha, PASSWORD_DEFAULT),
            'deleted_at' => null,
        ];

        $existing = $this->db->table('usuarios')
            ->where('email', $email)
            ->get()
            ->getRowArray();

        if ($existing !== null) {
            $this->db->table('usuarios')
                ->where('id', $existing['id'])
                ->update(array_merge($data, ['updated_at' => date('Y-m-d H:i:s')]));

            return;
        }

        $this->db->table('usuarios')->insert(array_merge($data, [
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]));
    }
}
