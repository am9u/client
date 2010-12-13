<?php defined('SYSPATH') or die('No direct script access.');

class ServiceClient_User extends ServiceClient
{
    protected $_client_type = 'api_writer';

    const TOKEN_NAME   = 'token';
    const USERNAME_KEY = 'username';
    const PASSWORD_KEY = 'password';

    public function identify($credentials=NULL)
    {
        Kohana::$log->add('ServiceClient_User->identify()', 'called!');

        $resource_uri = 'user/identify';

        // idenfity by auth token
        if( ! empty($credentials[self::TOKEN_NAME]))
        {
            $data = $this->_request(self::HTTP_POST, $resource_uri, Arr::extract($credentials, array(
                    self::TOKEN_NAME
                )));
        }

        // identify by username/password combination
        elseif( ! empty($credentials[self::USERNAME_KEY]) AND ! empty($credentials[self::PASSWORD_KEY]))
        {
            $data = $this->_request(self::HTTP_POST, $resource_uri, Arr::extract($credentials, array(
                    self::USERNAME_KEY, 
                    self::PASSWORD_KEY,
                )));
        }

        $this->data = new ServiceClient_Driver_User($data->user);
    }

    public function create($user_data=NULL)
    {
        $resource_uri = 'user/create';
        $data = $this->_request(self::HTTP_POST, $resource_uri, $user_data);
    }

}