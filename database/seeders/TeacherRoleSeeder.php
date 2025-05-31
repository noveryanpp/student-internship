<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class TeacherRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);

        $teacherRole->givePermissionTo([
            'view_student',
            'view_any_student',
            'view_teacher',
            'view_any_teacher',
            'view_industry',
            'view_any_industry',
            'view_internship',
            'view_any_internship',
        ]);
    }
}
