<?php

namespace App\Http\Repositories;

class UserRepository
{
    private $db;

    public function __construct() {
        $this->db = app('firebase.firestore')->database();
    }

    public function index()
    {

    }

    public function bulkUpdate($agent_codes = [], $group_code = null, $unit_code = null): bool
    {
        $data = [];
        if($group_code!=null){
            array_push($data, ['path' => 'grouping', 'value' => $group_code]);
        }
        if($unit_code!=null){
            array_push($data, ['path' => 'unit_code', 'value' => $unit_code]);
        }

        $batch = $this->db->batch();
        foreach ($agent_codes as $code) {
            try {
                $ref = $this->db->collection('users')->document($code);
                if ($ref->snapshot()->exists()) {
                    $batch->update($ref, $data);
                }
            } catch (\Throwable $th) {
            }
        }
        $batch->commit();

        return true;
    }

}
