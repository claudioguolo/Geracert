<?php

namespace App\Services;

class AuthorizationService
{
    private const ROLE_CAPABILITIES = [
        'admin' => [
            'admin.dashboard',
            'certificado.manage',
            'certconfig.manage',
            'clube.manage',
        ],
        'editor' => [
            'admin.dashboard',
            'certificado.manage',
            'certconfig.manage',
        ],
    ];

    public function rolesFromString(?string $permissions): array
    {
        if ($permissions === null) {
            return [];
        }

        $roles = preg_split('/[\s,;|]+/', strtolower(trim($permissions))) ?: [];
        $roles = array_values(array_unique(array_filter($roles, static fn (string $role): bool => $role !== '')));

        return $roles;
    }

    public function abilitiesForRoles(array $roles): array
    {
        $abilities = [];

        foreach ($roles as $role) {
            if (isset(self::ROLE_CAPABILITIES[$role])) {
                $abilities = [...$abilities, ...self::ROLE_CAPABILITIES[$role]];
                continue;
            }

            // Permite capacidades explícitas gravadas diretamente no campo permissoes.
            if (str_contains($role, '.')) {
                $abilities[] = $role;
            }
        }

        return array_values(array_unique($abilities));
    }

    public function can(?string $permissions, string $ability): bool
    {
        $roles = $this->rolesFromString($permissions);

        if (in_array('admin', $roles, true)) {
            return true;
        }

        return in_array($ability, $this->abilitiesForRoles($roles), true);
    }

    public function any(?string $permissions, array $abilities): bool
    {
        foreach ($abilities as $ability) {
            if ($this->can($permissions, $ability)) {
                return true;
            }
        }

        return false;
    }

    public function rolesLabel(?string $permissions): string
    {
        $roles = $this->rolesFromString($permissions);

        if ($roles === []) {
            return 'sem perfil';
        }

        return implode(', ', $roles);
    }
}
