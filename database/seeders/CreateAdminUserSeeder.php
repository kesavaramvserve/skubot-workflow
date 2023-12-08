<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'Super', 
            'last_name' => 'Admin',
            'status'    => 1,
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        $vserve_client = User::create([
            'first_name' => 'Client', 
            'last_name' => 'Vserve',
            'status' => 1,
            'email' => 'testing03@vserve.co',
            'password' => bcrypt('12345678')
        ]);

        Client::create([
            'user_id' => $vserve_client->id, 
            'company_name' => 'Vserve',
            'website' => 'Default',
        ]);
    
        $role = Role::create(['name' => 'Super Admin']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);

        $role = Role::create(['name' => 'PM']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);

        $role = Role::create(['name' => 'Client']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $vserve_client->assignRole([$role->id]);

        $role = Role::create(['name' => 'Team Lead']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);

        $role = Role::create(['name' => 'PA']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);

        $role = Role::create(['name' => 'QC']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);

        $role = Role::create(['name' => 'DA']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);

        $role = Role::create(['name' => 'QA']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
    }
}
