<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\CardTemplate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class SetupSystem extends Command
{
    protected $signature = 'system:setup';
    protected $description = 'Setup inicial do sistema de cartões';

    public function handle()
    {
        $this->info('Iniciando configuração do sistema...');

        // Executar migrações
        $this->info('Executando migrações...');
        Artisan::call('migrate', ['--force' => true]);

        // Criar usuário admin
        $this->info('Criando usuário administrador...');
        $user = User::firstOrCreate(
            ['email' => 'admin@sistema.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        if ($user->wasRecentlyCreated) {
            $this->info('✓ Usuário administrador criado: admin@sistema.com / admin123');
        } else {
            $this->info('✓ Usuário administrador já existe');
        }

        // Criar template padrão
        $template = CardTemplate::firstOrCreate(
            ['name' => 'Template Padrão'],
            [
                'width' => 85.60,
                'height' => 53.98,
                'front_fields' => [
                    'photo' => ['x' => 10, 'y' => 10, 'width' => 25, 'height' => 32],
                    'name' => ['x' => 40, 'y' => 15, 'size' => 14],
                    'position' => ['x' => 40, 'y' => 25, 'size' => 10],
                    'department' => ['x' => 40, 'y' => 32, 'size' => 10],
                    'serial' => ['x' => 10, 'y' => 45, 'size' => 8],
                ],
                'back_fields' => [
                    'qr_code' => ['x' => 55, 'y' => 10, 'size' => 25],
                    'expiry' => ['x' => 10, 'y' => 40, 'size' => 10],
                    'verification_url' => ['x' => 10, 'y' => 45, 'size' => 8],
                ],
                'is_active' => true,
            ]
        );

        if ($template->wasRecentlyCreated) {
            $this->info('✓ Template padrão criado');
        } else {
            $this->info('✓ Template padrão já existe');
        }

        // Criar link simbólico para storage
        $this->info('Criando link simbólico...');
        Artisan::call('storage:link');

        // Limpar cache
        $this->info('Limpando cache...');
        Artisan::call('config:cache');
        Artisan::call('view:cache');

        $this->info('');
        $this->info('🎉 Sistema configurado com sucesso!');
        $this->info('');
        $this->info('Credenciais de acesso:');
        $this->info('Email: admin@sistema.com');
        $this->info('Senha: admin123');
        $this->info('');
        $this->warn('⚠️  Lembre-se de alterar a senha padrão após o primeiro login!');

        return Command::SUCCESS;
    }
}
