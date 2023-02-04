<?php

namespace Catalog\Controllers\Common;

use Catalog\Controllers\BaseController;
use CodeIgniter\HTTP\URI;
use Shared\Models\Localisation\CurrencyModel;

class Currency extends BaseController
{
    public function index()
    {
        if ($this->request->getCookie(config('App')->cookiePrefix . 'currency')) {
            $code = hex2bin($this->request->getCookie(config('App')->cookiePrefix . 'currency'));
        } else {
            $code = $this->registry->get('config_currency');
        }

        $data['currency_code'] = $code;

        $uri = '';
        // get URI Object parts
        $path      = $this->request->uri->getPath();
        $query     = $this->request->uri->getQuery();
        $scheme    = $this->request->uri->getScheme();
        $authority = $this->request->uri->getAuthority();
        $fragment  = $this->request->uri->getFragment();
        
        $uri = URI::createURIString($scheme, $authority, $path, $query, $fragment);

        $data['currencies'] = [];

        $currencyModel = new CurrencyModel();
        $results = $currencyModel->getCurrencies();

        foreach ($results as $result) {
            if ($result['status']) {    
                $data['currencies'][] = [
                    'title'        => $result['title'],
                    'code'         => $result['code'],
                    'symbol_left'  => $result['symbol_left'],
                    'symbol_right' => $result['symbol_right'],
                    'href'         => base_url('common/currency/save?code=' . $result['code'] . '&redirect=' . urlencode($uri)),
                ];
            }
        }

        lang('common/currency');

        return $this->template->render('common/currency', $data);
    }

    public function save()
    {
        if ($this->request->getVar('code')) {
            $code = (string) $this->request->getVar('code');
        } else {
            $code = $this->registry->get('config_currency');
        }

        if ($this->request->getVar('redirect')) {
            $redirect = $this->request->getVar('redirect');
        } else {
            $redirect = '';
        }
        
        $cookie = [
            'name'     => 'currency',
            'value'    => bin2hex($code),
            'expire'   => '86500',
            'domain'   => config('App')->cookieDomain,
            'path'     => config('App')->cookiePath,
            'prefix'   => config('App')->cookiePrefix,
            'secure'   => config('App')->cookieSecure,
            'httponly' => config('App')->cookieHTTPOnly,
            'samesite' => config('App')->cookieSameSite
        ];

        $this->response->setCookie($cookie);

        if ($redirect && substr($redirect, 0, strlen(base_url())) == base_url()) {
            return redirect()->to($redirect)->withCookies();
        } else {
            return redirect('/')->withCookies();
        }
    }

    //--------------------------------------------------------------------
}
