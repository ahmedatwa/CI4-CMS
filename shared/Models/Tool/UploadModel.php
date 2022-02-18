<?php 

namespace Shared\Models\Tool;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class UploadModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'upload';
    protected $primaryKey       = 'upload_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['project_id', 'customer_id', 'filename', 'ext', 'type', 'size', 'code'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'date_added';
    protected $updatedField  = '';
    protected $deletedField  = '';

    // Callbacks
    protected $allowCallbacks = false;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // --------------------------------------------
}
