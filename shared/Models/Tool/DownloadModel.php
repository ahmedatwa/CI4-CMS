<?php 

namespace Shared\Models\Tool;

use CodeIgniter\Model;

class DownloadModel extends Model
{
	protected $DBGroup          = 'default';
	protected $table            = 'download';
	protected $primaryKey       = 'download_id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = ['filename'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'int';
    protected $createdField  = '';
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
    // -------------------------------------------
}
