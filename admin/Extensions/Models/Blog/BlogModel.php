<?php

namespace Extensions\Models\Blog;

use CodeIgniter\Model;

class BlogModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'blog_post';
    protected $primaryKey       = 'post_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['category_id', 'user_id', 'title', 'slug', 'body', 'image', 'status', 'published_at'];
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'date_added';
    protected $updatedField  = 'date_modified';
    protected $deletedField  = '';

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = ['afterInsert'];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = ['afterUpdate'];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function afterInsert(array $data)
    {
        if (isset($data['id'])) {
            $eventData = [
                'user_group_id' => $data['id'],
                'name'          => $data['data']['name'],
            ];

            \CodeIgniter\Events\Events::trigger('user_activity_add', 'blog_add', $eventData);
        }
        return $data;
    }

    protected function afterUpdate(array $data)
    {
        if (isset($data['data']) && isset($data['id'])) {
            $eventData = [
                'user_group_id' => $data['id'][0],
                'name'          => $data['data']['name'],
            ];

            \CodeIgniter\Events\Events::trigger('user_activity_update', 'blog_edit', $eventData);
        }
        return $data;
    }

    public function getTags()
    {
        $builder = $this->db->Table('blog_tags');
        $builder->select()
                ->where('status', 1);
        $query = $builder->get();
        return $query->getResultArray();
    }

    // Categories
    public function getCategories()
    {
        $builder = $this->db->table('blog_category');
        $builder->where('status', 1);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getCategory(int $category_id)
    {
        $builder = $this->db->table('blog_category');
        $builder->select()
                ->where([
                        'status' => 1,
                        'category_id' => $category_id
                ]);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function addCategory(array $data)
    {
        $builder = $this->db->Table('blog_category');
        $data = [
            'name'        => $data['name'],
            'status'      => 1,
    ];
        $builder->insert($data);
    }

    public function editCategory(int $category_id, array $data)
    {
        $builder = $this->db->Table('blog_category');
        $data = [
            'name'        => $data['name'],
            'status'      => 1,
    ];
        $builder->where('category_id', $category_id);
        $builder->update($data);
    }

    public function deleteCategory(int $category_id)
    {
        $builder = $this->db->Table('blog_category');
        $builder->delete([
                'category_id' => $category_id
        ]);
    }

    // Comments
    public function getComments()
    {
        $builder = $this->db->Table('blog_comment');
        return $builder->get()
                       ->getResultArray();
    }

    public function getComment(int $comment_id)
    {
        $builder = $this->db->table('blog_comment');
        $builder->select()
                ->where('comment_id', $comment_id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function editComment(int $comment_id, array $data)
    {
        $builder = $this->db->Table('blog_comment');
        $builder->set('status', 1)
                ->where('comment_id', $comment_id)
                ->update();
    }

    public function install(string $tableName)
    {
        $forge = \Config\Database::forge();
        if ($tableName == 'post') {
            $postTable = [
                'post_id' => [
                        'type'           => 'INT',
                        'constraint'     => '11',
                        'auto_increment' => true
                ],
                'user_id' => [
                        'type'       => 'INT',
                        'constraint' => '11',
                ],
                'category_id' => [
                        'type'       => 'INT',
                        'constraint' => 11,
                ],
                'title' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 255,
                ],
                'slug' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 255,
                ],
                'body' => [
                        'type' => 'TEXT',
                ],
                'tags' => [
                        'type'  => 'TEXT',
                ],
                'image' => [
                        'type' => 'VARCHAR',
                        'constraint' => 255,
                ],
                'featured' => [
                        'type'       => 'TINYINT',
                        'constraint' => 1,
                ],
                'trending' => [
                        'type'       => 'TINYINT',
                        'constraint' => 1,
                ],
                'status' => [
                        'type'       => 'TINYINT',
                        'constraint' => 1,
                ],
                'date_added' => [
                        'type' => 'DATETIME',
                ],
                'date_modified' => [
                        'type' => 'DATETIME',
                ],
        ];

            $forge->addField($postTable);
            $forge->addPrimaryKey('post_id');
            $forge->createTable('blog_post', true);
        }

        if ($tableName == 'category') {
            $categoryTable = [
                'category_id' => [
                        'type'           => 'INT',
                        'constraint'     => '11',
                        'auto_increment' => true
                ],
                'name' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 255,
                ],
                'status' => [
                        'type'       => 'TINYINT',
                        'constraint' => 1,
                ],
             ];

            $forge->addField($categoryTable);
            $forge->addPrimaryKey('category_id');
            $forge->createTable('blog_category', true);
        }
        if ($tableName == 'comment') {
            $commentTable = [
                'comment_id' => [
                        'type'           => 'INT',
                        'constraint'     => '11',
                        'auto_increment' => true
                ],
                'post_id' => [
                        'type'       => 'INT',
                        'constraint' => '11',
                ],
                'name' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 32,
                ],
                'email' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 64,
                ],
                'website' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 64,
                ],
                'comment' => [
                        'type' => 'TEXT',
                ],
                'status' => [
                        'type'       => 'TINYINT',
                        'constraint' => 1,
                ],
                'date_added' => [
                        'type'     => 'INT',
                        'unsigned' => true,
                        'null'     => false
                ],
            ];

            $forge->addField($commentTable);
            $forge->addPrimaryKey('comment_id');
            $forge->createTable('blog_comment', true);
        }
    }

    public function uninstall(string $tableName)
    {
        $forge = \Config\Database::forge();
        $forge->dropTable('blog_' . $tableName, true);
    }

    // -----------------------------------------------------------------
}
