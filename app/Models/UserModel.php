<?php 
namespace App\Models;

use CodeIgniter\Model;
use App\Entities\User;


class UserModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['username', 'password','created_at', 'updated_at', 'deleted_at'];
    protected $returnType = User::class;
    protected $useTimestamps = true;
    protected $dateFormat           = 'datetime';
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
    protected $updatedField = 'updated_at';
    protected $createdField = 'created_at';
    protected $hidden = ['password', 'deleted_at'];
    protected $afterFind = ['prepareOutput'];
    
    public function prepareOutput(array $data) {

        // if the hidden array is empty, we just return the original dta
        if (sizeof($this->hidden) == 0) return $data;

        // if no data was found we return the original data to ensure the right structure
        if (!$data['data']) return $data;

        $resultData = [];

        // We want the found data to be an array, so we can loop through it.
        // find() and first() return only one data item, not an array
        if (($data['method'] == 'find') || ($data['method'] == 'first')) {
            $data['data'] = [$data['data']];
        }

        if ($data['data']) {
            foreach ($data['data'] as $dataItem) {
                foreach ($this->hidden as $attributeToHide) {
                    // here we hide the unwanted attributes, but we need to check if the return type of the model is an array or an object/entity
                    if (is_array($dataItem)) {
                        unset($dataItem[$attributeToHide]);
                    } else {
                        unset($dataItem->{$attributeToHide});
                    }
                }
                array_push($resultData, $dataItem);
            }
        }

        // return the right data structure depending on the method used
        if (($data['method'] == 'find') || ($data['method'] == 'first')) {
            return ['data' => $resultData[0]];
        } else {
            return ['data' => $resultData];
        }
    }

}