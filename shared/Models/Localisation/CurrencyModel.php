<?php

namespace Shared\Models\Localisation;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class CurrencyModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'currency';
    protected $primaryKey       = 'currency_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['title', 'code', 'symbol_left', 'symbol_right', 'value', 'status', 'fraction', 'date_modified'];
    // Dates
    protected $useTimestamps    = true;
    protected $dateFormat       = 'int';
    protected $createdField     = 'date_added';
    protected $updatedField     = 'date_modified';
    protected $deletedField     = '';

    // Callbacks
    protected $allowCallbacks   = true;
    protected $beforeInsert     = [];
    protected $afterInsert      = ['afterInsert'];
    protected $beforeUpdate     = [];
    protected $afterUpdate      = ['afterUpdate'];
    protected $beforeFind       = [];
    protected $afterFind        = [];
    protected $beforeDelete     = [];
    protected $afterDelete      = ['afterDelete'];

    protected function afterInsert(array $data)
    {
        if (service('registry')->get('config_currency_auto')) {
            $this->refresh(service('registry')->get('config_currency'));
        }

        cache()->delete('CURRENCY');
    }

    protected function afterUpdate(array $data)
    {
        cache()->delete('CURRENCY');
    }

    protected function afterDelete(array $data)
    {
        if ($data['result']) {
            cache()->delete('CURRENCY');
        }
    }

    public function getCurrencyByCode($currency)
    {
        $builder = $this->db->table('currency');
        $builder->distinct();
        $builder->where('code', $currency);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function getCurrencies($data = [])
    {
        if ($data) {
            $builder = $this->db->table('currency');
            $builder->select();

            if (isset($data['start']) || isset($data['limit'])) {
                if ($data['start'] < 0) {
                    $data['start'] = 0;
                }
                if ($data['limit'] < 1) {
                    $data['limit'] = 20;
                }
                $builder->limit($data['limit'], $data['start']);
            }

            $query = $builder->get();
            return $query->getResultArray();
        } else {
            $currency_data = cache()->get('currency');

            if (! $currency_data) {
                $currency_data = [];
                $builder = $this->db->table('currency');
                $builder->select();
                $builder->orderBy('title', 'ASC');
                $query = $builder->get();
                foreach ($query->getResultArray() as $result) {
                    $currency_data[$result['code']] = [
                        'currency_id'   => $result['currency_id'],
                        'title'         => $result['title'],
                        'code'          => $result['code'],
                        'symbol_left'   => $result['symbol_left'],
                        'symbol_right'  => $result['symbol_right'],
                        'value'         => $result['value'],
                        'status'        => $result['status'],
                        'date_modified' => $result['date_modified']
                    ];
                }

                cache()->save('CURRENCY', $currency_data);
            }

            return $currency_data;
        }
    }

    public function refresh(string $default = 'EUR')
    {
        $currency_data = [];

        $client = \Config\Services::curlrequest();

        $request = $client->request('POST', 'http://data.fixer.io/api/latest?access_key=95dd47e556d581360e59d3d16575f5c7');

        $response = $request->getBody();

        $response_info = json_decode($response, true);

        if (is_array($response_info) && isset($response_info['rates'])) {
            $currencies = [];

            $currencies['EUR'] = 1.0000;

            foreach ($response_info['rates'] as $key => $value) {
                $currencies[$key] = $value;
            }

            if ($currencies) {
                foreach ($this->getCurrencies() as $result) {
                    if (isset($currencies[$result['code']])) {
                        $from = $currencies['EUR'];

                        $to = $currencies[$result['code']];

                        $this->editValueByCode($result['code'], 1 / ($currencies[$default] * ($from / $to)));
                    }

                    $this->editValueByCode($default, 1);

                    cache()->delete('CURRENCY');
                }
            }
        }
    }

    public function editValueByCode(string $code, $value)
    {
        $builder = $this->db->table('currency');
        $builder->set('value', $value);
        $builder->set('date_modified', Time::now()->getTimestamp());
        $builder->where('code', $code);
        $builder->update();
        cache()->delete('CURRENCY');
    }

    // -----------------------------------------------------------------
}
