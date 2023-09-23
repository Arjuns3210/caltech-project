<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = array(
            //for staff
            array(
                'id'=>1,
                'name' => 'Staff',
                'codename' => 'staff',
                'parent_status' => 'parent',
                'status' => 'Yes',
            ),
            array(
                'id'=>2,
                'name' => 'Add',
                'codename' => 'staff_add',
                'parent_status' => 1,
                'status' => 'Yes',
            ),
            array(
                'id'=>3,
                'name' => 'Edit',
                'codename' => 'staff_edit',
                'parent_status' => 1,
                'status' => 'Yes',
            ),
            array(
                'id'=>4,
                'name' => 'View',
                'codename' => 'staff_view',
                'parent_status' => 1,
                'status' => 'Yes',
            ),
            array(
                'id'=>5,
                'name' => 'Status',
                'codename' => 'staff_status',
                'parent_status' => 1,
                'status' => 'Yes',
            ),
            array(
                'id'=>6,
                'name' => 'Delete',
                'codename' => 'staff_delete',
                'parent_status' => 1,
                'status' => 'Yes',
            ),

            //for product

            array(
                'id'=>7,
                'name' => 'Product',
                'codename' => 'product',
                'parent_status' => 'parent',
                'status' => 'Yes',
            ),
            array(
                'id'=>8,
                'name' => 'Add',
                'codename' => 'product_add',
                'parent_status' => 7,
                'status' => 'Yes',
            ),
            array(
                'id'=>9,
                'name' => 'Edit',
                'codename' => 'product_edit',
                'parent_status' => 7,
                'status' => 'Yes',
            ),
            array(
                'id'=>10,
                'name' => 'View',
                'codename' => 'product_view',
                'parent_status' => 7,
                'status' => 'Yes',
            ),
            array(
                'id'=>11,
                'name' => 'Status',
                'codename' => 'product_status',
                'parent_status' => 7,
                'status' => 'Yes',
            ),
            array(
                'id'=>12,
                'name' => 'Delete',
                'codename' => 'product_delete',
                'parent_status' => 7,
                'status' => 'Yes',
            ),

                //for client

            array(
                'id'=>13,
                'name' => 'Client',
                'codename' => 'client',
                'parent_status' => 'parent',
                'status' => 'Yes',
            ),
            array(
                'id'=>14,
                'name' => 'Add',
                'codename' => 'client_add',
                'parent_status' => 13,
                'status' => 'Yes',
            ),
            array(
                'id'=>15,
                'name' => 'Edit',
                'codename' => 'client_edit',
                'parent_status' => 13,
                'status' => 'Yes',
            ),
            array(
                'id'=>16,
                'name' => 'View',
                'codename' => 'client_view',
                'parent_status' => 13,
                'status' => 'Yes',
            ),
            array(
                'id'=>17,
                'name' => 'Status',
                'codename' => 'client_status',
                'parent_status' => 13,
                'status' => 'Yes',
            ),
            array(
                'id'=>18,
                'name' => 'Delete',
                'codename' => 'client_delete',
                'parent_status' => 13,
                'status' => 'Yes',
            ),

                //for certificate

            array(
                'id'=>19,
                'name' => 'Certificate',
                'codename' => 'certificate',
                'parent_status' => 'parent',
                'status' => 'Yes',
            ),
            array(
                'id'=>20,
                'name' => 'Add',
                'codename' => 'certificate_add',
                'parent_status' => 19,
                'status' => 'Yes',
            ),
            array(
                'id'=>21,
                'name' => 'Edit',
                'codename' => 'certificate_edit',
                'parent_status' => 19,
                'status' => 'Yes',
            ),
            array(
                'id'=>22,
                'name' => 'View',
                'codename' => 'certificate_view',
                'parent_status' => 19,
                'status' => 'Yes',
            ),
            array(
                'id'=>23,
                'name' => 'Status',
                'codename' => 'certificate_status',
                'parent_status' => 19,
                'status' => 'Yes',
            ),
            array(
                'id'=>24,
                'name' => 'Delete',
                'codename' => 'certificate_delete',
                'parent_status' => 19,
                'status' => 'Yes',
            ),
            array(
                'id'=>25,
                'name' => 'PDF',
                'codename' => 'certificate_pdf',
                'parent_status' => 19,
                'status' => 'Yes',
            ),
            array(
                'id'=>26,
                'name' => 'Email',
                'codename' => 'share_certificate',
                'parent_status' => 19,
                'status' => 'Yes',
            ),

            //for report
            array(
                'id'=>27,
                'name' => 'Report',
                'codename' => 'report',
                'parent_status' => 'parent',
                'status' => 'Yes',
            ),
            array(
                'id'=>28,
                'name' => 'dataReport',
                'codename' => 'data_report',
                'parent_status' => 27,
                'status' => 'Yes',
            ),
            array(
                'id'=>29,
                'name' => 'clientReport',
                'codename' => 'client_report',
                'parent_status' => 27,
                'status' => 'Yes',
            ),
        );

        foreach($permissions as $data){
            DB::table('permissions')->insert($data);
        }
    }
}
