<?php

namespace Catalog\Controllers\Common;

use Catalog\Controllers\BaseController;
use CodeIgniter\HTTP\URI;
use Shared\Models\Localisation\LanguageModel;

class Language extends BaseController
{
    public function index()
    {
        if ($this->request->getCookie(config('App')->cookiePrefix . 'language')) {
            $code = hex2bin($this->request->getCookie(config('App')->cookiePrefix . 'language'));
        } else {
            $code = $this->locale;
        }

        $data['language_code'] = $code;

        $uri = '';
        // get URI Object parts
        $path      = $this->request->uri->getPath();
        $query     = $this->request->uri->getQuery();
        $scheme    = $this->request->uri->getScheme();
        $authority = $this->request->uri->getAuthority();
        $fragment  = $this->request->uri->getFragment();

        $data['languages'] = [];

        $languageModel = new LanguageModel();
        $results = $languageModel->where('status', 1)->findAll();

        foreach ($results as $result) {
            if (substr($path, 0, strlen($code)) == $code) {
                // $path for named/reverse-routed URI
                $uri = URI::createURIString($scheme, $authority, str_replace($code, $result['code'], $path), $query, $fragment);
            } else {
                // $query in normal URI
                $uri = URI::createURIString($scheme, $authority, $path, str_replace($code, $result['code'], $query), $fragment);
            }

            $data['languages'][] = [
                'name' => $result['name'],
                'code' => $result['code'],
                'href' => base_url('common/language/save?code=' . $result['code'] . '&redirect=' . urlencode($uri)),
            ];
        }

        lang('common/language');

        return $this->template->render('common/language', $data);
    }

    public function save()
    {
        if ($this->request->getVar('code')) {
            $code = (string) $this->request->getVar('code');
        } else {
            $code = $this->locale;
        }

        if ($this->request->getVar('redirect')) {
            $redirect = $this->request->getVar('redirect');
        } else {
            $redirect = '';
        }

        $cookie = [
            'name'     => 'language',
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
