<?php 

namespace Extensions\Models\Dashboard;

use CodeIgniter\Model;

class CustomerActivityModel extends Model
{
    protected $table            = 'customer_activity';
    protected $primaryKey       = 'customer_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['key', 'data'];

    // Dates
    protected $useTimestamps    = true;
    protected $dateFormat       = 'int';
    protected $createdField     = 'date_added';
    protected $updatedField     = 'date_modified';
    protected $deletedField     = '';

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
// ----------------------------------------------------------
}