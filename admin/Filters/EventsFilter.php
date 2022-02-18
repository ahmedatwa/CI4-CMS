<?php

namespace Admin\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Shared\Models\Setting\EventsModel;
use CodeIgniter\Events\Events;
use Config\Services;

class EventsFilter implements FilterInterface
{
    /**
     *
     * @param RequestInterface|\CodeIgniter\HTTP\IncomingRequest $request
     * @param array|null                                         $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        /**
        * register all controllers events before action being triggered.
        * and send it to config/Events to fire all found events
        */
        if ($segments = $request->uri->getSegments()) {
            if (in_array($segments[0], config('App')->supportedLocales)) {
                unset($segments[0]);
            }

            $route = ucwords(implode('\\', $segments), '\\');

            if ($request->getUserAgent()->isBrowser()) {
                $userAgent = $request->getUserAgent()->getBrowser().' '.$request->getUserAgent()->getVersion();
            } elseif ($request->getUserAgent()->isRobot()) {
                $userAgent = $request->getUserAgent()->robot();
            } elseif ($request->getUserAgent()->isMobile()) {
                $userAgent = $request->getUserAgent()->getMobile();
            } else {
                $userAgent = 'Unidentified User Agent';
            }

            if ($request->getMethod() == 'post' && Services::user()->getID()) {
                $eventsModel = new EventsModel();

                $eventData = [
                    'user_id'     => Services::user()->getID(),
                    'username'    => Services::user()->getUserName(),
                    'user_agent'  => $userAgent,
                    'platform'    => $request->getUserAgent()->getPlatform(),
                    'ip'          => $request->getIPAddress(),
                ];

                $results = $eventsModel->where([
                    'status'  => 1,
                    'trigger' => '\\' . APP_NAMESPACE . '\Controllers\\' . $route . '\\before',
                ])->findAll();
                if ($results) {
                    foreach ($results as $result) {
                        if (substr($result['trigger'], 0, strlen(APP_NAMESPACE) + 1) == ('\\' . APP_NAMESPACE)) {
                            Events::trigger($result['code'], $eventData);
                        }
                    }
                }
            }
        }
    }

    //--------------------------------------------------------------------

    /**
     *
     * @param RequestInterface|\CodeIgniter\HTTP\IncomingRequest $request
     * @param ResponseInterface|\CodeIgniter\HTTP\Response       $response
     * @param array|null                                         $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        /**
        * register all controllers events after action being triggered.
        * and send it to config/Events to fire all found events
        */
        if ($segments = $request->uri->getSegments()) {
            if (in_array($segments[0], config('App')->supportedLocales)) {
                unset($segments[0]);
            }

            $route = ucwords(implode('\\', $segments), '\\');

            if ($request->getUserAgent()->isBrowser()) {
                $userAgent = $request->getUserAgent()->getBrowser().' '.$request->getUserAgent()->getVersion();
            } elseif ($request->getUserAgent()->isRobot()) {
                $userAgent = $request->getUserAgent()->robot();
            } elseif ($request->getUserAgent()->isMobile()) {
                $userAgent = $request->getUserAgent()->getMobile();
            } else {
                $userAgent = 'Unidentified User Agent';
            }

            if ($request->getMethod() == 'post' && Services::user()->getID()) {
                $eventsModel = new EventsModel();

                $eventData = [
                    'user_id'     => Services::user()->getID(),
                    'username'    => Services::user()->getUserName(),
                    'user_agent'  => $userAgent,
                    'platform'    => $request->getUserAgent()->getPlatform(),
                    'ip'          => $request->getIPAddress(),
                ];

                $results = $eventsModel->where([
                    'status'  => 1,
                    'trigger' => '\\' . APP_NAMESPACE . '\Controllers\\' . $route . '\\after',
                ])->findAll();
                if ($results) {
                    foreach ($results as $result) {
                        if (substr($result['trigger'], 0, strlen(APP_NAMESPACE) + 1) == ('\\' . APP_NAMESPACE)) {
                            Events::trigger($result['code'], $eventData);
                        }
                    }
                }
            }
        }
    }
    // ----------------------------------------------
}
