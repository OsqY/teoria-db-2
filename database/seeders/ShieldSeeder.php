<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_autor","view_any_autor","create_autor","update_autor","restore_autor","restore_any_autor","replicate_autor","reorder_autor","delete_autor","delete_any_autor","force_delete_autor","force_delete_any_autor","view_categoria","view_any_categoria","create_categoria","update_categoria","restore_categoria","restore_any_categoria","replicate_categoria","reorder_categoria","delete_categoria","delete_any_categoria","force_delete_categoria","force_delete_any_categoria","view_compra","view_any_compra","create_compra","update_compra","restore_compra","restore_any_compra","replicate_compra","reorder_compra","delete_compra","delete_any_compra","force_delete_compra","force_delete_any_compra","view_devolucion","view_any_devolucion","create_devolucion","update_devolucion","restore_devolucion","restore_any_devolucion","replicate_devolucion","reorder_devolucion","delete_devolucion","delete_any_devolucion","force_delete_devolucion","force_delete_any_devolucion","view_donacion","view_any_donacion","create_donacion","update_donacion","restore_donacion","restore_any_donacion","replicate_donacion","reorder_donacion","delete_donacion","delete_any_donacion","force_delete_donacion","force_delete_any_donacion","view_editorial","view_any_editorial","create_editorial","update_editorial","restore_editorial","restore_any_editorial","replicate_editorial","reorder_editorial","delete_editorial","delete_any_editorial","force_delete_editorial","force_delete_any_editorial","view_libro","view_any_libro","create_libro","update_libro","restore_libro","restore_any_libro","replicate_libro","reorder_libro","delete_libro","delete_any_libro","force_delete_libro","force_delete_any_libro","view_prestamo","view_any_prestamo","create_prestamo","update_prestamo","restore_prestamo","restore_any_prestamo","replicate_prestamo","reorder_prestamo","delete_prestamo","delete_any_prestamo","force_delete_prestamo","force_delete_any_prestamo","view_proveedor","view_any_proveedor","create_proveedor","update_proveedor","restore_proveedor","restore_any_proveedor","replicate_proveedor","reorder_proveedor","delete_proveedor","delete_any_proveedor","force_delete_proveedor","force_delete_any_proveedor","view_venta","view_any_venta","create_venta","update_venta","restore_venta","restore_any_venta","replicate_venta","reorder_venta","delete_venta","delete_any_venta","force_delete_venta","force_delete_any_venta"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
