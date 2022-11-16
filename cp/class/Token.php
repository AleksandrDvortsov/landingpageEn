<?php
class Token{
    protected $prefix;
    protected $keyPair;
    protected $storage;

    public function __construct($prefix = 'csrf',&$storage = null)
    {
        $this->prefix = rtrim($prefix, '_');
        $this->storage = &$storage;
    }

    public function getTokenNameKey()
    {
        return $this->prefix . '_name';
    }

    public function getTokenValueKey()
    {
        return $this->prefix . '_value';
    }

    public function validateStorage()
    {
        if (is_array($this->storage)) {
            return $this->storage;
        }

        if ($this->storage instanceof ArrayAccess) {
            return $this->storage;
        }

        if (!isset($_SESSION)) {
            throw new RuntimeException('CSRF middleware failed. Session not found.');
        }
        if (!array_key_exists($this->prefix, $_SESSION)) {
            $_SESSION[$this->prefix] = [];
        }
        $this->storage = &$_SESSION[$this->prefix];

        // Aici controlam marimea Sesiei pentru paramentrul csrf,
        // marimea masivului 50 token-uri, dacai mai mare atunci primul element al masivului se sterge
        if(count($this->storage) > 50)
        {
            $array = $this->storage;
            reset($array);
            $first_key = key($array);
            $this->removeFromStorage($first_key);
        }

        return $this->storage;
    }


    public function generateToken()
    {
        $this->validateStorage();
        // Generate new CSRF token
        $name = base64_encode(openssl_random_pseudo_bytes(32));
        $value = base64_encode(openssl_random_pseudo_bytes(32));
        $this->saveToStorage($name, $value);

        $this->keyPair = [
            $this->prefix . '_name' => $name,
            $this->prefix . '_value' => $value
        ];

        return $this->keyPair;
    }

    protected function saveToStorage($name, $value)
    {
        $this->storage[$name] = $value;
    }

    protected function editTokenValue($name)
    {
        $value = base64_encode(openssl_random_pseudo_bytes(32));
        $this->storage[$name] = $value;
    }

    protected function removeFromStorage($name)
    {
        $this->storage[$name] = ' ';
        unset($this->storage[$name]);
    }

    public function validateToken($request)
    {
        $result = false;

        $this->validateStorage();
        if(isset($request) && is_array($request))
        {
            $request_token_name = '';
            $request_token_value = '';
            foreach($request as $key_v => $value_v)
            {
                if(!empty($value_v))
                {

                    $exp = explode('CSRF-', $key_v);
                    if(isset($exp[1]) && !empty($exp[1]))
                    {
                        $request_token_name=$exp['1'];
                        $request_token_value = $request[$key_v];
                        break;
                    }
                }
            }



            $name = $request_token_name;
            $value = $request_token_value;
            $token = $this->getFromStorage($name);
           // show(array($name,$value,$token));
            if (function_exists('hash_equals')) {
                $result = ($token !== false && hash_equals($token, $value));
            } else {
                $result = ($token !== false && $token === $value);
            }

            // edit current token value
            $this->editTokenValue($request_token_name);
        }


        return array("result" => $result, "new_token_value" => $this->storage[$request_token_name]);
    }

    protected function getFromStorage($name)
    {
        return isset($this->storage[$name]) ? $this->storage[$name] : false;
    }

    public function generateHiddenField() {
        $token = $this->generateToken();
        $token_name = 'CSRF-'.$token[$this->prefix . '_name'];
        $token_value = $token[$this->prefix . '_value'];
        return "<input class=\"form_token\"  type=\"hidden\" name=\"$token_name\" value=\"$token_value\" />";
    }

}
