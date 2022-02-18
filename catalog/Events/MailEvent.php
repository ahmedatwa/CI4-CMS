<?php 

namespace Catalog\Events;

use Catalog\Models\Account\ActivityModel;
use Catalog\Models\Account\CustomerModel;
use CodeIgniter\I18n\Time;

class MailEvent
{

    // Catalog\Controllers\Account\Login::authLogin
    public static function mailLoginAlert() {

    }

    // Catalog\Model\Account\CustomerModel\editCode
    public static function forgottenMail(string $email, string $code)
    {
        $config = \Config\Services::email();

        $data['text_subject']     = sprintf(lang('mail/forgotten.text_greeting'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $data['text_welcome']     = lang('mail/forgotten.text_welcome');
        $data['text_body']        = lang('mail/forgotten.text_body');
        $data['text_body_append'] = lang('mail/forgotten.text_body_append');
        $data['text_body_last']   = lang('mail/forgotten.text_body_last');
        $data['config_name']      = service('registry')->get('config_name');
        $data['config_address']   = service('registry')->get('config_address');
        $data['button_reset']     = lang('mail/forgotten.button_reset');
        
        $data['link'] = str_replace('&amp;', '&', base_url('account/reset?code=' . $code));

        $request = \Config\Services::request();

        $data['ip'] = $request->getIPAddress();

        $config->setFrom(service('registry')->get('config_email'));

        $config->setTo($email);

        $config->setSubject(html_entity_decode(sprintf(lang('mail/forgotten.text_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8'));
        
        $config->setMessage(view('mail/forgotten', $data));

        $config->send();
    }

    // Catalog\Model\Account\CustomerModel\addCustomer
    public static function addCustomer(string $email)
    {
        $config = \Config\Services::email();

        $data['text_subject'] = sprintf(lang('mail/register.text_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $data['text_welcome'] = sprintf(lang('mail/register.text_welcome'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $data['text_login']   = lang('mail/register.text_login');
        $data['text_service'] = lang('mail/register.text_service');
        $data['text_thanks']  = lang('mail/register.text_thanks');
        $data['text_signature']  = sprintf(lang('mail/register.text_signature'), service('registry')->get('config_name'));

        $data['config_name']      = service('registry')->get('config_name');
        $data['config_address']   = service('registry')->get('config_address');

        $config->setFrom(service('registry')->get('config_email'));

        $config->setTo($email);

        $config->setSubject(html_entity_decode(sprintf(lang('mail/register.text_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8'));

        $config->setMessage(view('mail/register', $data));

        $config->send();
    }
    
    // Catalog\Model\Catalog\ProjectModel\addProject
    public static function addProject(array $data)
    {
        $config = \Config\Services::email();
        $customerModel = new CustomerModel();
        $customer_info = $customerModel->find($data['employer_id']);

        $data['text_new_subject'] = sprintf(lang('mail/project_alert.text_new_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $data['text_new']         = sprintf(lang('mail/project_alert.text_new'), $data['name']);
        $data['text_thank']       = lang('mail/project_alert.text_thank');
        $data['text_signature']   = sprintf(lang('mail/project_alert.text_signature'), service('registry')->get('config_name'));
        
        $data['config_name']      = service('registry')->get('config_name');
        $data['config_address']   = service('registry')->get('config_address');
        

        $config->setFrom(service('registry')->get('config_email'));

        $config->setTo($customer_info['email']);

        $config->setSubject(html_entity_decode(sprintf(lang('mail/project_alert.text_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8'));
        $config->setMessage(view('mail/new_project_alert', $data));

        $config->send();
    }


    // Catalog\Model\Freelancer\FreelancerModel::updateProjectStatus
    public static function updateProjectStatus(int $project_id, int $freelancer_id, int $employer_id)
    {
        $config = \Config\Services::email();

        $customerModel = new CustomerModel();
        $seo_url = service('seo_url');

        $customer_info = $customerModel->find($employer_id);
        

        $keyword = $seo_url->getKeywordByQuery('project_id=' . $project_id);

        $data['text_subject']    = sprintf(lang('mail/project_alert.text_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $data['text_received']   = sprintf(lang('mail/project_alert.text_received'), route_to('single_project', $project_id, $keyword));
        $data['text_pay']        = lang('mail/project_alert.text_pay');
        $data['text_thank']      = lang('mail/project_alert.text_thank');
        $data['text_signature']  = sprintf(lang('mail/project_alert.text_signature'), service('registry')->get('config_name'));

        $data['config_name']      = service('registry')->get('config_name');
        $data['config_address']   = service('registry')->get('config_address');


        $config->setFrom(service('registry')->get('config_email'));

        $config->setTo($customer_info['email']);

        $config->setSubject(html_entity_decode(sprintf(lang('mail/project_alert.text_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8'));
        $config->setMessage(view('mail/project_status_alert', $data));

        $config->send();
    }

    // Catalog\Model\Account\CustomerModel\AddCustomer
    public static function PaymentMail(array $data)
    {
        $config = \Config\Services::email();
        $customerModel = new CustomerModel();

        $data['text_subject']    = sprintf(lang('mail/payment_alert.text_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $data['text_received']   = sprintf(lang('mail/payment_alert.text_received'), $data['project_id']);
        $data['text_amount']     = sprintf(lang('mail/payment_alert.text_amount'), $data['amount']);

        $data['config_name']      = service('registry')->get('config_name');
        $data['config_address']   = service('registry')->get('config_address');


        $config->setFrom(service('registry')->get('config_email'));

        $config->setTo($customerModel->find($data['freelancer_id'])['email']);

        $config->setSubject(html_entity_decode(sprintf(lang('mail/payment_alert.text_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8'));
        
        $config->setMessage(view('mail/payment_alert', $data));

        $config->send();
    }

    // Catalog\Model\Extension\Bid\BidModel::addBid
    public static function addBid(array $data)
    {
        $config = \Config\Services::email();
        $customerModel = new CustomerModel();

        $data['text_subject']    = sprintf(lang('mail/bid_alert.text_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $data['text_bid']        = lang('mail/bid_alert.text_bid');
        $data['text_login']      = sprintf(lang('mail/bid_alert.text_login'));

        $data['config_name']      = service('registry')->get('config_name');
        $data['config_address']   = service('registry')->get('config_address');


        $config->setFrom(service('registry')->get('config_email'));

        $config->setTo($customerModel->find($data['freelancer_id'])['email']);

        $config->setSubject(html_entity_decode(sprintf(lang('mail/bid_alert.text_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8'));
        
        $config->setMessage(view('mail/bid_alert', $data));

        $config->send();
    }

    // Catalog\Controllers\Customer\Customer::authLogin
    public static function loginAlertMail(array $args)
    {
        $config = \Config\Services::email();
        $customerModel = new CustomerModel();
        $myTime = Time::now();

        $data['text_subject']  = sprintf(lang('mail/login_alert.text_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $data['text_welcome']  = sprintf(lang('mail/login_alert.text_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $data['text_platform'] = sprintf(lang('mail/login_alert.text_platform'), $args['platform']);
        $data['text_time']     = sprintf(lang('mail/login_alert.text_time'), lang('en.fullDate', [$myTime]));
        $data['text_browser']  = sprintf(lang('mail/login_alert.text_browser'), $args['browser']);

        $data['text_body']  = sprintf(lang('mail/login_alert.text_body'), base_url('account/forgotten'));

        $data['config_name']    = service('registry')->get('config_name');
        $data['config_address'] = service('registry')->get('config_address');
        
        $data['text_thanks']    = lang('mail/login_alert.text_thanks');
        $data['text_signature'] = sprintf(lang('mail/login_alert.text_signature'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8'));

        $config->setFrom(service('registry')->get('config_email'));

        $config->setTo($customerModel->find($args['customer_id'])['email']);

        $config->setSubject(html_entity_decode(sprintf(lang('mail/login_alert.text_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8'));
        
        $config->setMessage(view('mail/login_alert', $data));

        $config->send();

    }

    // Catalog\Model\Account\CustomerModel\editCode
    public static function twoStepVerify(string $email, string $code)
    {
        $config = \Config\Services::email();

        $data['text_subject']     = sprintf(lang('mail/verify.text_greeting'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $data['text_welcome']     = lang('mail/verify.text_welcome');
        $data['text_body']        = sprintf(lang('mail/verify.text_body'), $code, service('registry')->get('config_name'), route_to('contact'));
        $data['text_signature']   = sprintf(lang('mail/verify.text_signature'), service('registry')->get('config_name'));
        
        $config->setFrom(service('registry')->get('config_email'));

        $config->setTo($email);

        $config->setSubject(html_entity_decode(sprintf(lang('mail/verify.text_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8'));
        
        $config->setMessage(view('mail/verify', $data));

        $config->send();
    }
    // --------------------------------------------------
}
