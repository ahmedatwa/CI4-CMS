<?php 

namespace Catalog\Controllers\Account;

use Catalog\Controllers\BaseController;
use Catalog\Models\Account\CustomerModel;
use Catalog\Models\Account\ActivityModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (! $this->customer->isLogged()) {
            return redirect()->to('account/login');
        }

        $this->document->setTitle(lang('account/dashboard.heading_title'));
        
        $customerModel = new CustomerModel();

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/dashboard.heading_title'),
            'href' => base_url('account/dashboard'),
        ];

        if ($this->customer->getID()) {
            $customer_id = $this->customer->getID();
        } else {
            $customer_id = 0;
        }

        $data['total_views']     = $customerModel->getCustomerProfileView($customer_id);
        $data['text_greeting']   = sprintf(lang('account/dashboard.text_greeting'), $this->customer->getUserName());

        $data['header']        = view_cell("\Catalog\Controllers\Common\Header::index");
        $data['menu']          = view_cell("\Catalog\Controllers\Common\Menu::index");
        $data['column_right']  = view_cell("\Catalog\Controllers\Common\Column_right::index");
        $data['column_left']   = view_cell("\Catalog\Controllers\Common\Column_left::index");
        $data['footer']        = view_cell("\Catalog\Controllers\Common\Footer::index");
        
        lang('account/dashboard');

        return $this->template->render('account/dashboard', $data);
    }

    public function activities()
    {  
        if ($this->customer->getID()) {
            $customer_id = $this->customer->getID();
        } else {
            $customer_id = 0;
        }

        if ($this->request->getVar('limit')) {
            $limit = $this->request->getVar('limit');
        } else {
            $limit = 8;
        }

        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        } else {
            $page = 1;
        }
 
        $filter_data = [
            'customer_id' => $customer_id,
            'limit'       => $limit,
            'start'       => ($page - 1) * $limit,
        ];
        // news Feed
        $data['news_feeds'] = [];

        $activityModel = new ActivityModel();
        $customerModel = new CustomerModel();

        $results = $activityModel->getActivitiesByCustomerID($filter_data);
        $total = $activityModel->getTotalActivitiesByCustomerID($filter_data);

        foreach ($results as $result) {
            if (substr($result['key'], 0, 6) != 'admin_') {
                $info = json_decode($result['data'], true);

                $comment = vsprintf(lang('account/activity.text_activity_' . $result['key']), $info);

                $username  = '';

                if (isset($info['freelancer_id'])) {
                    $username = $customerModel->where('customer_id', $info['freelancer_id'])->findColumn('username')[0];
                } elseif (isset($info['employer_id'])) {
                    $username = $customerModel->where('customer_id', $info['employer_id'])->findColumn('username')[0];
                }

                $milestone_status = '';

                switch (isset($info['milestone_status'])) {
                    case 0: $milestone_status  = 'Pending'; break;
                    case 1: $milestone_status  = 'Approved'; break;
                    case 2: $milestone_status  = 'Paid'; break;
                    case 3: $milestone_status  = 'Canceled'; break;
                    default: $milestone_status = 'Pending'; break;
                }

                $find = [
                    'url=',
                    'freelancer_id=',
                    'milestone_status=',
                ];

                $replace = [
                    isset($info['url']) ? $info['url'] : '',
                    '@' . $username,
                    $milestone_status,
                ];

                $data['news_feeds'][] = [
                    'comment'    => str_replace($find, $replace, $comment),
                    'date_added' => $this->dateDifference($result['date_added'])
                ];
            }
        }

        $data['text_no_results'] = lang($this->locale . '.text_no_results');

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = ($total <= $limit) ? '' : $pager->makeLinks($page, $limit, $total, 'default_simple');

        return view('account/blocks/dashboard_activity', $data);
    }

    public function chart()
    {
        $json = [];

        $customerModel = new CustomerModel();

        $results = $customerModel->getBalanceByMonth($this->customer->getID());

        if ($results) {
            foreach ($results as $key => $value) {
                $json['labels'][]        = $value['month'];
                $json['data']['total'][] =  $value['total'];
            }
        } else {
            $json['labels'][]        = 0;
            $json['data']['total'][] = 0;
        }
    
        return $this->response->setJSON($json);
    }

    //--------------------------------------------------------------------
}
